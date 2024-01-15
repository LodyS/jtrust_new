<?php

namespace App\Http\Controllers;
use DB;
use DataTables;
use App\Models\FasilitasKredit;
use App\Http\Requests\FasilitasKreditRequest;
use App\Models\Log;
use Illuminate\Http\Request;

class FasilitasKreditController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()):

            $data = DB::table('fasilitas_kredits')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $actionBtn = route_general(route('fasilitas-kredit.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('fasilitas-kredit.destroy', [$row->id]));

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('setup-user/fasilitas-kredit/index');
    }

    public function create()
    {
        return view('setup-user/fasilitas-kredit/form');
    }

    public function store(FasilitasKreditRequest $request)
    {
        $data = FasilitasKredit::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('fasilitas-kredit')->with('success', 'Berhasil input fasilitas kredit');
    }

    public function edit(FasilitasKredit $fasilitasKredit)
    {
        return view('setup-user/fasilitas-kredit/form', compact('fasilitasKredit'));
    }

    public function update(FasilitasKreditRequest $request, FasilitasKredit $fasilitasKredit)
    {
        $fasilitasKredit->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('fasilitas-kredit')->with('success', 'Berhasil edit fasilitas kredit');
    }

    public function destroy(Request $request, FasilitasKredit $fasilitasKredit)
    {
        $fasilitasKredit->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);
        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
