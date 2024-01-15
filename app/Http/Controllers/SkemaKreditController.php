<?php

namespace App\Http\Controllers;
use DB;
use DataTables;
use App\Models\SkemaKredit;
use App\Http\Requests\SkemaKreditRequest;
use App\Models\Log;
use Illuminate\Http\Request;

class SkemaKreditController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()):

            $data = DB::table('skema_kredit')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $actionBtn = route_general(route('skema-kredit.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('skema-kredit.destroy', [$row->id]));

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('setup-user/skema-kredit/index');
    }

    public function create()
    {
        return view('setup-user/skema-kredit/form');
    }

    public function store(SkemaKreditRequest $request)
    {
        $data = SkemaKredit::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('skema-kredit')->with('success', 'Berhasil input Skema Kredit');
    }

    public function edit(SkemaKredit $skemaKredit)
    {
        return view('setup-user/skema-kredit/form', compact('skemaKredit'));
    }

    public function update(SkemaKreditRequest $request, SkemaKredit $skemaKredit)
    {
        $skemaKredit->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('skema-kredit')->with('success', 'Berhasil edit Skema Kredit');
    }

    public function destroy(Request $request, SkemaKredit $skemaKredit)
    {
        $skemaKredit->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);
        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
