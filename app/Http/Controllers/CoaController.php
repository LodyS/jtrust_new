<?php

namespace App\Http\Controllers;
use App\Models\Coa;
use DataTables;
use DB;
use Auth;
use App\Models\Log;
use App\Http\Requests\CoaRequest;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):

            $data = DB::table('coa')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                return route_general(route('coa.edit', [$row->id]), 'Edit', 'secondary');
            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        return view ('setup-user/coa/index');
    }

    public function create(Request $request)
    {
        $aksi = 'Create';
        $data = null;

        return view('setup-user/coa/form', compact('aksi', 'data'));
    }

    public function edit($id)
    {
        $data = Coa::findOrFail($id);
        $aksi = 'Update';

        return view('setup-user/coa/form', compact('data', 'aksi'));
    }

    public function store(CoaRequest $request)
    {
        try {
            $coa = Coa::create($request->validated());

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $coa->id);

            DB::commit();
            return redirect('coa')->with('success', 'Coa berhasil di simpan');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withError('Coa gagal disimpan');
        }
    }

    public function update (CoaRequest $request)
    {
        Coa::find($request->id)->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('/coa')->with('success', 'Coa berhasil di update');
    }
}
