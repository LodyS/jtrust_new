<?php

namespace App\Http\Controllers;
use DB;
use App\Models\LoanApplicant;
use App\Models\StatusNak;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Traits\UploadFile;

class ManajemenPerusahaanController extends Controller
{
    use UploadFile;

    public function index (Request $request)
    {
        $data = LoanApplicant::where('uuid', $request->id)->first();

        $parsing = [
            'data'=>$data,
            'id'=>$request->id,
            'status_nak'=>StatusNak::where('loan_applicant_id', $request->id)->toBase()->first()
        ];

        return view('nak/manajemen-perusahaan', $parsing);
    }

    public function store(Request $request)
    {
        $jumlah = ($request->hasFile('foto')) ? count($request->file('foto')) : null;

        if($request->hasFile('foto')):

            for ($i=0; $i<$jumlah; $i++):

                $fotoo = $this->upload($request->file('foto')[$i], '', 'manajemen_perusahaan', 'Tambah');

                DB::table('form_002')->insert([
                    'sandi_bpr'=>$request->sandi_bpr,
                    'foto'=>$fotoo,
                    'nama'=>$request->nama[$i] ?? '',
                    'jabatan'=>$request->jabatan[$i] ?? '',
                    'pendidikan'=>$request->pendidikan[$i] ?? '',
                    'pengalaman_kerja'=>$request->pengalaman_kerja[$i] ?? '',
                    'created_at'=> \Carbon\Carbon::now(),
                    'updated_at'=>\Carbon\Carbon::now(),
                    'status_foto'=>'Y'
                ]);

            endfor;

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->sandi_bpr);

        endif;

        StatusNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'manajemen_perusahaan'=>'Yes'
        ]);

        return back()->with('success', 'Berhasil input');
    }
}
