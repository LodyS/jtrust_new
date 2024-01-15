<?php

namespace App\Http\Controllers;
use App\Models\SettingFlow;
use DB;
use DataTables;
use Illuminate\Support\Str;
use App\Http\Requests\SettingFlowRequest;
use Illuminate\Http\Request;
use App\Models\Log;

class SettingFlowController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):
            $data = DB::table('setting_flows')
            ->select(
                'setting_flows.id', 
                'nama_jabatan as jabatan', 
                'divisi',
                'level'
            )
            ->leftJoin('jabatan', 'jabatan.id', 'setting_flows.jabatan_id');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $id = $row->id;

                $action = route_general('setting-flow.edit', $id, 'Edit');

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('setting-flow/index');
    }

    public function create ()
    {
        $aksi = 'Create';
        $jabatan = DB::table('jabatan')->get();
        $data = null;
    
        return view('setting-flow/form', compact('aksi', 'jabatan', 'data'));
    }

    public function store (SettingFlowRequest $request)
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $settingFlow = SettingFlow::create($req);

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $settingFlow->id);

            DB::commit();
            return redirect('setting-flow')->with('success', 'Berhasil tambah setting flow');
        } catch (Exception $e){
            DB::rollback();
            return back()->withError('Gagal tambah setting flow');
        }
    }

    public function edit ($id)
    {
        $aksi = 'Update';
        $jabatan = DB::table('jabatan')->get();
        $data = SettingFlow::findOrFail($id);

        return view('setting-flow/form', compact('aksi', 'jabatan', 'data'));
    }

    public function update (Request $request)
    {
        SettingFlow::find($request->id)->update($request->all());
        return redirect('setting-flow')->with('success', 'Update data berhasil');
    }
}
