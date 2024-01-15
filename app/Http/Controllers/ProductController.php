<?php

namespace App\Http\Controllers;
use App\Models\ProductType;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Http\Requests\ProductRequest;
use DataTables;

class ProductController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):
            $data = DB::table('product_type')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('bunga', function($row){
                $bunga = $row->bunga.'%';

                return $bunga;
            })
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('product.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('product.destroy', [$row->id]));

                return $actionBtn;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('setup-product/product/index');
    }

    public function create()
    {
        return view('setup-product/product/form');
    }

    public function store (ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $req['modified_by'] = Auth::user()->id;
            $produk = ProductType::create($req);

            $log = new Log;
            $log->storeLog($req, $produk->id);

            DB::commit();
            return redirect('/product')->with('success', 'Product berhasil di simpan');
        } catch (Exception $e){
            DB::rollback();
            return back()->withError('Gagal simpan');
        }
    }

    public function edit(ProductType $product)
    {
        return view('setup-product/product/form', compact('product'));
    }

    public function update (ProductRequest $request, ProductType $product)
    {
        $product->update($request->except('tabel', 'aksi', '_token', '_method'));

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $product->id);

        return redirect('/product')->with('success', 'Product berhasil di update');
    }

    public function destroy (ProductType $product)
    {
        $product->delete();

        $log = new Log;
        $log->storeLog($product->id, 'product');

        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
