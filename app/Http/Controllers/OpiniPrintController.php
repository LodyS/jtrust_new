<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\User;
use App\Models\LoanApplicant;
use App\Models\StatusAplicant;
use App\Models\InformasiPokokBprPelapor;
use App\Models\LembarOpiniLegal;
use App\Models\LembarOpiniLegalDetail;
use App\Models\OpiniCompliance;
use App\Models\OpiniComplianceDetail;
use App\Models\OpiniCad;
use App\Models\OpiniCadDetail;
use Illuminate\Http\Request;
use PDF;

class OpiniPrintController extends Controller
{
    public function ca($id)
    {
        $opini = OpiniCad::where('loan_applicant_id', $id)->firstOrFail();
        $data = LoanApplicant::where('id',$id)->first();

        $parsing = [
            'id'=>$id,
            'jenis_pengajuan'=>DB::table('jenis_pengajuan')->get(),
            'data'=>$data,
            'opini'=>$opini,
            'jenis_pengajuan'=>$data->jenis_pengajuan,
        ];

        return view('workflow/print/ca')->with($parsing);
    }

    public function legal($id)
    {
        $data = LoanApplicant::where('uuid',$id)->firstOrFail();
        $opini = LembarOpiniLegal::where('loan_applicant_id', $id)->firstOrFail();
        $opini_detail = DB::table('lembar_opini_legal_detail')
        ->selectRaw('lembar_opini_legal_detail.id as id_detail, legal_opini_id, catatan_rekomendasi_mitigasi')
        ->selectRaw('terpenuhi, profil_risiko, sub_judul, pertanyaan')
        ->leftJoin('master_pertanyaan', 'master_pertanyaan.id', 'lembar_opini_legal_detail.pertanyaan_id')
        ->where('legal_opini_id', $opini->id)
        ->get();

        $parsing = [
            'id'=>$id,
            'data'=>$data,
            'url'=>'legal-opini',
            'informasiPokokBpr'=>InformasiPokokBprPelapor::where('sandi_bpr', $data->sandi_bpr)->toBase()->first(),
            'jenis_pengajuan'=>DB::table('jenis_pengajuan')->get(),
            'pertanyaan'=>DB::table('master_pertanyaan')->get(),
            'opini'=>$opini,
            'opini_detail'=>$opini_detail
        ];

        return view('workflow/print/legal')->with($parsing);
    }

    public function compliance ($id)
    {
        $data = LoanApplicant::where('uuid',$id)->firstOrFail();

        $pertanyaan = DB::table('master_pertanyaan')
        ->selectRaw('master_pertanyaan.id as pertanyaan_id, master_jawaban.id as jawaban_id, pertanyaan')
        ->selectRaw('jawaban')
        ->leftJoin('master_jawaban', 'master_jawaban.pertanyaan_id', 'master_pertanyaan.id')
        ->where('jenis_pertanyaan', 'Compliance')
        ->get()
        ->groupBy([
            function($val){ return $val->pertanyaan; },
        ]);

        $divisionHead = DB::table('users')
        ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan')
        ->where('nama_jabatan', 'Compliance Division Head')
        ->select('users.id', 'name')
        ->first();

        $sectionHead = DB::table('users')
        ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan')
        ->where('nama_jabatan', 'Regulatory Compliance Section Head')
        ->select('users.id','name')
        ->first();

        $depHead = DB::table('users')
        ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan')
        ->where('nama_jabatan', 'Regulatory Compliance Department Head')
        ->select('users.id','name')
        ->first();

        $opini = OpiniCompliance::where('loan_applicant_id', $id)->firstOrFail();
        $opini_id = $opini->id ?? null;

        $opini_detail = DB::table('opini_compliance_detail')
        ->select(
            'opini_compliance_detail.id as id_detail',
            'identifikasi', 'pertanyaan',
            'opini_compliance_detail.pertanyaan_id',
            'jawaban',
            'catatan_rekomendasi_mitigasi'
        )
        ->leftJoin('master_pertanyaan', 'master_pertanyaan.id', 'opini_compliance_detail.pertanyaan_id')
        ->leftJoin('master_jawaban', 'master_jawaban.pertanyaan_id', 'master_pertanyaan.id')
        ->where('opini_compliance_id', $opini_id)
        ->where('jenis_pertanyaan', 'Compliance')
        ->get()
        ->groupBy([
             function($val){ return $val->pertanyaan; },
             function($val){ return $val->id_detail; },
             function($val){ return $val->catatan_rekomendasi_mitigasi; }
        ]);

        $parsing = [
            'id'=>$id,
            'opini'=>$opini,
            'opini_detail'=>$opini_detail,
            'pertanyaan'=>$pertanyaan,
            'divisionHead'=>$divisionHead,
            'sectionHead'=>$sectionHead,
            'depHead'=>$depHead,
            'data'=>$data,
            'jenis_pengajuan'=>$data->jenis_pengajuan,
        ];

        $pdf = PDF::loadview('workflow/print/compliance', $parsing)->set_option('isRemoteEnabled', true);

        return $pdf->stream();
    }
}
