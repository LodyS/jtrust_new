<?php

namespace App\Http\Controllers;
use App\Models\BungaProduk;
use App\Models\CreditType;
use Illuminate\Http\Request;
use App\Http\Requests\InterestRateProductRequest;
use DB;
use DataTables;

class InterestRateProductController extends Controller
{
    public function index ()
    {
        return view('setup-user/interest-rate-product/index');
    }

    public function data ()
    {
        $data = DB::table('t_bunga_product')
        ->selectRaw('t_bunga_product.id, t_credit_type.title, bulan, flat_rates, admin_fee, asuransi_fee')
        ->leftJoin('t_credit_type', 't_credit_type.id', 't_bunga_product.t_credit_type_id');

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '

            <a href="interest-rate-product-form/'.$row->id.'" class="btn btn-secondary icon-pencil"></a>
            <a href="javascript:void(0);" id="reject" onClick="hapus('.$row->id.')"
            data-original-title="Delete"
            class="hapus btn btn-danger icon-trash"></a>';

            return $actionBtn;
        })
        ->addColumn('flat_rates', function($row){
            return $row->flat_rates . '%';
        })
        ->addColumn('asuransi_fee', function($row){
            return $row->asuransi_fee . '%';
        })
        ->addColumn('admin_fee', function($row){
            return $row->admin_fee . '%';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create ()
    {
        $produk = CreditType::pluck('title', 'id');
        $aksi = "create";
        $data = null;

        return view('setup-user/interest-rate-product/form', compact('produk', 'aksi', 'data'));
    }

    public function store (InterestRateProductRequest $request)
    {
        BungaProduk::create($request->all());

        return redirect('/interest-rate-product')->with('success', 'Interest Rate Product berhasil di simpan');;
    }

    public function edit ($id)
    {
        $produk = CreditType::pluck('title', 'id');
        $aksi = "update";
        $data = BungaProduk::findOrFail($id);

        return view('setup-user/interest-rate-product/form', compact('aksi', 'produk', 'data'));
    }

    public function update (Request $request)
    {
        BungaProduk::find($request->id)->update($request->all());
        return redirect('/interest-rate-product')->with('success', 'Interest Rate Product berhasil di update');
    }

    public function delete (Request $request)
    {
        $data = BungaProduk::find($request->id)->delete();
        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
