<?php

namespace App\Models;
use DB;
use App\User as Pengguna;
use Illuminate\Database\Eloquent\Model;

class StatusAplicant extends Model
{
    protected $table = 'status_aplicants';
    protected $fillable = ['loan_applicant_id', 'tanggal_proses', 'status', 'catatan', 'user_id', 'level_id', 'division_head'];

    public function userProses()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function userr()
    {
        return $this->hasOne(Pengguna::class, 'id', 'user_id');
    }

    public static function proses($id)
    {
        $status_applicant = StatusAplicant::where('loan_applicant_id', $id)
        ->with(['userProses', 'userr'])
        ->orderby('created_at', 'desc')
        ->get();

        return $status_applicant;
    }

    public static function divisiProses ($loan_applicant_id)
    {
        $data = DB::select("select loan_applicant_id, level_id as level, status from status_aplicants where id IN
        (select max(id) FROM status_aplicants group by loan_applicant_id, level_id)
        and loan_applicant_id=? order by cast(level_id as signed integer) asc",  [$loan_applicant_id]);

        return $data;
    }

    public static function insertLegalOpini($req)
    {
        $update = LoanApplicant::where('uuid', $req['loan_applicant_id'])->first();

        if($req['status'] == 'Return To Legal Opinion'):
            $opini = LembarOpiniLegal::where('loan_applicant_id', $req['loan_applicant_id'])->update(['status'=>'Return To Legal Opinion']);
            $upt = LoanApplicant::where('id', $req['loan_applicant_id'])->update(['return_opini_legal'=>'Yes']);
        else:
            LembarOpiniLegal::where('loan_applicant_id', $req['loan_applicant_id'])->update(['status'=>$req['status']]);
            $rekues['return_opini_legal'] = 'No';
            //$rekues['legal_section_head'] = 'Yes';
            $rekues['legal_division_head'] = 'Sudah Proses';

            $upt = $update->update($rekues);
        endif;

        return $upt;
    }

    public static function insertComplianceOpini($req)
    {
        $update = LoanApplicant::where('uuid', $req['loan_applicant_id'])->first();

        if($req['status'] == 'Return To Compliance Opini'):
            OpiniCompliance::where('loan_applicant_id', $req['loan_applicant_id'])->update(['status'=>'Return To Compliance Opini']);
            $upt = LoanApplicant::where('uuid', $req['loan_applicant_id'])->update(['return_opini_compliance'=>'Yes']);
        else:
            OpiniCompliance::where('loan_applicant_id', $req['loan_applicant_id'])->update(['status'=>$req['status']]);
            $rekues['return_opini_compliance'] = 'No';
            $rekues['compliance_departemen_head'] = 'Sudah Proses';
            $upt = $update->update($rekues);
        endif;

        return $upt;
    }

    public static function insertWorksheetScreening($req)
    {
        $update = LoanApplicant::where('uuid', $req['loan_applicant_id'])->first();

        if($req['status'] == 'Return Worksheet Screening'):
            $upt = LoanApplicant::where('uuid', $req['loan_applicant_id'])->update(['return_status_kertas_kerja_screening'=>'Yes']);
        else:
            $upt = $update->update(['return_status_kertas_kerja_screening'=>'No', 'aml_cft_dept_head'=>'Sudah Proses']);
        endif;

        return $upt;
    }
    
    public static function insertCadOpini($req)
    {
        $update = LoanApplicant::where('uuid', $req['loan_applicant_id'])->first();

        if($req['status'] == 'Return To CAD Opini'):
            OpiniCad::where('loan_applicant_id', $req['loan_applicant_id'])->update(['status'=>'Return To CAD Opini']);
            $upt = LoanApplicant::where('uuid', $req['loan_applicant_id'])->update(['return_opini_cad'=>'Yes']);
        else:
            OpiniCad::where('loan_applicant_id', $req['loan_applicant_id'])->update(['status'=>$req['status']]);
            $rekues['return_opini_cad'] = 'No';
            $rekues['cad_division_head'] = 'Sudah Proses';
            $upt = $update->update($rekues);
        endif;

        return $upt;
    }

    public static function insertApprovalStatus($req)
    {
        $upt = LoanApplicant::where('uuid', $req['loan_applicant_id'])->update(['status'=>$req['status'], 'status_level_proses'=>'Selesai']);

        return $upt;
    }
}
