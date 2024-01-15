<?php

namespace App\Http\Controllers;
use App\Models\NilaiKomponenTks;
use DB;
use Auth;
use DataTables;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Requests\NilaiKomponenTksRequest;

class NilaiKomponenTksController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):

            $data = DB::table('nilai_komponen_tks')
            ->selectRaw('nilai_komponen_tks.id, komponen_tks.sub_komponen, nilai_min, nilai_max, kategori')
            ->leftJoin('komponen_tks', 'komponen_tks.id', 'nilai_komponen_tks.sub_komponen');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('nilai_min', function($row){
                $nilai_min = $row->nilai_min. '%';

                return $nilai_min;
            })
            ->addColumn('nilai_max', function($row){
                $nilai_max = $row->nilai_max. '%';

                return $nilai_max;
            })
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('nilai-komponen-tks.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('nilai-komponen-tks.destroy', [$row->id]));

                return $actionBtn;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('config/nilai-komponen-tks/index');
    }

    public function create()
    {
        $aksi = 'Create';
        $data = null;
        $komponen = DB::table('komponen_tks')->get(['id', 'sub_komponen']);

        return view('config/nilai-komponen-tks/form', compact('aksi', 'data', 'komponen'));
    }

    public function store (NilaiKomponenTksRequest $request)
    {
        $req = $request->validated();
        $data = NilaiKomponenTks::create($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('/nilai-komponen-tks')->with('success', 'Data berhasil di simpan');
    }

    public function edit($id)
    {
        $data = NilaiKomponenTks::with('komponen')->where('id', $id)->firstOrFail();
  
        return view('config/nilai-komponen-tks/form', compact('data'));
    }

    public function update (Request $request, NilaiKomponenTks $nilai_komponen_tk)
    {
        $request->validate([
            'nilai_min'=>'required',
            'nilai_max'=>'required|gt:nilai_min',
            'kategori'=>'required'
        ]);

        $nilai_komponen_tk->update($request->except('_token', '_method', 'aksi', 'tabel'));

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);
        return redirect('/nilai-komponen-tks')->with('success', 'Data berhasil di update');
    }

    public function destroy (Request $request, NilaiKomponenTks $nilai_komponen_tk)
    {
        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $nilai_komponen_tk->id);
        
        $nilai_komponen_tk->delete();

        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
