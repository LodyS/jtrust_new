<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Models\User;
use App\Models\LoanApplicant;
use App\Models\Bwmk;
use App\Models\HeaderImport;
use App\Models\DataKepemilikanBpr;
use App\Models\InformasiPokokBprPelapor;
use App\Models\IkhtisarLaporanKeuangan;
use App\Models\KondisiKeuanganDebitur;
use App\Models\ProspekDanKinerjaUsaha;
use Illuminate\Http\Request;
use App\Models\Pemasaran;
use App\Models\KegiatanUsaha;
use App\Models\PerhitunganKebutuhanKredit;
use App\Models\Legalitas;
use App\Models\ResumeHasilObservasi;
use App\Models\Agunan;
use App\Models\Kepatuhan;
use App\Models\UsulanKredit;
use App\Models\Disclaimer;
use App\Models\StatusAplicant;
use App\Models\LampiranNak;
use App\Models\Bmpk;
use App\Models\Deviasi;
use App\Models\StatusNak;
use App\Models\InputFinancialHighlight;
use App\Http\Requests\KeteranganRequest;
use App\Http\Requests\DeviasiRequest;
use App\Models\Log;

class NakController extends Controller
{
    public function index ($id)
    {
        $data = LoanApplicant::with('master_bpr')->where('uuid',$id)->first();
        $departemenHead = User::select('atasan_id')->toBase()->where('id', $data->user_id)->first();
        // BWMK
        $informasi_grup_usaha = $data->master_bpr[0]->informasi_grup_usaha;

        $bwmk = LoanApplicant::with(['master_bpr'=> function($query) use ($informasi_grup_usaha){
            $query->where('informasi_grup_usaha', $informasi_grup_usaha);
        }])->sum('plafond');

        $grup_usaha = LoanApplicant::with(['master_bpr'=> function($query) use ($informasi_grup_usaha){
            $query->where('informasi_grup_usaha', $informasi_grup_usaha);
        }])->get();

        $parsing = [
            'data'=>$data,
            'departemenHead'=>User::select('id','name', 'atasan_id')->toBase()->where('id', $departemenHead->atasan_id)->first(),
            'divisionHead'=>User::select('id', 'name', 'atasan_id')->toBase()->where('id', $departemenHead->atasan_id)->first(),
            'relationshipManager'=>User::select('name')->toBase()->where('id', $data->user_id)->first(),
            'id'=>$id,
            'bwmk'=>$bwmk,
            'status_nak'=>StatusNak::where('loan_applicant_id', $id)->toBase()->first(),
            'jenis_fasilitas_kredit'=>LoanApplicant::jenisFasilitasKredit($data->jenis_fasilitas_kredit),
            'jenis_pengajuan'=>$data->jenis_pengajuan,
        ];

        return view('nak/index')->with($parsing);
    }

    public function updateMainPage(Request $request)
    {
        LoanApplicant::where('uuid', $request->uuid)->where('id', $request->id)->update($request->except('_token', 'header', 'tabel', 'aksi', 'bagian'));

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->uuid
        ],[
            'header'=>$request->header
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id.' '.'Header');

        //StatusNak::create($req);
        return back()->with('success', 'Berhasil update');
    }

    public function permohonanDebitur ($id)
    {
        $data = LoanApplicant::where('uuid', $id)->firstOrFail();
        $status_nak= StatusNak::where('loan_applicant_id', $id)->toBase()->first();

        return view ('nak/permohonan-debitur', compact('data', 'id', 'status_nak'));
    }

    public function updatePermohonanDebitur(Request $request)
    {
        $rekues= $request->plafond_fasilitas_debitur;
        $req = $request->all();
        $update = LoanApplicant::where('uuid', $request->id)->first();
        $update->update($req);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->id
        ],[
            'permohonan_debitur'=>'Yes'
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id.' '.'Permohonan Debitur');

        if (isset($request->modal_inti_bank) && isset($request->debitur_individu) && isset($request->debitur_group)):
            $req = $request->except('_token', 'fasilitas_debitur');

            Bmpk::create($req);

            $param['tabel'] = 'bmpk';
            $param['aksi'] = 'Create';

            $log = new Log;
            $log->storeLog($param, $request->sandi_bpr);

        endif;

        return back()->with('success', 'Berhasil Update');
    }

    public function informasiGroupUsaha ($id)
    {
        $app = LoanApplicant::where('uuid', $id)->firstOrFail();
        $data = DB::table('info_grup_usaha')->where('sandi_bpr', $app->sandi_bpr)->get();
        $status_nak=StatusNak::where('loan_applicant_id', $id)->toBase()->first();

        return view('nak/informasi-group', compact('data', 'id', 'app', 'status_nak'));
    }

    public function updateInformasiGroupUsaha (Request $request)
    {
        if(isset($request->nama_perusahaan)):
            $jumlah = count($request->nama_perusahaan);

            for($i=0; $i<$jumlah; $i++):

                DB::table('info_grup_usaha')->insert([
                    'sandi_bpr'=>$request->sandi_bpr,
                    'nama_perusahaan'=>$request->nama_perusahaan[$i],
                    'bidang_usaha'=>$request->bidang_usaha[$i],
                    'tahun_pendirian'=>$request->tahun_pendirian[$i],
                    'created_at'=>\Carbon\Carbon::now(),
                    'updated_at'=>\Carbon\Carbon::now(),
                ]);

            endfor;

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

            StatusNak::updateOrCreate([
                'loan_applicant_id'=>$request->loan_applicant_id
            ],[
                'informasi_grup_usaha'=>'Yes'
            ]);

            return back()->with('success', 'Berhasil update');
        else:
            return back()->withError('Belum isi Informasi Grup Usaha');
        endif;
    }

    public function kondisiKeuanganDebitur(Request $request)
    {
        $data = LoanApplicant::where('uuid', $request->id)->firstOrFail();
        
        $parsing = [
            'id'=>$request->id,
            'data'=>$data,
            'kondisiKeuanganDebitur'=>KondisiKeuanganDebitur::where('loan_applicant_id', $request->id)->first(),
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'daftarPinjamanYangDiterima'=>DB::table('form_007')->where('sandi_bpr', $data->sandi_bpr)->get(),
        ];

        return view('nak/kondisi-keuangan-debitur', $parsing);
    }

    public function saveKondisiKeuanganDebitur(KeteranganRequest $request)
    {
        KondisiKeuanganDebitur::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'keterangan'=>$request->keterangan,
            'sandi_bpr'=>$request->sandi_bpr
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'kondisi_keuangan_debitur'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function prospekDanKinerjaUsaha(Request $request)
    {
        $parsing = [
            'prospekDanKinerjaUsaha'=>ProspekDanKinerjaUsaha::where('loan_applicant_id', $request->id)->toBase()->first(),
            'data'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'id'=>$request->id
        ];

        return view('nak/prospek-dan-kinerja-usaha', $parsing);
    }

    public function saveProspekDanKinerjaUsaha(KeteranganRequest $request)
    {
        ProspekDanKinerjaUsaha::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'keterangan'=>$request->keterangan,
            'sandi_bpr'=>$request->sandi_bpr
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'prospek_dan_kinerja_usaha'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function kegiatanUsaha(Request $request)
    {
        $parsing = [
            'data'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'kegiatanUsaha'=>KegiatanUsaha::where('loan_applicant_id', $request->id)->first(),
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'id'=>$request->id,
        ];

        return view('nak/kegiatan-usaha', $parsing);
    }

    public function saveKegiatanUsaha(KeteranganRequest $request)
    {
        KegiatanUsaha::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'keterangan'=>$request->keterangan,
            'sandi_bpr'=>$request->sandi_bpr
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'kegiatan_usaha'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function pemasaran (Request $request)
    {
        $pemasaran = Pemasaran::where('loan_applicant_id', $request->id)->toBase()->first();

        $parsing = [
            'app'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'id'=>$request->id,
            'pemasaran'=>$pemasaran,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/pemasaran', $parsing);
    }

    public function savePemasaran(KeteranganRequest $request)
    {
        $save = Pemasaran::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id

        ],[
            'sandi_bpr'=>$request->sandi_bpr,
            'keterangan'=>$request->keterangan ?? ''
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'pemasaran'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function perhitunganKebutuhanKredit(Request $request)
    {
        $parsing = [
            'id'=>$request->id,
            'data'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'perhitunganKebutuhanKredit'=>PerhitunganKebutuhanKredit::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/perhitungan-kebutuhan-kredit', $parsing);
    }

    public function savePerhitunganKebutuhanKredit(KeteranganRequest $request)
    {
        PerhitunganKebutuhanKredit::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'sandi_bpr'=>$request->sandi_bpr,
            'keterangan'=>$request->keterangan
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'perhitungan_kebutuhan_kredit'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function legalitas (Request $request)
    {
        $legalitas = Legalitas::where('loan_applicant_id', $request->id)->toBase()->first();

        $parsing = [
            'data'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'legalitas'=>$legalitas,
            'id'=>$request->id,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/legalitas', $parsing);
    }

    public function saveLegalitas(KeteranganRequest $request)
    {
        Legalitas::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'sandi_bpr'=>$request->sandi_bpr,
            'keterangan'=>$request->keterangan,
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'legalitas'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function resumeHasilObservasi (Request $request)
    {
        $resume_hasil_observasi = ResumeHasilObservasi::where('loan_applicant_id', $request->id)->toBase()->first();

        $parsing = [
            'id'=>$request->id,
            'resumeHasilObservasi'=>$resume_hasil_observasi,
            'data'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/resume-hasil-observasi', $parsing);
    }

    public function saveResumeHasilObservasi(KeteranganRequest $request)
    {
        ResumeHasilObservasi::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'sandi_bpr'=>$request->sandi_bpr,
            'keterangan'=>$request->keterangan
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'resume_hasil_observasi'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function kepatuhan (Request $request)
    {
        $kepatuhan = Kepatuhan::where('loan_applicant_id', $request->id)->toBase()->first();

        $parsing = [
            'data'=>LoanApplicant::where('uuid', $request->id)->toBase()->first(),
            'kepatuhan'=>Kepatuhan::where('loan_applicant_id', $request->id)->toBase()->first(),
            'id'=>$request->id,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/kepatuhan', $parsing);
    }

    public function saveKepatuhan(KeteranganRequest $request)
    {
        Kepatuhan::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'sandi_bpr'=>$request->sandi_bpr,
            'keterangan'=>$request->keterangan
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'kepatuhan'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function usulanKredit (Request $request)
    {
        $usulanKredit = UsulanKredit::where('loan_applicant_id', $request->id)->toBase()->first();

        $parsing = [
            'data'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'usulanKredit'=>$usulanKredit,
            'id'=>$request->id,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/usulan-kredit', $parsing);
    }

    public function saveUsulanKredit(KeteranganRequest $request)
    {
        UsulanKredit::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'sandi_bpr'=>$request->sandi_bpr,
            'keterangan'=>$request->keterangan
        ]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'usulan_kredit'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function slik (Request $request)
    {
        $parsing = [
            'data'=>LoanApplicant::where('id', $request->id)->firstOrFail(),
            'id'=>$request->id,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/usulan-kredit', $parsing);
    }

    public function saveSlik(KeteranganRequest $request)
    {
        LoanApplicant::where('id', $request->id)->update(['slik'=>$request->nak_slik]);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'usulan_kredit'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function disclaimer (Request $request)
    {
        $data = LoanApplicant::where('uuid', $request->id)->firstOrFail();
        $parsing = [
            'data'=>$data,
            'id'=>$request->id,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/disclaimer', $parsing);
    }

    public function editBmpk(Request $request)
    {
        $bmpk = Bmpk::findOrFail($request->id);
        $loan_applicant = $request->loan_applicant;

        return view('nak/edit-bmpk', compact('bmpk', 'loan_applicant'));
    }

    public function updateBmpk(Request $request)
    {
        $update = Bmpk::where('id', $request->id)->first();
        $update->update($request->except('_token', 'nak_id'));

        return redirect('nak-fasilitas-debitur/'.$request->nak_id)->with('success', 'Berhasil update');
    }

    public function destroyBmpk(Request $request)
    {
        DB::table('bmpk')->where('id', $request->id)->delete();

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
