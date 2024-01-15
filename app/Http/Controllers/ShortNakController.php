<?php

namespace App\Http\Controllers;
use App\Models\ShortNak;
use DB;
use App\User;
use App\Models\LoanApplicant;
use Illuminate\Http\Request;
use PDF;

class ShortNakController extends Controller
{
    public function index($id)
    {
        $url = 'header';
        $data = LoanApplicant::where('uuid', $id)->firstOrFail();
        $tanggal = date('d', strtotime($data->tanggal_nak));
        $bulan = bulan((int)date('m', strtotime($data->tanggal_nak)));
        $tahun = date('Y', strtotime($data->tanggal_nak));
        $tanggal = (int)$tanggal. ' ' .$bulan. ' '. $tahun;

        $departemenHead = User::select('atasan_id')->toBase()->where('id', $data->user_id)->first();
        $departemenHeadAtasan = $departemenHead->atasan_id ?? '';
        $departemenHead = User::where('id', $departemenHeadAtasan)->toBase()->first();

        $divisionHead = User::select('atasan_id')->toBase()->where('id', $departemenHeadAtasan)->first();
        $divisionHead = User::where('id', $divisionHead->atasan_id)->toBase()->first();
        $relationshipManager = User::where('id', $data->user_id)->toBase()->first();

        $jenis_pengajuan= $data->jenis_pengajuan;

        return view('short-nak/index', compact('data', 'departemenHead', 'divisionHead', 'tanggal', 'relationshipManager', 'id', 'url', 'jenis_pengajuan'));
    }

    public function informasiDebitur(Request $request)
    {
        $applicant = LoanApplicant::select('sandi_bpr')->where('uuid', $request->id)->toBase()->first();
        $parsing = [
            'id'=>$request->id,
            'data'=>DB::table('form_00')->where('uuid', $applicant->sandi_bpr)->first(),
            'url'=>'informasi-debitur',
            'applicant'=>$applicant
        ];

        return view('short-nak/informasi-debitur', $parsing);
    }

    public function latarBelakang (Request $request)
    {
        $parsing = [
            'app'=>LoanApplicant::where('uuid', $request->id)->first(),
            'sandi_bpr'=>LoanApplicant::where('uuid', $request->id)->value('sandi_bpr'),
            'data'=>ShortNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'url'=>'latar-belakang',
            'id'=>$request->id,
        ];

        return view('short-nak/latar-belakang', $parsing);
    }

    public function pembahasan (Request $request)
    {
        $parsing = [
            'app'=>LoanApplicant::where('uuid', $request->id)->first(),
            'sandi_bpr'=>LoanApplicant::where('uuid', $request->id)->value('sandi_bpr'),
            'data'=>ShortNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'url'=>'pembahasan',
            'id'=>$request->id,
        ];

        return view('short-nak/pembahasan', $parsing);
    }

    public function usulan (Request $request)
    {
        $parsing = [
            'app'=>LoanApplicant::where('uuid', $request->id)->first(),
            'data'=>ShortNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'url'=>'usulan',
            'id'=>$request->id,
            'app'=>LoanApplicant::where('uuid', $request->id)->first(),
        ];

        return view('short-nak/usulan', $parsing);
    }

    public function disclaimer (Request $request)
    {
        $parsing = [
            'data'=>ShortNak::where('loan_applicant_id', $request->id)->toBase()->first(),
            'url'=>'disclaimer',
            'id'=>$request->id,
            'sandi_bpr'=>LoanApplicant::where('uuid', $request->id)->value('sandi_bpr'),
        ];

        return view('short-nak/disclaimer', $parsing);
    }

    public function updateLoanApplicant(Request $request)
    {
        LoanApplicant::whereRaw('id = ?', $request->id)->update($request->except('_token'));
        return back()->with('success', 'Berhasil simpan data');
    }

    public function update(Request $request)
    {
        $cek = ShortNak::where('loan_applicant_id', $request->loan_applicant_id)->first();
        $latar_belakang = $cek->latar_belakang ?? '';
        $pembahasan = $cek->pembahasan ?? '';
        $usulan = $cek->usulan ?? '';
        $disclaimer = $cek->disclaimer ?? '';

        ShortNak::updateOrCreate([
            'loan_applicant_id'=>$request->loan_applicant_id
        ],[
            'latar_belakang'=>$request->latar_belakang ?? $latar_belakang,
            'pembahasan'=>$request->pembahasan ?? $pembahasan,
            'usulan'=>$request->usulan ?? $usulan,
            'disclaimer'=>$request->disclaimer ?? $disclaimer
        ]);

        return back()->with('success', 'Berhasil simpan data');
    }

    public function print($id)
    {
        $data = LoanApplicant::where('uuid', $id)->firstOrFail();
        $departemenHead = User::select('atasan_id')->toBase()->where('id', $data->user_id)->first();
        $departemenHeadAtasan = $departemenHead->atasan_id ?? '';
        $divisionHead = User::select('atasan_id')->toBase()->where('id', $departemenHeadAtasan)->first();

        $parsing = [
            'data'=>$data,
            'departemenHead'=>User::where('id', $departemenHeadAtasan)->toBase()->first(),
            'divisionHead'=>User::where('id', $divisionHead->atasan_id)->toBase()->first(),
            'relationshipManager'=>User::where('id', $data->user_id)->toBase()->first(),
            'dataa'=>ShortNak::where('loan_applicant_id', $id)->toBase()->first(),
            'bpr'=>DB::table('form_00')->where('uuid', $data->sandi_bpr)->first(),
            'jenis_pengajuan'=>$data->jenis_pengajuan,
        ];

        $pdf = PDF::loadview('short-nak/print', $parsing)->set_option('isRemoteEnabled', true);

        return $pdf->stream();
    }
}
