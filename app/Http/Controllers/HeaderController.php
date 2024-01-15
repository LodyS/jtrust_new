<?php

namespace App\Http\Controllers;
use App\Models\Log;
use DataTables;
use App\Models\HeaderImport;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    public function index(Request $request)
    {
       $sandi_bpr = $request->sandi_bpr;

        if ($request->ajax()):

            $data = HeaderImport::where('sandi_bpr', $request->sandi_bpr);

            return Datatables::of($data)
            ->addColumn('bulan', function($row){
                return bulan($row->periode_waktu);
            }) ->addColumn('action', function($row){
                return tombol_general('edit-header', $row->id, 'Edit');
            })
            ->filterColumn('bulan', function($query, $keyword) {
                $keyword = bulan_angka($keyword);
                $query->where('tahun', $keyword);
            })
            ->addIndexColumn()
            ->make(true);

        endif;

        return view('master-data-bpr/header', compact('sandi_bpr'));
    }

    public function edit($id)
    {
        $data = HeaderImport::findOrFail($id);

        return view('master-data-bpr/edit-header', compact('data'));
    }

    public function update(Request $request)
    {
        $data = HeaderImport::find($request->id)->update($request->all());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('header/'.$request->sandi_bpr);
    }
}
