<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Jabatan;
use DataTables;
use App\Http\Requests\JabatanRequest;
use Auth;
use App\Models\Log;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):

            $data = DB::table('jabatan')->select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('jabatan.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('jabatan.destroy', [$row->id]));

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view ('setup-user/jabatan/index');
    }

    public function create()
    {
        $aksi = 'Create';
        $data = null;
        return view('setup-user/jabatan/form', compact('aksi', 'data'));
    }

    public function store(JabatanRequest $request)
    {
        $req = $request->validated();
        $req['kode'] = lower_spacing($request->nama_jabatan);
        $data = Jabatan::create($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('jabatan')->with('success', 'Berhasil tambah jabatan');
    }

    public function edit($id)
    {
        $data = Jabatan::findOrFail($id);
        $aksi = 'Update';

        return view('setup-user/jabatan/form', compact('data', 'aksi'));
    }

    public function update(JabatanRequest $request)
    {
        Jabatan::find($request->id)->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);
        return redirect('/jabatan')->with('success', 'Jabatan berhasil di update');
    }

    public function destroy (Request $request, Jabatan $jabatan)
    {
        $jabatan->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $jabatan->id);

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
