<?php

namespace App\Http\Controllers;
use DB;
use App\Models\LoanApplicant;
use App\Models\StatusNak;
use App\Models\InputFinancialHighlight;
use App\Models\IkhtisarLaporanKeuangan;
use App\Models\Log;
use Illuminate\Http\Request;

class NakFinancialHiglightController extends Controller
{
    public function index (Request $request)
    {
        $data = LoanApplicant::where('uuid', $request->id)->firstOrFail();

        $fh_berjalan = InputFinancialHighlight::cari_max($data->sandi_bpr,'sub_jenis', 'OJK Publikasi');
        $bulan_berjalan = ($fh_berjalan == null) ? date('m') : $fh_berjalan->bulan;
        $tahun_berjalan = ($fh_berjalan == null) ? date('Y') : $fh_berjalan->tahun;

        //
        $desember_akhir = InputFinancialHighlight::cari_max($data->sandi_bpr, 'sub_jenis', 'Audit');
        $tahun_max_rkat = InputFinancialHighlight::cari_max($data->sandi_bpr, 'sub_jenis', 'Disampaikan ke OJK');

        $tahun_ini = $desember_akhir->tahun ?? date('Y')-1;
        $tahun_max_rkat = $tahun_max_rkat->tahun ?? '';
        $tahun_rkat_sebelumnya = ($tahun_max_rkat == null) ? '' : $tahun_max_rkat - 1;

        $keterangan = DB::table('input_financial_highlight')->selectRaw('distinct(keterangan) as keterangan')->where('sandi_bpr', $data->sandi_bpr)->orderBy('id', 'asc')->get();
   
        $nominal = [
            'ojk_publikasi'=>InputFinancialHighlight::laporan($bulan_berjalan, $tahun_berjalan, 'Realisasi', 'OJK Publikasi'),
            'audit_satu'=>InputFinancialHighlight::laporan(12, $tahun_ini, 'Realisasi', 'Audit'),
            'audit_dua'=>InputFinancialHighlight::laporan(12, $tahun_ini-1, 'Realisasi', 'Audit'),
            'audit_tiga'=>InputFinancialHighlight::laporan(12, $tahun_ini-2, 'Realisasi', 'Audit'),
            'rkat'=>InputFinancialHighlight::laporan(12, $tahun_berjalan, 'RKAT', 'Disampaikan ke OJK'),
            'rkat_tahun_depan'=>InputFinancialHighlight::laporan(12, $tahun_berjalan, 'RKAT', 'Disampaikan ke OJK')
        ];

        $parsing = [
            'id'=>$request->id,
            'data'=>$data,
          	'dataa'=>$keterangan,
            'tahun_ini'=>$tahun_ini,
          	'bulan_berjalan'=>$bulan_berjalan,
          	'tahun_max_rkat'=>$tahun_max_rkat,
            'tahun_rkat_sebelumnya'=>$tahun_rkat_sebelumnya,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'ikhtisarLaporanKeuangan'=>IkhtisarLaporanKeuangan::where('sandi_bpr', $data->sandi_bpr)->toBase()->get(),
            'fh_berjalan'=>$fh_berjalan,
            'nominal'=>$nominal,
        ];

        return view('nak/financial-highlight', $parsing);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $req = $request->all();
            if($request->periode != null):
                for ($i=0; $i<count($req['periode']); $i++):
                    $insert = array (
                        'periode'=>$req['periode'][$i],
                        'kap'=>$req['kap'][$i],
                        'registered'=>$req['registered'][$i],
                        'auditor'=>$req['auditor'][$i],
                        'opinion'=>$req['opinion'][$i],
                        'sandi_bpr'=>$request->sandi_bpr,
                    );

                    IkhtisarLaporanKeuangan::create($insert);
                endfor;

                $param['tabel'] = 'ikhtisar_laporan_keuangan';
                $param['aksi'] = 'Create';

                $log = new Log;
                $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

            endif;

            if($request->financial_highlight):
                LoanApplicant::where('uuid', $request->id)->update(['financial_highlight'=>$request->financial_highlight]);

                $log = new Log;
                $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id.' '.'Financial Highlight');
            endif;

            StatusNak::updateOrCreate([
                'loan_applicant_id'=>$request->id
            ],[
                'financial_highlight'=>'Yes'
            ]);

            DB::commit();
            return back()->with('success', 'Berhasil update');
        } catch (\Illuminate\Database\QueryException $e){
            DB::rollback();
            return back()->withError('Gagal update data');
        }
    }
}
