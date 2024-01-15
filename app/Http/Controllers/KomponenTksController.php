<?php

namespace App\Http\Controllers;
use App\Models\KomponenTks;
use DB;
use Auth;
use DataTables;
use App\Http\Requests\KomponenTksRequest;
use App\Models\Log;
use Illuminate\Http\Request;

class KomponenTksController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):

            $data = DB::table('komponen_tks')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('bobot', function($row){
                $bobot = $row->bobot. '%';

                return $bobot;
            })
            ->addColumn('minimum_ratio', function($row){

                if ($row->komponen == 'MANAJEMEN' || $row->komponen == 'MANAGEMENT' || $row->komponen == 'Management'):
                    $minimum_ratio = $row->minimum_ratio ?? '';
                else:
                     $minimum_ratio = $row->minimum_ratio. '%' ?? '';
                endif;

                return $minimum_ratio;
            })
            ->addColumn('perubahan_ratio', function($row){

                if ($row->komponen == 'MANAJEMEN' || $row->komponen == 'MANAGEMENT' || $row->komponen == 'Management'):
                    $perubahan_ratio = $row->perubahan_ratio ?? '';
                else:
                     $perubahan_ratio = $row->perubahan_ratio. '%' ?? '';
                endif;

                return $perubahan_ratio;
            })
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('komponen-tks.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('komponen-tks.destroy', [$row->id]));

                return $actionBtn;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('config/komponen-tks/index');
    }

    public function create ()
    {
        $aksi = 'Create';

        return view('config/komponen-tks/form', compact('aksi'));
    }

    public function store (KomponenTksRequest $request)
    {
        $sum = KomponenTks::sum('bobot');

        if ($sum <100):

            $data = KomponenTks::create($request->validated());

            $sum = KomponenTks::sum('bobot');

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $data->id);

            return redirect('/komponen-tks')->with('success', 'Data berhasil di simpan, total bobot : '. $sum);
        else:
            return back()->withError('Total bobot Komponen TKS sudah 100 persen, sudah tidak bisa input');
        endif;
    }

    public function edit(KomponenTks $komponen_tk)
    {
        return view('config/komponen-tks/form', compact('komponen_tk'));
    }

    public function update (KomponenTksRequest $request, KomponenTks $komponenTks)
    {
        $total = KomponenTks::sum('bobot');
        $bobot_lama = KomponenTks::where('id', $request->id)->value('bobot');
        $sum = ($total - $bobot_lama) + $request->bobot;

        if ($sum <=100):
    
            $komponenTks->update($request->validated());

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $request->id);

            return redirect('/komponen-tks')->with('success', 'Data berhasil di update');
        else:
            return redirect('/komponen-tks')->withError('Total bobot Komponen TKS sudah 100 persen, sudah tidak bisa update');
        endif;
    }

    public function destroy (Request $request, KomponenTks $komponenTks)
    {
        $komponenTks->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $komponenTks->id);

        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
