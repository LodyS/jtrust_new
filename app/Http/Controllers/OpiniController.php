<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\User;
use DataTables;
use App\Models\LoanApplicant;
use App\Models\StatusAplicant;
use App\Models\InformasiPokokBprPelapor;
use App\Models\LembarOpiniLegal;
use App\Models\LembarOpiniLegalDetail;
use App\Models\OpiniCompliance;
use App\Models\OpiniComplianceDetail;
use App\Models\OpiniCad;
use App\Models\OpiniCadDetail;
use App\Models\StatusNak;
use Illuminate\Http\Request;

class OpiniController extends Controller
{
    public function ca($id)
    {
        $data = LoanApplicant::where('uuid',$id)->firstOrFail();
        $hak_ases = DB::table('setting_flows')->where('jabatan_id', Auth::user()->jabatan)->value('status_cad_opini');
       
        if(Auth::user()->divisi !== 'Credit Administration'):
            abort(403);
        endif;

        $divisionHead = DB::table('users')
        ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan')
        ->where('nama_jabatan', 'Credit Administration Division Head')
        ->select('name', 'users.id')
        ->first();

        $sectionHead = DB::table('users')
        ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan')
        ->where('users.id', Auth::user()->id)
        ->where('nama_jabatan', 'Credit Administration Section Head')
        ->select('name', 'users.id')
        ->first();

        $parsing = [
            'id'=>$id,
            'data'=>LoanApplicant::where('uuid',$id)->first(),
            'divisionHead'=>$divisionHead,
            'sectionHead'=>$sectionHead,
            'opini'=>DB::table('opini_cad')->where('loan_applicant_id', $id)->first(),
            'jenis_pengajuan'=>$data->jenis_pengajuan,
            'status_nak'=>StatusNak::where('loan_applicant_id', $id)->toBase()->first(),
            'hak_akses'=>DB::table('setting_flows')->where('jabatan_id', Auth::user()->jabatan)->value('status_cad_opini'),
        ];

        return view('workflow/lembar-opini/credit-administration')->with($parsing);

    }

    public function legal ($id)
    {
        $data = LoanApplicant::where('uuid',$id)->firstOrFail();

        if ($data->legal_division_head !== 'Sudah proses' && Auth::user()->divisi !== 'Legal'):
            abort(403);
        endif;

        $atasan = DB::table('users')
        ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan')
        ->where('nama_jabatan', 'Legal Division Head')
        ->select('name', 'users.id')
        ->first();

        $sectionHead = DB::table('users')
        ->select('name', 'users.id')
        ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan')
        ->where('nama_jabatan', 'Legal Section Head')
        ->first();

        $opini = DB::table('lembar_opini_legal')->where('loan_applicant_id', $id)->first();

        $parsing = [
            'id'=>$id,
            'data'=>$data,
            'url'=>'legal-opini',
            'informasiPokokBpr'=>InformasiPokokBprPelapor::where('uuid', $data->sandi_bpr)->toBase()->first(),
            'jenis_pengajuan'=>DB::table('jenis_pengajuan')->get(),
            'pertanyaan'=>DB::table('master_pertanyaan')->get(),
            'sectionHead'=>$sectionHead,
            'divisionHead'=>$atasan,
            'opini'=>$opini,
            'status_nak'=>StatusNak::where('loan_applicant_id', $id)->toBase()->first(),
        ];

        return view('workflow/lembar-opini/legal')->with($parsing);
    }

    public function compliance($id)
    {
        $data = LoanApplicant::where('uuid',$id)->firstOrFail();
        $opini = DB::table('opini_compliance')->where('loan_applicant_id', $id)->first();
        $opini_id = $opini->id ?? null;

        $div_head = $data->compliance_division_head;
        $dep_head_compliance = $data->compliance_departemen_head;
        $dep_head = $data->aml_cft_dep_head;

        $jabatan = Auth::user()->jabatan_user->nama_jabatan;
        $kertas_kerja = $data->kertas_kerja_screening_cadeb;
        $status = $data->return_status_kertas_kerja_screening;
        $array_status = array(null, 'Yes');

        $status_dep_head = $data->return_status_kertas_kerja_screening_dep_head;
        $status = $data->return_status_kertas_kerja_screening;
        $array_status = array(null, 'Yes');

        $setting_flow = DB::table('setting_flows')->where('jabatan_id', Auth::user()->jabatan)->first();

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

        $opini_detail = DB::table('opini_compliance_detail')
        ->select(
            'opini_compliance_detail.id as id_detail',
            'identifikasi',
            'pertanyaan',
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
            'setting_flow'=>DB::table('setting_flows')->where('jabatan_id', Auth::user()->jabatan)->first(),
            'jenis_pengajuan'=>$data->jenis_pengajuan,
            'status_nak'=>StatusNak::where('loan_applicant_id', $id)->toBase()->first(),
        ];

        if($setting_flow->status_compliance_opini == 'Yes' || $setting_flow->return_compliance_opini == 'Yes' || Auth::user()->jabatan_user->kode == 'compliance_division_head'):
            if ($opini == null):
                return view('workflow/lembar-opini/compliance')->with($parsing);
            else:
                return view('workflow/lembar-opini/edit-compliance')->with($parsing);
            endif;
        else:
            abort(403);
        endif;
    }

    public function storeLegal(Request $request)
    {
        DB::beginTransaction();

        try {

            $opiniLegal = LembarOpiniLegal::updateOrCreate([
                'loan_applicant_id'=>$request->loan_applicant_id
            ],[
                'tanggal'=>$request->tanggal,
                'section_head'=>$request->section_head,
                'division_head'=>$request->division_head,
                'no_legal_opini'=>$request->no_legal_opini,
                'catatan'=>$request->catatan,
                'lembar_opini'=>$request->lembar_opini,
            ]);

            $update = LoanApplicant::where('uuid', $request->loan_applicant_id)->first();

            if ($update->return_opini_legal == 'Yes'):
                $update->update(['return_opini_legal'=>'Revisi Opini']);  //3
            endif;

            DB::commit();

            return redirect('proses-workflow')->with('success', 'Berhasil simpan opini Legal');
            //return redirect('workflow-legal-section-head')->with('success', 'Berhasil simpan opini legal');
        } catch (Exception $e){
            DB::rollbak();
            return back()->withError('Gagal Simpan');
        }
    }

    public function storeCompliance(Request $request)
    {
        DB::beginTransaction();

        try {

            $cek = opiniCompliance::where('loan_applicant_id', $request->loan_applicant_id)->first();

            $opini = OpiniCompliance::updateOrCreate([
                'loan_applicant_id'=>$request->loan_applicant_id
            ],[
                'section_head'=>$request->section_head,
                'division_head'=>$request->division_head,
                'departemen_head'=>$request->departemen_head,
                'catatan'=>$request->catatan,
                'lembar_opini'=>$request->lembar_opini
            ]);

            if($cek == null):
                for($i=0; $i<count($request->pertanyaan_id); $i++):
                    
                    DB::table('opini_compliance_detail')
                    ->insert([
                        'opini_compliance_id'=>$opini->id,
                        'pertanyaan_id'=>$request->pertanyaan_id[$i],
                        'catatan_rekomendasi_mitigasi'=>$request->catatan_rekomendasi_mitigasi[$i],
                        'identifikasi'=>$request->identifikasi[$i],
                        'created_at'=>\Carbon\Carbon::now(),
                    ]);

                endfor;

            else: 

                for($i=0; $i<count($request->pertanyaan_id); $i++):
                    DB::table('opini_compliance_detail')
                    ->where('id', $request->opini_detail[$i])
                    ->update([
                        'catatan_rekomendasi_mitigasi'=>$request->catatan_rekomendasi_mitigasi[$i],
                        'identifikasi'=>$request->identifikasi[$i],
                        'updated_at'=>\Carbon\Carbon::now(),
                    ]);
                endfor;

            endif;

            $update = LoanApplicant::where('uuid', $request->loan_applicant_id)->first();

            if ($update->return_opini_compliance == 'Yes'):
                $update->update(['return_opini_compliance'=>'Revisi Opini']);  //3
            endif;

            DB::commit();

            return redirect('proses-workflow')->with('success', 'Berhasil simpan opini compliance');
        } catch (Exception $e){
            DB::rollbak();
            return back()->withError('Gagal Simpan');
        }
    }

    public function storeCad(Request $request)
    {
        DB::beginTransaction();

        try {

            $opini = OpiniCad::updateOrcreate([
                'loan_applicant_id'=>$request->loan_applicant_id
            ],[
                'rekomendasi'=>$request->rekomendasi,
                'catatan'=>$request->catatan,
                'penjelasan_mitigasi'=>$request->penjelasan_mitigasi,
                'section_head'=>$request->section_head,
                'division_head'=>$request->division_head,
                'penjelasan_agunan_fixed_asset'=>$request->penjelasan_agunan_fixed_asset,
                'fixed_asset_non_marketable'=>json_encode($request->fixed_asset_non_marketable),
                'opini'=>$request->opini
            ]);

            $update = LoanApplicant::where('uuid', $request->loan_applicant_id)->first();

            if ($update->return_opini_cad == 'Yes'):
                $update->update(['return_opini_cad'=>'Revisi Opini']);  //3
            endif;

            DB::commit();

            return redirect('proses-workflow')->with('success', 'Berhasil simpan opini legal');
        } catch (Exception $e){
            DB::rollbak();
            return back()->withError('Gagal Simpan');
        }
    }
}
