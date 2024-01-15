<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use DataTables;
use App\Models\JabatanBpr;
use App\Http\Requests\JabatanBprRequest;
Use App\Models\Log;
use Illuminate\Http\Request;

class JabatanBprController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):
            $data = DB::table('jabatan_bpr')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('jabatan-bpr.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('jabatan-bpr.destroy', [$row->id]));

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        endif;

        return view ('setup-user/jabatan-bpr/index');
    }

    public function create()
    {
        return view('setup-user/jabatan-bpr/form');
    }

    public function store(JabatanBprRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = JabatanBpr::create($request->validated());

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $data->id);

            DB::commit();
            return redirect('jabatan-bpr')->with('success', 'Berhasil tambah Jabatan BPR');
        } catch(Exception $e){
            DB::rollback();
            return back()->withError('Gagal simpan');
        }
    }

    public function edit(JabatanBpr $jabatanBpr)
    {
        return view('setup-user/jabatan-bpr/form', compact('jabatanBpr'));
    }

    public function update(JabatanBprRequest $request, JabatanBpr $jabatanBpr)
    {
        $jabatanBpr->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $jabatanBpr->id);

        return redirect('/jabatan-bpr')->with('success', 'Jabatan BPR berhasil di update');
    }

    public function destroy (Request $request, JabatanBpr $jabatanBpr)
    {
        $jabatanBpr->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $jabatanBpr->id);

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
