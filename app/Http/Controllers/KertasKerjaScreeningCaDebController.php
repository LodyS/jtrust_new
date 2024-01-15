<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use Auth;
use App\Models\StatusNak;
use App\Models\LoanApplicant;
use Illuminate\Http\Request;
use PDF;

class KertasKerjaScreeningCaDebController extends Controller
{
    public function index($id)
    {
        $data = LoanApplicant::where('uuid',$id)->firstOrFail();
        $opini = DB::table('opini_compliance')->where('loan_applicant_id', $id)->first();
        $status_nak = StatusNak::where('loan_applicant_id', $id)->toBase()->first();
        $setting_flow = DB::table('setting_flows')->where('jabatan_id', Auth::user()->jabatan)->first();
       
        if($setting_flow->status_worksheet_screening == 'Yes' || $setting_flow->return_worksheet_screening == 'Yes' || Auth::user()->jabatan_user->kode == 'compliance_division_head'):
            return view('workflow/lembar-opini/lembar-kertas-kerja-screening-calon-debitur', compact('data', 'id', 'setting_flow', 'status_nak'));
        else:
            abort(403);
        endif;
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id'=>'required',
            'kertas_kerja_screening_cadeb'=>'required'
        ]);

        //dd($request->id);
        $update = LoanApplicant::where('uuid', $request->id)->first();

        if($update->return_status_kertas_kerja_screening == 'Yes'):

            $update->update([
                'return_status_kertas_kerja_screening'=>'Revisi'
            ]);

        endif;

        $update->update($validate);

        return back()->with('success', 'Berhasil update');
    }

    public function print($id)
    {
        $parsing = [
            'aml_cft_dep_head'=>User::where('jabatan', DB::table('jabatan')->where('kode', 'aml_cft_departemen_head')->first()->id)->value('name'),
            'aml_cft_section_head'=>User::where('jabatan', DB::table('jabatan')->where('kode', 'aml_cft_section_head')->first()->id)->value('name'),
            'compliance_div_head'=>User::where('jabatan', DB::table('jabatan')->where('kode', 'compliance_division_head')->first()->id)->value('name'),
            'data'=>LoanApplicant::find($id)->first(),
            'url'=>'print-kertas-kerja-screening-cadeb'
        ];

        $pdf = PDF::loadview('workflow/print/lembar-kertas-kerja-screening-calon-debitur', $parsing)->set_option('isRemoteEnabled', true);

        return $pdf->stream();
    }
}
