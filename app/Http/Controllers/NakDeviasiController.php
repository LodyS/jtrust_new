<?php

namespace App\Http\Controllers;
use App\Models\LoanApplicant;
use App\Models\StatusNak;
use App\Models\Log;
use App\Models\Deviasi;
use Auth;
use DB;
use App\Http\Requests\DeviasiRequest;
use Illuminate\Http\Request;

class NakDeviasiController extends Controller
{
    public function index(Request $request)
    {
        $deviasi = DB::table('deviasi')->where('loan_applicant_id', $request->id)->get();

        $param = [
            'data'=>LoanApplicant::where('uuid', $request->id)->firstOrFail(),
            'id'=>$request->id,
            'deviasi'=>$deviasi,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first(),
        ];

        return view('nak/deviasi', $param);
    }

    public function store(DeviasiRequest $request)
    {
        for($i=0; $i<count($request->ketentuan); $i++):

            DB::table('deviasi')->insert([
                'loan_applicant_id'=>$request->loan_applicant_id,
                'sandi_bpr'=>$request->sandi_bpr,
                'ketentuan'=>$request->ketentuan[$i],
                'deviasi'=>$request->deviasi[$i],
                'pertimbangan_dan_mitigasi'=>$request->pertimbangan_dan_mitigasi[$i],
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'deviasi'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }

    public function edit(Request $request)
    {
        abort_if(Auth::user()->jabatan_user->nama_jabatan !== 'Account Officer', 403);

        $nak_id = $request->nak_id;
        $data = Deviasi::findOrFail($request->id);

        return view('nak/edit-deviasi', compact('data', 'nak_id'));
    }

    public function update(Request $request)
    {
        Deviasi::find($request->id)->update($request->except('_token'));
        return redirect('nak-deviasi/'.$request->nak_id)->with('success', 'Berhasil update Deviasi');
    }

    public function destroy(Request $request)
    {
        $data = Deviasi::find($request->id)->delete();

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
