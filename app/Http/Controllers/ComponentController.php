<?php

namespace App\Http\Controllers;
use App\Models\Component;
use DB;
use DataTables;
use Auth;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index ()
    {
        $produk = DB::table('t_product_type')->get(['id', 'product_title']);
        return view('config/component/index', compact('produk'));
    }

    public function data ()
    {
        $data = DB::table('component')
        ->selectRaw('component.id, product_title, nama_komponen, bobot_persentase, max_score')
        ->leftJoin('t_product_type', 't_product_type.id', 'component.product_id');

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '
            <a href="component/'.$row->id.'" class="btn btn-secondary">Edit</a>
            <a href="javascript:void(0);" id="reject" onClick="hapus('.$row->id.')" class="hapus btn btn-danger">Hapus</a>';

            return $actionBtn;
        })
        ->escapeColumns([]) // untuk render tag HTML
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create (Request $request)
    {
        $request=$request->all();
        $request['modified_by'] =Auth::user()->id;
        Component::create($request);

        return redirect('/component')->with('success', 'Data berhasil di simpan');
    }

    public function edit($id)
    {
        $data = Component::findOrFail($id);
        $produk = DB::table('t_product_type')->get(['id', 'product_title']);

        return view('config/component/form', compact('data', 'produk'));
    }

    public function update (Request $request)
    {
        Component::find($request->id)->update($request->all());

        return redirect('/component')->with('success', 'Data berhasil di update');
    }

    public function delete (Request $request)
    {
        $data = Component::find($request->id)->delete();
        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
