<?php

namespace App\Http\Controllers;
use DB;
use App\Models\CreditType;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class ProductCategoryController extends Controller
{
    public function index ()
    {
        return view('setup-product/product-category/index');
    }

    public function data ()
    {
        $data = DB::table('t_credit_type as credit')
        ->selectRaw('credit.id, credit.code, product_title, title, maksimal_rpc_persentase')
        ->leftJoin('t_product_type as product', 'product.id', 'credit.t_product_id');

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '
            <a href="product-category/'.$row->id.'" class="btn btn-secondary">Edit</a>
            <a href="javascript:void(0);" id="reject" onClick="hapus('.$row->id.')" class="hapus btn btn-danger">Hapus</a>';

            return $actionBtn;
        })
        ->addColumn('maksimal_rpc_persentase', function($row){
            return $row->maksimal_rpc_persentase .'%';
        })
        ->escapeColumns([]) // untuk render tag HTML
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create()
    {
        $aksi = 'create';
        $produkTipe = DB::table('t_product_type')->get(['id', 'product_title']);
        return view('setup-product/product-category/form', compact('aksi', 'produkTipe'));
    }

    public function store (Request $request)
    {
        $request=$request->all();
        $request['modified_by'] =Auth::user()->id;
        CreditType::create($request);

        return redirect('/product-category')->with('success', 'Data berhasil di simpan');
    }

    public function edit($id)
    {
        $data = CreditType::findOrFail($id);
        $produkTipe = DB::table('t_product_type')->get(['id', 'product_title']);
        $aksi = 'edit';

        return view('setup-product/product-category/form', compact('data', 'produkTipe', 'aksi'));
    }

    public function update (Request $request)
    {
        CreditType::find($request->id)->update($request->all());
        return redirect('/product-category')->with('success', 'Data berhasil di update');
    }

    public function delete (Request $request)
    {
        $data = CreditType::find($request->id)->delete();
        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
