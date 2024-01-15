<?php

namespace App\Http\Controllers;
use DB;
use App\Models\InformasiPokokBprPelapor;
use App\Models\LoanApplicant;
use App\Models\RekomendasiArr;
use App\Models\KeyRiskIssue;
use App\Models\CovenantCheckList;
use App\Models\CatatanPentingLainnya;
use App\Models\LampiranCatatanPentingLainnya;
use App\Models\LampiranFinancialHighlight;
use App\Models\ArrFinancialHighlight;
use Illuminate\Http\Request;
use PDF;

class ArrController extends Controller
{
    public function index($id)
    {
        $data = LoanApplicant::with(['master_bpr'])->where('uuid', $id)->first();
        $tanggal = date('d', strtotime($data->tanggal_nak));
        $bulan = bulan((int)date('m', strtotime($data->tanggal_nak)));
        $tahun = date('Y', strtotime($data->tanggal_nak));
        $tanggal = (int)$tanggal. ' ' .$bulan. ' '. $tahun ?? '';

        // bwmk
        $informasi_grup_usaha = $data->master_bpr[0]->informasi_grup_usaha;

        $bwmk = LoanApplicant::with(['master_bpr'=> function($query) use ($informasi_grup_usaha){
            $query->where('informasi_grup_usaha', $informasi_grup_usaha);
        }])->sum('plafond');

        $jenis_pengajuan = $data->jenis_pengajuan;

        return view('analisis-risiko-rekomendasi/index', compact('id', 'data', 'tanggal', 'bwmk', 'jenis_pengajuan'));
    }

    public function informasiDebiturDanGroup($id)
    {
        $url = 'informasi-debitur';
        $app = LoanApplicant::where('uuid', $id)->first();
        $data = InformasiPokokBprPelapor::where('sandi_bpr', $app->sandi_bpr)->first();

        return view('analisis-risiko-rekomendasi/informasi-debitur-dan-group', compact('data', 'id', 'url', 'app'));
    }

    public function informasiFasilitasKreditDebiturGroup($id)
    {
        $data = LoanApplicant::where('uuid', $id)->first();

        return view('analisis-risiko-rekomendasi/informasi-fasilitas-kredit-debitur-dan-group', compact('data', 'id'));
    }

    public function storeLoanApplicant(Request $request)
    {
        LoanApplicant::where('uuid', $request->id)->update($request->except('_token'));
        return back()->with('success', 'Berhasil simpan');
    }

    public function keyRiskIssue($id)
    {
        $cek = DB::table('key_risk_issue')->where('loan_applicant_id', $id)->first();

        $data = DB::table('master_pertanyaan')
        ->selectRaw('key_risk_issue.id as id, jawaban, risk_mitigation, pertanyaan, sub_jenis_pertanyaan, master_pertanyaan.no_urut')
        ->where('loan_applicant_id', $id)
        ->where('jenis_pertanyaan', 'Credit Risk Reviewer')
        ->leftJoin('key_risk_issue', 'key_risk_issue.risk_issue', 'master_pertanyaan.id')
        ->orderBy('no_urut')
        ->get();

        $parsing = [
            'pertanyaan'=>DB::table('master_pertanyaan')->where('jenis_pertanyaan', 'Credit Risk Reviewer')->orderBy('no_urut')->get(),
            'id'=>$id,
            'data'=>$data,
            'sandi_bpr'=>LoanApplicant::where('uuid', $id)->value('sandi_bpr'),
            'statusLevelProses' =>LoanApplicant::where('id', $id)->value('crrd_section_head'),
        ];

        if ($cek == null):
            return view('analisis-risiko-rekomendasi/key-risk-issue', $parsing);
        else:
            return view('analisis-risiko-rekomendasi/edit-key-risk-issue', $parsing);
        endif;
    }

    public function storeKeyRiskIssue(Request $request)
    {
        if($request->aksi == 'create'):

            for ($i=0; $i<count($request->risk_issue); $i++):
                DB::table('key_risk_issue')->insert([
                    'risk_mitigation'=>$request->risk_mitigation[$i] ?? '',
                    'jawaban'=>$request->jawaban[$i] ?? '',
                    'risk_issue'=>$request->risk_issue[$i] ?? '',
                    'loan_applicant_id'=>$request->loan_applicant_id,
                    'created_at'=> \Carbon\Carbon::now(),
                    'updated_at'=>\Carbon\Carbon::now(),
                ]);
            endfor;

        else:

            for ($i=0; $i<count($request->risk_issue); $i++):
                DB::table('key_risk_issue')->where('id', $request->risk_issue[$i])->update([
                    'risk_mitigation'=>$request->risk_mitigation[$i] ?? '',
                    'jawaban'=>$request->jawaban[$i] ?? '',
                ]);
            endfor;

        endif;

        return back()->with('success', 'Berhasil disimpan');
    }

    public function tambahKeyRiskIssue(Request $request)
    {
        $cek = DB::table('master_pertanyaan')
        ->select('master_pertanyaan.id')
        ->leftJoin('key_risk_issue', 'key_risk_issue.risk_issue', 'master_pertanyaan.id')
        ->whereNotIn('master_pertanyaan.id', DB::table('key_risk_issue')->select('risk_issue')->where('loan_applicant_id', $request->id))
        ->where('jenis_pertanyaan', 'Credit Risk Reviewer')
        ->get();

        foreach ($cek as $c):

            $risk_issue = $c->id;

            $parameter = array(
                'risk_issue'=>$risk_issue,
                'loan_applicant_id'=>$request->id
            );

            KeyRiskIssue::create($parameter);

        endforeach;

        return response()->json(['success'=>"Add Data Successfly."]);
    }

    public function covenantCheckList($id)
    {
        $cek = DB::table('covenant_check_list')->where('loan_applicant_id', $id)->first();

        $data = DB::table('covenant_check_list')
        ->where('loan_applicant_id', $id)
        ->selectRaw('covenant_check_list.id, covenant_check_list.keterangan, catatan, sub_jenis_pertanyaan, pertanyaan')
        ->where('jenis_pertanyaan', 'Credit Risk Reviewer')
        ->leftJoin('master_pertanyaan', 'master_pertanyaan.id', 'covenant_check_list.pertanyaan_id')
        ->get();

        $parsing = [
            'id'=>$id,
            'pertanyaan'=>DB::table('master_pertanyaan')->where('jenis_pertanyaan', 'Credit Risk Reviewer')->get(),
            'data'=>$data,
            'sandi_bpr'=>LoanApplicant::where('uuid', $id)->value('sandi_bpr'),
            'statusLevelProses'=>LoanApplicant::where('uuid', $id)->value('crrd_section_head'),
        ];

        if($cek == null):
            return view('analisis-risiko-rekomendasi/covenant-checklist', $parsing);
        else:
            return view('analisis-risiko-rekomendasi/edit-covenant-checklist', $parsing);
        endif;
    }

    public function storeCovenantCheckList(Request $request)
    {
        if($request->aksi == 'create'):

            for ($i=0; $i<count($request->pertanyaan_id); $i++):
                $insert = array (
                    'pertanyaan_id'=>$request->pertanyaan_id[$i],
                    'keterangan'=>$request->keterangan[$i],
                    'catatan'=>$request->catatan[$i],
                    'loan_applicant_id'=>$request->loan_applicant_id,
                );

                CovenantCheckList::create($insert);
            endfor;

        else:

            for ($i=0; $i<count($request->id); $i++):
                DB::table('covenant_check_list')->where('id', $request->id[$i])->update([
                    'keterangan'=>$request->keterangan[$i],
                    'catatan'=>$request->catatan[$i],
                ]);
            endfor;

        endif;

        return back()->with('success', 'Berhasil simpan');
    }

    public function catatanPentingLainnya(Request $request)
    {
        $id = $request->id;
        $data  = CatatanPentingLainnya::where('loan_applicant_id', $id)->first();
        $statusLevelProses = LoanApplicant::where('uuid', $id)->value('crrd_section_head');
        $sandi_bpr = LoanApplicant::where('uuid', $id)->value('sandi_bpr');

        return view('analisis-risiko-rekomendasi/catatan-penting-lainnya', compact('id', 'data', 'statusLevelProses', 'sandi_bpr'));
    }

    public function storeCatatanPentingLainnya(Request $request)
    {
        CatatanPentingLainnya::updateOrcreate([
            'loan_applicant_id'=>$request->loan_applicant_id,
        ],[
            'keterangan'=>$request->keterangan
        ]);

        return back()->with('success', 'Berhasil simpan data');
    }

    public function financialHiglight(Request $request)
    {
        $id = $request->id;
        $sandi_bpr = LoanApplicant::where('uuid', $id)->value('sandi_bpr');
        $statusLevelProses = LoanApplicant::where('uuid', $id)->value('crrd_section_head');
        $data =  ArrFinancialHighlight::where('loan_applicant_id', $id)->first();

        return view('analisis-risiko-rekomendasi/financial-higlight', compact('id', 'data', 'statusLevelProses', 'sandi_bpr'));
    }

    public function storeFinancialHighlight(Request $request)
    {
        ArrFinancialHighlight::updateOrcreate([
            'loan_applicant_id'=>$request->loan_applicant_id,
        ],[
            'keterangan'=>$request->keterangan
        ]);

        return back()->with('success', 'Berhasil simpan data');
    }

    public function rekomendasi($id)
    {
        $data = LoanApplicant::where('uuid', $id)->toBase()->first();
        $keterangan = RekomendasiArr::where('loan_applicant_id', $id)->first();
        $jenis_fasilitas_kredit = DB::table('fasilitas_kredits')->get();

        return view('analisis-risiko-rekomendasi/rekomendasi', compact('id', 'data', 'keterangan', 'jenis_fasilitas_kredit'));
    }

    public function storeRekomendasi(Request $request)
    {
        RekomendasiArr::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id,
        ],[
            'keterangan'=>$request->keterangan,
            'jenis_fasilitas_kredit'=>$request->jenis_fasilitas_kredit,
            'limit_fasilitas_kredit'=>preg_replace( '/[^0-9]/', '', $request->limit_fasilitas_kredit),
            'sifat_fasilitas_kredit'=>$request->sifat_fasilitas_kredit,
            'tujuan_penggunaan'=>$request->tujuan_penggunaan,
            'jangka_waktu_fasilitas_kredit'=>$request->jangka_waktu_fasilitas_kredit,
            'jangka_waktu_penarikan_fasilitas_kredit'=>$request->jangka_waktu_penarikan_fasilitas_kredit,
            'jangka_waktu_angsuran'=>$request->jangka_waktu_angsuran,
            'suku_bunga'=>$request->suku_bunga,
            'provisi'=>preg_replace('/[^0-9]/', '', $request->provisi),
            'biaya_administrasi'=>preg_replace( '/[^0-9]/', '', $request->biaya_administrasi),
            'grace_period'=>$request->grace_period,
            'lain_lain'=>$request->lain_lain,
            'total_fasilitas_kredit'=>preg_replace( '/[^0-9]/', '', $request->total_fasilitas_kredit),
        ]);

        return back()->with('success', 'Berhasil simpan');
    }

    public function print ($id)
    {
        $data = LoanApplicant::with(['master_bpr'])->where('uuid', $id)->first();
        $tanggal = date('d', strtotime($data->tanggal_nak));
        $bulan = bulan((int)date('m', strtotime($data->tanggal_nak)));
        $tahun = date('Y', strtotime($data->tanggal_nak));
        $tanggal = (int)$tanggal. ' ' .$bulan. ' '. $tahun;

        $keyRiskIssue = DB::table('key_risk_issue')
        ->selectRaw('key_risk_issue.id as id, jawaban, risk_mitigation, pertanyaan, sub_jenis_pertanyaan')
        ->where('loan_applicant_id', $id)
        ->where('jenis_pertanyaan', 'Credit Risk Reviewer')
        ->leftJoin('master_pertanyaan', 'master_pertanyaan.id', 'key_risk_issue.risk_issue')
        ->get();

        $covenent = DB::table('covenant_check_list')
        ->where('loan_applicant_id', $id)
        ->selectRaw('covenant_check_list.id, covenant_check_list.keterangan, catatan, sub_jenis_pertanyaan, pertanyaan')
        ->where('jenis_pertanyaan', 'Credit Risk Reviewer')
        ->leftJoin('master_pertanyaan', 'master_pertanyaan.id', 'covenant_check_list.pertanyaan_id')
        ->get();

        $informasi_grup_usaha = $data->master_bpr[0]->informasi_grup_usaha;

        $bwmk = LoanApplicant::with(['master_bpr'=> function($query) use ($informasi_grup_usaha){
            $query->where('informasi_grup_usaha', $informasi_grup_usaha);
        }])->sum('plafond');

        $jenis_pengajuan = $data->jenis_pengajuan;

        $parsing = [
            'data'=>$data,
            'tanggal'=>(int)$tanggal. ' ' .$bulan. ' '. $tahun,
            'informasiPokokBprPelapor'=>InformasiPokokBprPelapor::where('uuid', $data->sandi_bpr)->first(),
            'financialHighlight'=> ArrFinancialHighlight::where('loan_applicant_id', $id)->first(),
            'keyRiskIssue'=>$keyRiskIssue,
            'covenent'=>$covenent,
            'catatanPentingLainnya'=>CatatanPentingLainnya::where('loan_applicant_id', $id)->toBase()->first(),
            'rekomendasi'=>RekomendasiArr::where('loan_applicant_id', $data->uuid)->value('keterangan'),
            'bwmk'=>$bwmk,
            'jenis_pengajuan'=>$jenis_pengajuan
        ];

        $pdf = PDF::loadview('analisis-risiko-rekomendasi/print', $parsing)->set_option('isRemoteEnabled', true);

        return $pdf->stream();
    }
}
