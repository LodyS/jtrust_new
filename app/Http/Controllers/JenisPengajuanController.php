<?php

namespace App\Http\Controllers;
use App\Models\JenisPengajuan;
use DB;
use Auth;
use DataTables;
use App\Models\Log;
use App\Http\Requests\JenisPengajuanRequest;
use Illuminate\Http\Request;

class JenisPengajuanController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):

            $data = DB::table('jenis_pengajuan')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('jenis-pengajuan.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('jenis-pengajuan.destroy', [$row->id]));

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view ('setup-user/jenis-pengajuan/index');
    }

    public function create()
    {
        return view('setup-user/jenis-pengajuan/form');
    }

    public function store(JenisPengajuanRequest $request)
    {
        $data = JenisPengajuan::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('jenis-pengajuan')->with('success', 'Berhasil tambah Jenis Pengajuan');
    }

    public function edit(JenisPengajuan $jenisPengajuan)
    {
        return view('setup-user/jenis-pengajuan/form', compact('jenisPengajuan'));
    }

    public function update(JenisPengajuanRequest $request, JenisPengajuan $jenisPengajuan)
    {
        $jenisPengajuan->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('/jenis-pengajuan')->with('success', 'Jenis Pengajuan berhasil di update');
    }

    public function destroy (Request $request, JenisPengajuan $jenisPengajuan)
    {
        $jenisPengajuan->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $jenisPengajuan->id);

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
