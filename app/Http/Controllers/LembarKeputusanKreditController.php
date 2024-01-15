<?php

namespace App\Http\Controllers;
use App\Models\LoanApplicant;
use App\Models\PelaksanaanRapat;
use App\Models\PesertaUndangan;
use App\Models\InformasiPokokBprPelapor;
use App\Models\PersetujuanKhususDeviasi;
use App\Models\RekomendasiArr;
use App\Models\UsulanPersetujuanKredit;
use DB;
use Illuminate\Http\Request;
use PDF;

class LembarKeputusanKreditController extends Controller
{
    public function index (Request $request)
    {
        $data = LoanApplicant::where('uuid', $request->id)->first();
        $sandi_bpr = LoanApplicant::where('uuid', $request->id)->value('sandi_bpr');
        $pelaksanaanRapat = PelaksanaanRapat::where('loan_applicant_id', $request->id)->first();
        $pelaksanaanRapatId = $pelaksanaanRapat->id ?? null;
        $parsing = [
            'url'=>'lembar-keputusan-kredit-header',
            'id'=>$request->id,
            'data'=>$data,
            'pelaksanaanRapat'=>$pelaksanaanRapat,
            'pesertaUndangan'=>PesertaUndangan::where('pelaksanaan_rapat_id', $pelaksanaanRapatId)->toBase()->get(),
            'informasiDebitur'=>InformasiPokokBprPelapor::where('sandi_bpr', $sandi_bpr)->toBase()->first(),
            'jenis_pengajuan'=>$data->jenis_pengajuan,
        ];

        return view('lembar-keputusan-kredit/index', $parsing);
    }

    public function storeHeader (Request $request)
    {
        DB::beginTransaction();

        try {

            LoanApplicant::where('uuid', $request->loan_applicant_id)->update($request->only(
                'no_lembar_keputusan_kredit',
                'tanggal_lkk',
                'catatan_lkk'
            ));

            $id = PelaksanaanRapat::updateOrCreate([
                'loan_applicant_id'=>$request->loan_applicant_id
            ],[
                'tanggal'=>$request->tanggal,
                'ruang_alamat'=>$request->ruang_alamat,
                'waktu_rapat'=>$request->waktu_rapat,
            ]);

            if($request->nama):
                for ($i=0; $i<count($request->nama); $i++):
                    DB::table('peserta_undangan')
                    ->insert([
                        'nama'=>$request->nama[$i],
                        'jabatan'=>$request->jabatan[$i],
                        'pelaksanaan_rapat_id'=>$id->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                endfor;
            endif;

            DB::commit();
            return back()->with('success', 'Berhasil simpan data');
        } catch (Exception $e){
            DB::rollbak();
            return back()->withError('Gagal Simpan');
        }
    }

    public function fasilitasKredit (Request $request)
    {
        $parsing = [
            'id'=>$request->id,
            'data'=>LoanApplicant::where('uuid', $request->id)->toBase()->first(),
        ];

        return view('lembar-keputusan-kredit/fasilitas-kredit', $parsing);
    }

    public function agunanFasilitasKredit (Request $request)
    {
        $id = $request->id;
        $dataa = LoanApplicant::where('uuid', $request->id)->toBase()->first();
        $data = DB::table('agunan')->where('sandi_bpr', $dataa->sandi_bpr)->get();
        $jenis_pengajuan=$dataa->jenis_pengajuan;
        $jenis_fasilitas_kredit = $dataa->jenis_fasilitas_kredit;

        return view('lembar-keputusan-kredit/agunan-fasilitas-kredit', compact('data', 'id', 'dataa', 'jenis_pengajuan', 'jenis_fasilitas_kredit'));
    }

    public function syaratKondisiFasilitasKredit(Request $request)
    {
        $id = $request->id;
        $sandi_bpr = LoanApplicant::where('uuid', $id)->value('sandi_bpr');
       
        $pertanyaan = DB::table('master_pertanyaan')->where('jenis_pertanyaan', 'Credit Risk Reviewer')->where('bagian', 'Lembar Keputusan Kredit')->get();

        $data = DB::table('syarat_dan_kondisi_penyediaan_fasilitas_kredit')
        ->selectRaw('syarat_dan_kondisi_penyediaan_fasilitas_kredit.id, pelaksana, sifat_frekuensi_target_waktu')
        ->selectRaw('syarat_dan_kondisi_penyediaan_fasilitas_kredit.keterangan, pertanyaan')
        ->selectRaw('sub_bagian, no_urut, sub_jenis_pertanyaan')
        ->leftJoin('master_pertanyaan', 'master_pertanyaan.id', 'syarat_dan_kondisi_penyediaan_fasilitas_kredit.pertanyaan_id')
        ->where('loan_applicant_id', $id)
        ->get();

        if (count($data) == null):
            return view('lembar-keputusan-kredit/syarat-dan-kondisi-penyediaan-fasilitas', compact('id', 'pertanyaan',  'sandi_bpr'));
        else:
            return view('lembar-keputusan-kredit/edit-syarat-dan-kondisi-penyediaan-fasilitas', compact('id', 'data', 'sandi_bpr'));
        endif;
    }

    public function storeSyaratKondisiFasilitasKredit(Request $request)
    {
        if($request->aksi == 'create'):
            for ($i=0; $i<count($request->pertanyaan_id); $i++):
                DB::table('syarat_dan_kondisi_penyediaan_fasilitas_kredit')
                ->insert([
                    'loan_applicant_id'=>$request->loan_applicant_id,
                    'pertanyaan_id'=>$request->pertanyaan_id[$i],
                    'pelaksana'=>$request->pelaksana[$i],
                    'sifat_frekuensi_target_waktu'=>$request->sifat_frekuensi_target_waktu[$i],
                    'keterangan'=>$request->keterangan[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            endfor;
        endif;

        if ($request->aksi == 'edit'):
            for ($i=0; $i<count($request->id); $i++):
                DB::table('syarat_dan_kondisi_penyediaan_fasilitas_kredit')
                ->where('id', $request->id[$i])
                ->update([
                    'pelaksana'=>$request->pelaksana[$i],
                    'sifat_frekuensi_target_waktu'=>$request->sifat_frekuensi_target_waktu[$i],
                    'keterangan'=>$request->keterangan[$i],
                    'updated_at' => now()
                ]);
            endfor;
        endif;

        return back()->with('success', 'Berhasil simpan');
    }

    public function persetujuanKhususDeviasi(Request $request)
    {
        $id = $request->id;
        $data=  PersetujuanKhususDeviasi::where('loan_applicant_id', $id)->toBase()->first();
        $sandi_bpr = LoanApplicant::where('uuid', $id)->value('sandi_bpr');
        return view('lembar-keputusan-kredit/persetujuan-khusus-deviasi', compact('id', 'data', 'sandi_bpr'));
    }

    public function storePersetujuanKhususDeviasi(Request $request)
    {
        PersetujuanKhususDeviasi::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id,
        ],[
            'keterangan'=>$request->keterangan
        ]);

        return back()->with('success', 'Berhasil simpan');
    }

    public function usulanPersetujuanKredit (Request $request)
    {
        $id = $request->id;
        $data = LoanApplicant::where('uuid', $id)->firstOrFail();
        $crrd = RekomendasiArr::where('loan_applicant_id', $id)->first();
        $komite = UsulanPersetujuanKredit::where('loan_applicant_id', $id)->first();
        $jenis_fasilitas_kredit = DB::table('fasilitas_kredits')->get();

        return view('lembar-keputusan-kredit/usulan-persetujuan-kredit', compact('id', 'data', 'crrd', 'komite', 'jenis_fasilitas_kredit'));
    }

    public function storeUsulanPersetujuanKredit (Request $request)
    {
        UsulanPersetujuanKredit::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id,
        ],[
            'jenis_fasilitas_kredit'=>$request->jenis_fasilitas_kredit,
            'limit_fasilitas_kredit'=>$request->limit_fasilitas_kredit,
            'sifat_fasilitas_kredit'=>$request->sifat_fasilitas_kredit,
            'tujuan_penggunaan'=>$request->tujuan_penggunaan,
            'jangka_waktu_fasilitas_kredit'=>$request->jangka_waktu_fasilitas_kredit,
            'jangka_waktu_penarikan_fasilitas_kredit'=>$request->jangka_waktu_penarikan_fasilitas_kredit,
            'jangka_waktu_angsuran'=>$request->jangka_waktu_angsuran,
            'suku_bunga'=>$request->suku_bunga,
            'provisi'=>$request->provisi,
            'biaya_administrasi'=>$request->biaya_administrasi,
            'grace_period'=>$request->grace_period,
            'lain_lain'=>$request->lain_lain,
            'total_fasilitas_kredit'=>$request->total_fasilitas_kredit,
        ]);

        return back()->with('success', 'Berhasil simpan data');
    }

    public function print ($id)
    {
        $data = LoanApplicant::where('uuid', $id)->first();
        $sandi_bpr = $data->sandi_bpr;
        $pelaksanaanRapat = PelaksanaanRapat::where('loan_applicant_id', $id)->first();
        $pelaksanaanRapatId = $pelaksanaanRapat->id ?? null;
        $pesertaUndangan = PesertaUndangan::where('pelaksanaan_rapat_id', $pelaksanaanRapatId)->toBase()->get();
        $informasiDebitur = InformasiPokokBprPelapor::where('uuid', $sandi_bpr)->toBase()->first();
        $agunan = DB::table('agunan')->where('sandi_bpr', $data->sandi_bpr)->get();
        $nama_bpr = DB::table('form_00')->where('sandi_bpr', $data->sandi_bpr)->value('nama_bpr');
        $persetujuan = PersetujuanKhususDeviasi::where('loan_applicant_id', $id)->toBase()->first();

        $crrd = RekomendasiArr::where('loan_applicant_id', $id)->toBase()->first();
        $komite = UsulanPersetujuanKredit::where('loan_applicant_id', $id)->toBase()->first();
        $syarat = DB::table('syarat_dan_kondisi_penyediaan_fasilitas_kredit')
        ->selectRaw('syarat_dan_kondisi_penyediaan_fasilitas_kredit.id, pelaksana, sifat_frekuensi_target_waktu')
        ->selectRaw('syarat_dan_kondisi_penyediaan_fasilitas_kredit.keterangan, pertanyaan')
        ->selectRaw('sub_bagian, no_urut, sub_jenis_pertanyaan')
        ->leftJoin('master_pertanyaan', 'master_pertanyaan.id', 'syarat_dan_kondisi_penyediaan_fasilitas_kredit.pertanyaan_id')
        ->where('loan_applicant_id', $id)
        ->get();

       $pdf = PDF::loadview('lembar-keputusan-kredit/print', [
            'data'=>$data,
            'sandi_bpr'=>$sandi_bpr,
            'pelaksanaanRapat'=>$pelaksanaanRapat,
            'pelaksanaanRapatId'=>$pelaksanaanRapatId,
            'pesertaUndangan'=>PesertaUndangan::where('pelaksanaan_rapat_id', $pelaksanaanRapatId)->toBase()->get(),
            'informasiDebitur'=> InformasiPokokBprPelapor::where('uuid', $sandi_bpr)->toBase()->first(),
            'agunan'=>DB::table('agunan')->where('sandi_bpr', $data->sandi_bpr)->get(),
            'nama_bpr'=>DB::table('form_00')->where('sandi_bpr', $data->sandi_bpr)->value('nama_bpr'),
            'persetujuan'=>PersetujuanKhususDeviasi::where('loan_applicant_id', $id)->toBase()->first(),
            'crrd'=>RekomendasiArr::where('loan_applicant_id', $id)->toBase()->first(),
            'komite'=>UsulanPersetujuanKredit::where('loan_applicant_id', $id)->toBase()->first(),
            'syarat'=>$syarat
       ])
       ->set_option('isRemoteEnabled', true);
      
       return $pdf->stream();
    }
}
