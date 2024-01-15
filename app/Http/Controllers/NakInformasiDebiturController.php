<?php

namespace App\Http\Controllers;
use App\Models\LoanApplicant;
use App\Models\StatusNak;
use App\Models\InformasiPokokBprPelapor;
use App\Models\DataKepemilikanBpr;
use DB;
use App\Models\Log;
use Illuminate\Http\Request;

class NakInformasiDebiturController extends Controller
{
    public function index($id)
    {
        $loan = LoanApplicant::where('uuid', $id)->select('user_id', 'sandi_bpr', 'status_level_proses')->firstOrFail();
        $data = InformasiPokokBprPelapor::where('uuid', $loan->sandi_bpr)->first();
        $keteranganBpr = DataKepemilikanBpr::where('sandi_bpr', $loan->sandi_bpr)->value('keterangan');
        $pemegangSaham = DataKepemilikanBpr::where('sandi_bpr', $loan->sandi_bpr)->toBase()->get();
        $status_nak=StatusNak::where('loan_applicant_id', $id)->toBase()->first();

        return view('nak/informasi-debitur', compact('data', 'keteranganBpr', 'pemegangSaham', 'id', 'loan', 'status_nak'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $req = $request->all();
            InformasiPokokBprPelapor::find($request->id)->update($req);

            StatusNak::updateOrCreate([
                'loan_applicant_id'=>$request->loan_applicant_id
            ],[
                'informasi_debitur'=>'Yes'
            ]);

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->loan_applicant_id.' '.'Informasi Debitur');

            if (isset($request->aksi_satu)):
                for ($i=0; $i<count($req['nama']); $i++):

                    $insert = array (
                        'nama'=>$req['nama'][$i],
                        'jabatan'=>$req['jabatan'][$i],
                        'jumlah_nominal'=>$req['jumlah_nominal'][$i],
                        'persentase_kepemilikan'=>$req['persentase_kepemilikan'][$i],
                        'sandi_bpr'=>$req['sandi_bpr'],
                        'keterangan'=>$req['keterangan']
                    );

                    DataKepemilikanBpr::create($insert);
                endfor;

                $param['tabel'] = 'form_001';
                $param['aksi'] = 'Create';

                $log = new Log;
                $log->storeLog($param, $request->sandi_bpr);

            endif;

            DB::commit();
            return back()->with('success', 'Berhasil update');

        } catch (Exception $e){
            DB::rollback();
            return back()->withError('Gagal update');
        }
    }
}
