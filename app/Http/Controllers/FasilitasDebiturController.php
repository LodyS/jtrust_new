<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Log;
use App\Models\LoanApplicant;
use App\Models\InformasiPokokBprPelapor;
use App\Models\Bmpk;
use App\Models\StatusNak;
use Illuminate\Http\Request;

class FasilitasDebiturController extends Controller
{
    public function index ($id)
    {
        $data = LoanApplicant::where('uuid', $id)->firstOrFail();
        $informasi_grup_usaha = InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->informasi_grup_usaha ?? '';

        $grup_usaha_dua = DB::table('riwayat_pinjaman_grup_usaha')
        ->selectRaw('riwayat_pinjaman_grup_usaha.id, plafond, product_title as fasilitas, nama_perusahaan as nama_bpr, kol as kol_di_bank_jtrust')
        ->leftJoin('product_type', 'product_type.id', 'riwayat_pinjaman_grup_usaha.fasilitas')
        ->where('informasi_grup_usaha', $informasi_grup_usaha);

        $grup_usaha = DB::table('loan_applicants')
        ->selectRaw('loan_applicants.id, plafond, product_title as fasilitas, nama_bpr, kol_di_bank_jtrust')
        ->leftJoin('form_00', 'form_00.sandi_bpr', 'loan_applicants.sandi_bpr')
        ->leftJoin('product_type', 'product_type.id', 'loan_applicants.produk_id')
        ->where('informasi_grup_usaha', $informasi_grup_usaha)
        ->where('loan_applicants.uuid', '<>', $id)
        ->unionAll($grup_usaha_dua)
        ->get();

        $data = [
            'id'=>$id,
            'data'=>$data,
            'informasi_grup_usaha'=>$informasi_grup_usaha,
            'grup_usaha'=>$grup_usaha,
            'total_grup_usaha'=>$grup_usaha->count('id'),
            'plafond_debitur_grup_usaha'=>$grup_usaha->sum('plafond'),
            'bmpk'=>Bmpk::where('sandi_bpr', $data->sandi_bpr)->get(),
            'produk'=>DB::table('product_type')->get(),
            'status_nak'=>StatusNak::where('loan_applicant_id', $id)->toBase()->first(),
            'fasilitas_debitur'=>DB::table('loan_applicants')->where('sandi_bpr', $data->sandi_bpr)->get()
        ];

        return view('nak/fasilitas-debitur')->with($data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $loan_applicant = $request->except(
                '_token',
                'informasi_grup_usaha',
                'nama_perusahaan',
                'plafond_satu',
                'modal_inti_bank',
                'inhouse_inti_bank',
                'inhouse_modal_inti_bank',
                'tanggal_posisi',
                'debitur_individu',
                'inhouse_debitur_individu',
                'debitur_group',
                'inhouse_debitur_group',
                'kol',
                'fasilitas'
            );

            $update = LoanApplicant::where('uuid', $request->id)->first();
            $loan_applicant['plafond_permohonan_permohonan_debitur_tambahan_kab'] = $request->plafond_permohonan_permohonan_debitur_tambahan_kab ?? $update->plafond_permohonan_permohonan_debitur_tambahan_kab;

            $update->update($loan_applicant);

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id.' '.'Fasilitas Debitur');

            StatusNak::updateOrCreate([
                'loan_applicant_id'=>$request->id
            ],[
                'fasilitas_debitur'=>'Yes'
            ]);

            if(isset($request->nama_perusahaan)):
                for($i=0; $i<count($request->nama_perusahaan); $i++):

                    DB::table('riwayat_pinjaman_grup_usaha')->insert([
                        'sandi_bpr'=>$request->sandi_bpr,
                        'nama_perusahaan'=>$request->nama_perusahaan[$i],
                        'plafond'=>preg_replace('/[^0-9]/', '', $request->plafond_satu[$i]),
                        'informasi_grup_usaha'=>$request->informasi_grup_usaha,
                        'kol'=>$request->kol[$i],
                        'fasilitas'=>$request->fasilitas[$i],
                        'created_at'=>\Carbon\Carbon::now(),
                        'updated_at'=>\Carbon\Carbon::now(),
                    ]);

                endfor;

                $param['tabel'] = 'riwayat_pinjaman_grup_usaha';
                $param['aksi'] = 'Create';

                $log = new Log;
                $log->storeLog($param, $request->sandi_bpr);

            endif;

            if (isset($request->modal_inti_bank) && isset($request->debitur_individu) && isset($request->debitur_group)):

                $req = $request->except('_token', 'fasilitas_debitur');

                Bmpk::create($req);

                $param['tabel'] = 'bmpk';
                $param['aksi'] = 'Create';

                $log = new Log;
                $log->storeLog($param, $request->sandi_bpr);

            endif;

            DB::commit();
            return back()->with('success', 'Berhasil simpan');
        } catch (Exception $e){
            DB::rollback();
            return back()->withError('Gagal simpan');
        }
    }
}
