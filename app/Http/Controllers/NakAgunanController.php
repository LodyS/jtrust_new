<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Agunan;
use App\Models\StatusNak;
use App\Models\Log;
use App\Models\LoanApplicant;
use Illuminate\Http\Request;

class NakAgunanController extends Controller
{
    public function index ($id)
    {
        $app = LoanApplicant::where('uuid', $id)->select('id', 'sandi_bpr', 'status_level_proses')->toBase()->first();
        $agunan = Agunan::where('sandi_bpr', $app->sandi_bpr)->toBase()->get();
        $status_nak = StatusNak::where('loan_applicant_id', $id)->toBase()->first();

        return view('nak/agunan', compact('id', 'agunan', 'app', 'status_nak'));
    }

    public function store(Request $request)
    {
        $req = $request->all();

        for ($i=0; $i<count($req['jenis_agunan']); $i++):

            $insert = array (
                'jenis_agunan'=>$req['jenis_agunan'][$i],
                'nilai_pasar'=>$req['nilai_pasar'][$i],
                'nilai_bank'=>$req['nilai_bank'][$i],
                'nilai_pengikat'=>$req['nilai_pengikat'][$i],
                'sandi_bpr'=>$request->sandi_bpr,
            );

            Agunan::create($insert);

        endfor;

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'agunan'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }
}
