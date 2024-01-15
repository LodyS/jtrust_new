<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use DataTables;
use App\Models\CreditType;
use App\Http\Requests\InterestRateRequest;
use Illuminate\Http\Request;

class InterestRateSettingController extends Controller
{
    public function index()
    {
        return view('setup-product/interest-rate-setting/index');
    }

    public function data ()
    {
        $data = DB::table('t_credit_type')
        ->selectRaw('t_credit_type.id, t_product_type.product_title, t_credit_type.code, title, maksimal_rpc_persentase')
        ->leftJoin('t_product_type', 't_product_type.id', 't_credit_type.t_product_id');

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '

            <a href="interest-rate-setting/'.$row->id.'" class="btn btn-secondary">Edit</a>
            <a href="javascript:void(0);" onClick="hapus('.$row->id.')" class="hapus btn btn-danger">Hapus</a>';

            return $actionBtn;
        })
        ->addColumn('maksimal_rpc_persentase', function($row){
            return $row->maksimal_rpc_persentase .'%';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create()
    {
        $aksi = 'create';
        return view('setup-product/interest-rate-setting/form', compact('aksi'));
    }

    public function store (InterestRateRequest $request)
    {
        $rekues = $request->all();
        $rekues['modified_by'] = Auth::user()->id;
        CreditType::create($rekues);

        return back()->with('success', 'Interest Rate Setting berhasil di simpan');;
    }

    public function edit ($id)
    {
        $data = CreditType::findOrFail($id);
        $aksi='edit';

        return view('setup-product/interest-rate-setting/form', compact('data', 'aksi'));
    }

    public function update(Request $request)
    {
        CreditType::find($request->id)->update($request->except('_token'));
        DB::commit();
        return redirect('/interest-rate-setting')->with('success', 'Sukses update data');
    }
}
