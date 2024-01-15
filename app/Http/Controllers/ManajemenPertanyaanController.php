<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Models\Log;
use App\Models\ManajemenPertanyaan;
use DataTables;
use App\Http\Requests\ManajemenPertanyaanRequest;
use Illuminate\Http\Request;

class ManajemenPertanyaanController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()):

            $data = DB::table('manajemen_pertanyaan')->select('*');

            return Datatables::of($data)
            ->addColumn('min_max', function($row){
                $pertanyaan = '<p>Minimal : '.$row->range_skor_minimal.'</p><p>Maksimal : '.$row->range_skor_maksimal.'</p>';

                return $pertanyaan;
            })
            ->addColumn('detail_pertanyaan', function($row){
                $pertanyaan = '<textarea rows="12" cols="45" class="form-control" font-size: 9px; readonly>'.strip_tags($row->detail_pertanyaan).'</textarea>';

                return $pertanyaan;
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('manajemen-pertanyaan.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('manajemen-pertanyaan.destroy', [$row->id]));

                return $actionBtn;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('config/manajemen-pertanyaan/index');
    }

    public function create ()
    {
        return view('config/manajemen-pertanyaan/form');
    }

    public function store (ManajemenPertanyaanRequest $request)
    {
        $data = ManajemenPertanyaan::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect()->route('manajemen-pertanyaan.index')->with('success', 'Success tambah manajemen pertanyaan');
    }

    public function edit (ManajemenPertanyaan $manajemenPertanyaan)
    {
        return view('config/manajemen-pertanyaan/form', compact('manajemenPertanyaan'));
    }

    public function update(ManajemenPertanyaanRequest $request, ManajemenPertanyaan $manajemenPertanyaan)
    {
        $manajemenPertanyaan->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect()->route('manajemen-pertanyaan.index')->with('success', 'Berhasil update');
    }

    public function destroy(ManajemenPertanyaan $manajemen_pertanyaan)
    {
        $log = new Log;
        $log->storeLog('', $manajemen_pertanyaan->id, 'manajemen_pertanyaan', 'Delete');

        $manajemen_pertanyaan->delete();

        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
