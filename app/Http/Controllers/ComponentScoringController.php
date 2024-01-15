<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use DataTables;
use App\Models\ComponentDetail;
use Illuminate\Http\Request;

class ComponentScoringController extends Controller
{
    public function index ()
    {
        $component = DB::table('component')->get(['id', 'nama_komponen']);
        return view('config/component-scoring/index', compact('component'));
    }

    public function data ()
    {
        $data = DB::table('component_detail')
        ->selectRaw('component_detail.id, nama_komponen, uniq_code, pertanyaan, tipe_pertanyaan, tipe_inputan')
        ->leftJoin('component', 'component.id', 'component_detail.id_komponen');

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '
            <a href="component-scoring/'.$row->id.'" class="btn btn-secondary">Edit</a>
            <a href="javascript:void(0);" id="reject" onClick="hapus('.$row->id.')" class="hapus btn btn-danger">Hapus</a>';

            return $actionBtn;
        })
        ->escapeColumns([]) // untuk render tag HTML
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store (Request $request)
    {
        $request=$request->all();
        $request['modified_by'] =Auth::user()->id;
        ComponentDetail::create($request);

        return redirect('/component-scoring')->with('success', 'Data berhasil di simpan');
    }

    public function edit($id)
    {
        $data = ComponentDetail::findOrFail($id);
        $component = DB::table('component')->get(['id', 'nama_komponen']);

        return view('config/component-scoring/form', compact('data', 'component'));
    }

    public function update (Request $request)
    {
        ComponentDetail::find($request->id)->update($request->all());
        return redirect('/component-scoring')->with('success', 'Data berhasil di update');
    }

    public function delete (Request $request)
    {
        $data = ComponentDetail::find($request->id)->delete();
        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
