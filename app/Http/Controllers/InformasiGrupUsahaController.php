<?php

namespace App\Http\Controllers;
use App\Models\InformasiGrupUsaha;
use DB;
use Auth;
use DataTables;
use App\Http\Requests\InformasiGrupUsahaRequest;
use App\Models\Log;
use Illuminate\Http\Request;

class InformasiGrupUsahaController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):
            $data = DB::table('informasi_grup_usaha')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('informasi-grup-usaha.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('informasi-grup-usaha.destroy', [$row->id]));

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        return view('config/informasi-grup-usaha/index');
    }

    public function create()
    {
        return view('config/informasi-grup-usaha/form');
    }

    public function store (InformasiGrupUsahaRequest $request)
    {
        $data = InformasiGrupUsaha::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('informasi-grup-usaha')->with('success', 'Berhasil tambah Informasi Grup Usaha');
    }

    public function edit (InformasiGrupUsaha $informasiGrupUsaha)
    {
        return view('config/informasi-grup-usaha/form', compact('informasiGrupUsaha'));
    }

    public function update(InformasiGrupUsahaRequest $request, InformasiGrupUsaha $informasiGrupUsaha)
    {
        $informasiGrupUsaha->update($request->except('_token', 'aksi', '_method', 'tabel', 'aksi'));

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('informasi-grup-usaha')->with('success', 'Berhasil update Informasi Grup Usaha');
    }

    public function destroy(Request $request, InformasiGrupUsaha $informasiGrupUsaha)
    {
        $informasiGrupUsaha->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $informasiGrupUsaha->id);

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
