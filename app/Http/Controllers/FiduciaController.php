<?php

namespace App\Http\Controllers;
use App\Models\Fiducia;
use App\Imports\FiduciaImport;
use DB;
use DataTables;
use App\Models\LoanApplicant;
use App\Http\Requests\ExcelRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class FiduciaController extends Controller
{
    public function index (Request $request)
    {
        $id = $request->id;
        $app = DB::table('form_00')->where('uuid', $request->id)->value('uuid');
 
        if ($request->ajax()):

            $data = DB::table('fiducia')->where('loan_applicant_id', $id);

            return Datatables::of($data)
            ->addColumn('tanggal_menjadi_anggota', function($row){

                $tanggal_menjadi_anggota = ($row->tanggal_menjadi_anggota == '') ? '' : date('d-m-Y', strtotime($row->tanggal_menjadi_anggota));

                return $tanggal_menjadi_anggota;
            })
            ->addColumn('tanggal_pencairan', function($row){

                $tanggal_pencairan = ($row->tanggal_pencairan == '') ? '' : date('d-m-Y', strtotime($row->tanggal_pencairan));

                return $tanggal_pencairan;
            })
            ->addColumn('plafond', function($row){
                $plafond = 'Rp.'. number_format((float)$row->plafond);

                return $plafond;
            })
            ->addColumn('os', function($row){
                $os = 'Rp.'. number_format((float)$row->os);

                return $os;
            })
            ->addIndexColumn()
            ->make(true);

        endif;

        return view('fiducia/index', compact('id', 'app'));
    }

    public function store (ExcelRequest $request)
    {
        $id = $request->loan_applicant_id;
        Excel::import(new FiduciaImport($id), $request->file('file'));

        Fiducia::Where('tanggal_menjadi_anggota', 'Tgl Menjadi Anggota')->orWhere('no_akad', 'No. Akad')->delete();
        Fiducia::whereNull('no_akad')->whereNull('produk')->whereNull('nama_peminjam')->whereNull('plafond')->whereNull('jangka_waktu')->delete();

        return redirect('fiducia/'.$id)->with('success', 'Berhasil input Fiducia');

    }
}
