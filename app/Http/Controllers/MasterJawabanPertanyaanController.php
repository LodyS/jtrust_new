<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use DataTables;
use App\Models\MasterJawaban;
use App\Models\MasterPertanyaan;
use Illuminate\Http\Request;
use App\Models\Log;

class MasterJawabanPertanyaanController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):
            $data = DB::table('master_pertanyaan')->select('*');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('pertanyaan', function($row){
                $pertanyaan = '<textarea rows="8" cols="45" class="form-control" readonly>'.strip_tags($row->pertanyaan).'</textarea>';

                return $pertanyaan;
            })
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('master-jawaban-pertanyaan.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('master-jawaban-pertanyaan.destroy', [$row->id]));

                return $actionBtn;
            })
            ->escapeColumns([])
            ->rawColumns(['action'])
            ->make(true);
        endif;

        return view ('setup-user/master-jawaban-pertanyaan/index');
    }

    public function create()
    {
        return view('setup-user/master-jawaban-pertanyaan/form');
    }

    public function store(Request $request)
    {
        $pertanyaan = MasterPertanyaan::create($request->all());

        if(isset($request->jawaban)):
            for ($i=0; $i<count($request->jawaban); $i++):
                $insert = array (
                    'jawaban'=>$request->jawaban[$i],
                    'pertanyaan_id'=>$pertanyaan->id,
                    'profil_risiko'=>$request->profil_risiko[$i],
                );

                MasterJawaban::create($insert);
            endfor;
        endif;

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $pertanyaan->id);

        return redirect('master-jawaban-pertanyaan')->with('success', 'Berhasil tambah pertanyaan dan jawaban');
    }

    public function edit(MasterPertanyaan $master_jawaban_pertanyaan)
    {
        $jawaban = MasterJawaban::where('pertanyaan_id', $master_jawaban_pertanyaan->id)->toBase()->get();
        
        return view('setup-user/master-jawaban-pertanyaan/edit', compact('master_jawaban_pertanyaan', 'jawaban'));
    }

    public function update(Request $request, MasterPertanyaan $master_jawaban_pertanyaan)
    {
        $master_jawaban_pertanyaan->update($request->all());

        if(isset($request->jawaban)):
            $jumlah = count($request->jawaban);

            for ($i=0; $i<$jumlah; $i++):

                DB::table('master_jawaban')
                ->where('id', $request->jawaban_id[$i])
                ->update([
                    'jawaban'=>$request->jawaban[$i],
                    'profil_risiko'=>$request->profil_risiko[$i],
                ]);

            endfor;

        endif;

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('/master-jawaban-pertanyaan')->with('success', 'Pertanyaan dan jawaban berhasil di update');
    }

    public function destroy (Request $request, MasterPertanyaan $master_jawaban_pertanyaan)
    {
        $master_jawaban_pertanyaan->delete();

        MasterJawaban::where('pertanyaan_id', $master_jawaban_pertanyaan->id)->first();
        
        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $master_jawaban_pertanyaan->id);

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
