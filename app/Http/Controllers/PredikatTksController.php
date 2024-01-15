<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Models\PredikatTks;
use DataTables;
use App\Http\Requests\PredikatTksRequest;
use App\Models\Log;
use Illuminate\Http\Request;

class PredikatTksController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):
            $data = DB::table('predikat_tks')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('nilai_min', function($row){
                $nilai_min = $row->nilai_min;

                return $nilai_min;
            })
            ->addColumn('nilai_max', function($row){
                $nilai_max = $row->nilai_max;

                return $nilai_max;
            })
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('predikat-tks.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('predikat-tks.destroy', [$row->id]));

                return $actionBtn;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('config/predikat-tks/index');
    }

    public function create()
    {
        return view('config/predikat-tks/form');
    }

    public function store (PredikatTksRequest $request)
    {
        $req = $request->validated();
        $data = PredikatTks::create($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('/predikat-tks')->with('success', 'Data berhasil di simpan');
    }

    public function edit(PredikatTks $predikat_tk)
    {
        return view('config/predikat-tks/form', compact('predikat_tk'));
    }

    public function update (PredikatTksRequest $request, PredikatTks $predikat_tk)
    {
        $predikat_tk->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('/predikat-tks')->with('success', 'Data berhasil di update');
    }

    public function destroy (Request $request, PredikatTks $predikat_tk)
    {
        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $predikat_tk->id);

        $predikat_tk->delete();

        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
