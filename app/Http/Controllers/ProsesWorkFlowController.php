<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use DataTables;
use App\Models\StatusAplicant;
use App\Models\LoanApplicant;
use App\Models\LembarOpiniLegal;
use App\Models\OpiniCad;
use Illuminate\Http\Request;
use App\Models\OpiniCompliance;
use App\Http\Requests\ProsesFlowRequest;
use App\Models\SettingFlow;
use App\Models\User;

class ProsesWorkFlowController extends Controller
{
    public function index(Request $request)
    {
        $data = LoanApplicant::master();

        $parameter['data'] = $data;

        if($request->ajax()):

            return LoanApplicant::datatabel($parameter)
            ->addColumn('action', function($row){
          
                $id=$row->id;
                $uuid = $row->uuid;

                $user_level_id = User::username(Auth::user()->id)->jabatan;
                $user_level_id = SettingFlow::where('jabatan_id', $user_level_id)->value('jabatan_id');
                $permission = SettingFlow::where('jabatan_id', $user_level_id)->first();
                
                // parameter ke function
                $parsing['id'] = $id;
                $parsing['uuid'] = $uuid;
                $parsing['sandi_bpr'] = $row->sandi_bpr;
                $parsing['pengajuan_induk_id'] = $row->pengajuan_induk_id;
                $parsing['level_user'] = $permission->level;
                $parsing['level_data'] = $row->status_level_proses;
                $parsing['pengajuan_induk_id'] = $row->pengajuan_induk_id; 
                $parsing['divisi'] = $permission->divisi;
                $parsing['status_division_head'] = $permission->status_division_head;

                // legal 
                $parsing['legal_section_head'] = $row->legal_section_head;
                $parsing['legal_division_head'] = $row->legal_division_head;
                $parsing['return_opini_legal'] = $row->return_opini_legal;
                $parsing['return_legal_opini'] =  $permission->return_legal_opini;
                $parsing['status_legal_opini'] =  $permission->status_legal_opini;

                // compliance
                $parsing['compliance_section_head'] = $row->compliance_section_head;
                $parsing['status_compliance_opini'] = $permission->status_compliance_opini;
                $parsing['return_opini_compliance'] = $row->return_opini_compliance;
                $parsing['return_compliance_opini'] = $permission->return_compliance_opini;
                $parsing['return_status_kertas_kerja_screening'] = $row->return_status_kertas_kerja_screening;
                $parsing['status_worksheet_screening'] = $permission->status_worksheet_screening;
                $parsing['return_worksheet_screening'] = $permission->return_worksheet_screening;
                $parsing['compliance_dept_head'] = $permission->compliance_dept_head;
                $parsing['aml_cft_section_head'] = $row->aml_cft_section_head;
                $parsing['aml_cft_dept_head'] = $row->aml_cft_dept_head;
                $parsing['compliance_departemen_head'] = $row->compliance_departemen_head;
                $parsing['compliance_division_head'] = $row->compliance_division_head;

                // cad 
                $parsing['return_cad_opini'] = $permission->return_cad_opini;
                $parsing['return_opini_cad'] = $row->return_opini_cad;
                $parsing['status_opini_cad'] = $permission->status_cad_opini;
                $parsing['cad_section_head'] = $row->cad_section_head;
                $parsing['cad_division_head'] = $row->cad_division_head;

                $action = LoanApplicant::actionDatatableAO($parsing);

                $status_proses = status_proses($parsing);

                if ($status_proses == 'Yes'):
                    $action .= button_general('proses-workflow', $uuid, 'Proses Data');
                else:
                    $action .= button_general('informasi-workflow', $uuid, 'Detail Proses');
                endif;

                $action .= '<div><div>';

                return $action;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        return view('workflow/index');
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $setting_flow = SettingFlow::where('jabatan_id', Auth::user()->jabatan)->first();
        $variable = LoanApplicant::proses($request->id);

        return view('workflow/proses/workflow-proses', compact('id', 'variable', 'setting_flow'));
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $variable = LoanApplicant::proses($request->id);

        return view('workflow/proses/informasi-workflow', compact('id', 'variable'));
    }

    public function store(ProsesFlowRequest $request)
    {
        $setting_flow = SettingFlow::where('jabatan_id', Auth::user()->jabatan)->first();
        
        DB::beginTransaction();
        
        try {
            
            $req = $request->except('_token');
            $req['loan_applicant_id'] = $request->loan_applicant_id;
            $req['tanggal_proses'] = date('Y-m-d H:i:s');
            $req['status'] = $request->status;
            $req['catatan'] = $request->catatan;
            $req['user_id'] = Auth::user()->id;
            $req['level_id'] = $request->level_id;
            $req['division_head'] = $setting_flow->status_division_head;

            StatusAplicant::create($req);

            $req['status'] = $request->status;

            if($request->divisi == 'Business Division' || $request->divisi == 'Credit Risk Reviewer'):
                $req['status_level_proses'] = $request->level_id + 1;
            endif;

            $update = LoanApplicant::where('uuid', $request->loan_applicant_id)->first();
            
            if($request->divisi == 'Business Division' || $request->divisi == 'Credit Risk Reviewer'):
                $rekues['status_level_proses'] = $req['status_level_proses'];
                $update->update($rekues);
            endif;

            if($request->status == 'Return to AO'):
                $update->update(['status_level_proses'=>'1']);
            endif;

            if($setting_flow->status_legal_opini == 'Yes' && $setting_flow->divisi == 'Legal'):
                $update->update(['legal_section_head'=>'Sudah Proses']);
            endif;

            if($setting_flow->status_compliance_opini == 'Yes'):
                $update->update(['compliance_section_head'=>'Sudah Proses']);
            endif;

            if($setting_flow->status_worksheet_screening == 'Yes'):
                $update->update(['aml_cft_section_head'=>'Sudah Proses']);
            endif;

            if ($setting_flow->return_legal_opini == 'Yes'):
                StatusAplicant::insertLegalOpini($req);
            endif;

            if($setting_flow->return_compliance_opini == 'Yes'):
                StatusAplicant::insertComplianceOpini($req);
            endif;

            if($setting_flow->return_worksheet_screening == 'Yes'):
                StatusAplicant::insertWorksheetScreening($req);
            endif;

            if($setting_flow->divisi == 'Compliance' && $setting_flow->status_division_head == 'Yes'):
                $update->update(['compliance_division_head'=>'Sudah Proses']);
            endif;

            if($setting_flow->status_cad_opini == 'Yes'):
                $update->update(['cad_section_head'=>'Sudah Proses']);
            endif;

            if($setting_flow->return_cad_opini == 'Yes'):
                StatusAplicant::insertCadOpini($req);
            endif;

            if($update->cad_division_head == 'Sudah Proses' && $update->legal_division_head == 'Sudah Proses' && $update->compliance_division_head == 'Sudah Proses'):
                $update->update(['status_level_proses'=>$request->level_id + 1]);
            endif;

            if($setting_flow->approval_status == 'Yes'):
                StatusAplicant::insertApprovalStatus($req);
            endif;

            DB::commit();
            return redirect('proses-workflow')->with('success', 'Update Data Successfull');

        } catch (\Illuminate\Database\QueryException $e){
            DB::rollback();
            return redirect('proses-workflow')->withError('Update Data failed');
        }
    }
}
