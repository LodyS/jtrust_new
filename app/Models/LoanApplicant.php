<?php

namespace App\Models;
use DB;
use Auth;
use DataTables;
use App\Models\User;
use Carbon\Carbon;
use App\Models\StatusApplicant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LoanApplicant extends Model
{
    protected $table = 'loan_applicants';
    protected $primaryKey = 'id';
    protected $fillable =
    [
        'tanggal_apply',
        'produk_id',
        'sandi_bpr',
        'plafond',
        'tenor',
        'status',
        'user_id',
        'jenis_pengajuan',
        'no_nak_long_form',
        'divisi_bisnis_pengusul',
        'kode_buc',
        'no_surat',
        'tanggal_surat',
        'tanggal_surat_diterima',
        'permohonan_debitur',
        'tujuan_proposal',
        'fasilitas_debitur',
        'status_level_proses',
        'business_unit_division_id',

        'legal_section_head',
        'compliance_section_head',
        'compliance_departemen_head',
        'cad_section_head',
        'crrd_section_head',
        'crrd_dep_head',
        'kondisi_khusus',
        'bunga',
        'catatan_tambahan_fasilitas_kredit',
        'financial_highlight',
        'crrd_deputy_division_head',
        'crrd_division_head',
        'cad_division_head',
        'legal_division_head',
        'compliance_division_head',

        'no_nak_short',
        'tanggal_nak_short',
        'no_surat_debitur',
        'tanggal_kunjungan_terakhir',
        'tanggal_surat_debitur',
        'tanggal_dokumen_lengkap_diterima',
        'tanggal_call_report',
        'no_lembar_keputusan_kredit',
        'tanggal_lkk',
        'tanggal_nak',
        'catatan_lkk',
        'plafond_disetujui',
        'provisi',
        'biaya_administrasi',

        //tambahan
        'jenis_fasilitas_kredit',
        'limit_fasilitas_kredit',
        'sifat_fasilitas_kredit',
        'tujuan_penggunaan',
        'jangka_waktu_fasilitas_kredit',
        'jangka_waktu_penarikan_fasilitas_kredit',
        'grace_period',
        'lain_lain',
        // no arr
        'no_arr',
        'kertas_kerja_screening_cadeb',
        'aml_cft_dept_head',
        'aml_cft_section_head',

        'plafond_fasilitas_debitur',
        'skema_kredit',
        'jangka_waktu_penarikan',
        'bwmk',

        'plafond_permohonan_debitur_tambahan_kab',
        'total_plafond_setelah_tambahan',
        'return_opini_legal',
        'return_opini_compliance',
        'return_opini_cad',
        'return_status_kertas_kerja_screening',
        'return_status_kertas_kerja_screening_dep_head',

        'baki_debet',
        'tenor_perpanjang',
        'pengajuan_induk_id',
        'catatan_tambahan_fasilitas_kredit',
        'uuid',
        'outstanding',
        'label_biaya_provisi',
        'plafon_lama',
        'pemakaian'
    ];

    public static function master()
    {
        $id_user = Auth::user()->id;
        $atasan_id = User::atasan($id_user);

        $data = DB::table('loan_applicants')
        ->select(
            'loan_applicants.id',
            'tanggal_apply',
            //'form_00.sandi_bpr',
            'form_00.nama_bpr',
            'plafond',
            'users.name',
            'baki_debet',
            'tenor',
            'loan_applicants.status',
            'status_level_proses',
            'alamat_bpr',
            'legal_section_head',
            'compliance_section_head',
            'cad_section_head',
            'crrd_section_head',
            'atasan_id',
            'compliance_departemen_head',
            'legal_division_head',
            'cad_division_head',
            'crrd_division_head',
            'compliance_division_head',
            'crrd_deputy_division_head',
            'crrd_dep_head',
            'aml_cft_section_head',
            'aml_cft_dept_head',
            'return_opini_legal',
            'return_opini_compliance',
            'return_opini_cad',
            'tenor_perpanjang',
            'pengajuan_induk_id',
            'return_status_kertas_kerja_screening',
            'return_status_kertas_kerja_screening_dep_head',
            'loan_applicants.uuid',
            'loan_applicants.sandi_bpr',
        )
        ->leftJoin('form_00', 'form_00.uuid', 'loan_applicants.sandi_bpr')
        ->leftJoin('users', 'users.id', 'loan_applicants.user_id')
        ->leftJoin('status_aplicants', 'status_aplicants.loan_applicant_id', 'loan_applicants.id')
        ->where(function($query) use ($id_user, $atasan_id){

            if (Auth::user()->jabatan_user->kode == 'account_officer'):
                $query->where('loan_applicants.user_id', $id_user);
            endif;

            if (Auth::user()->jabatan_user->kode == 'account_officer_departemen_head'):
                $query->where('atasan_id', $id_user)->orWhere('status_level_proses', 0);
            endif;

            if (Auth::user()->jabatan_user->kode == 'business_division_head'):
                $query->where('atasan_id', $atasan_id)->orWhereIn('status_level_proses', [0,1,2,3,4]);
            endif;

            $divisi = array('Credit Risk Reviewer', 'Legal', 'Compliance', 'Credit Administration');

            if(in_array(Auth::user()->divisi, $divisi)):
               $query->where('status_level_proses', '>', 2)->orWhere('status_level_proses', 'Selesai');
            endif;
        })
        ->orderByDesc('loan_applicants.id')
        ->groupBy('loan_applicants.id');

        return $data;
    }

    public static function datatabel ($parameter)
    {
        $data = $parameter['data'];

        $data = Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('tanggal_apply', function($row){
            
            $tanggal_apply = '<p>'.date('d-m-Y', strtotime($row->tanggal_apply)).'</p>';
            $tanggal_lamar = Carbon::parse($row->tanggal_apply);

            if(isset($row->pengajuan_induk_id)):
    
                $tenor_induk = LoanApplicant::pengajuanInduk($row->pengajuan_induk_id)->tenor ?? '';
                $tanggal_induk = LoanApplicant::pengajuanInduk($row->pengajuan_induk_id)->tanggal_apply ?? '';
                $tanggal_induk = Carbon::parse($tanggal_induk);
                $tanggal_expirasi = tanggal_expirasi($tanggal_induk, $tenor_induk);
                $tanggal_expirasi = $tanggal_expirasi;

                $tanggal_beda = Carbon::parse($row->tanggal_apply)->diffInDays(Carbon::parse($tanggal_expirasi)); 

                $telat = '<p style="color:red">Telat : '.$tanggal_beda.' Hari</p>';

                $tanggal_apply .= ($row->tanggal_apply >= $tanggal_expirasi) ? $telat : '';
            endif;

            return $tanggal_apply;
        })
        ->addColumn('status', function($row){
           
            $status = [
                'Disetujui'=>'<span style="color:green">&#8226;</span> Approved',
                'Tidak Disetujui'=>'<span style="color:red">&#8226;</span> Rejected',
                'Diproses'=>'<span style="color:blue">&#8226;</span> Process',
                'Waiting'=>'<span style="color:orange">&#8226;</span> Process'
            ][$row->status];

            return $status;
        })
        ->addColumn('tenor', function($row){
            $tenor = $row->tenor. ' bulan';
            $tenor_perpanjang = 'Perpanjangan : <br/>'.$row->tenor_perpanjang.' bulan';
            $tenor = ($row->pengajuan_induk_id == null) ? $tenor : $tenor_perpanjang;

            return $tenor;
        })
        ->addColumn('plafond', function($row){

            $baki_debet = 'Rp '. number_format((float)$row->baki_debet ?? 0);
            $plafond = 'Rp '. number_format((float)$row->plafond ?? 0);
            $plafond = ($row->pengajuan_induk_id == null) ? $plafond : $baki_debet;

            return $plafond;
        });
     
        return $data;
    }

    public function master_bpr()
    {
        return $this->hasMany('App\Models\InformasiPokokBprPelapor', 'uuid', 'sandi_bpr');
    }

    public function setSkemaKreditAttribute($value)
    {
        $this->attributes['skema_kredit'] = json_encode($value);
    }

    public function getSkemaKreditAttribute($value)
    {
        return $this->attributes['skema_kredit'] = json_decode($value);
    }

    public function setPlafondAttribute($value)
    {
        return $this->attributes['plafond'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setBiayaAdministrasiAttribute($value)
    {
        return $this->attributes['biaya_administrasi'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setLimitFasilitasKreditAttribute($value)
    {
        return $this->attributes['limit_fasilitas_kredit'] = preg_replace('/[^0-9]/', '', $value);
    }

    /*public function setProvisiAttribute($value)
    {
        return $this->attributes['provisi'] = preg_replace('/[^0-9]/', '', $value);
    }*/

    public function setPlafondFasilitasDebiturAttribute($value)
    {
        return $this->attributes['plafond_fasilitas_debitur'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setPlafondPermohonanDebiturTambahanKabAttribute($value)
    {
        return $this->attributes['plafond_permohonan_debitur_tambahan_kab'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setBakiDebetAttribute($value)
    {
        return $this->attributes['baki_debet'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setOutstandingAttribute($value)
    {
        return $this->attributes['outstanding'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setPlafonLamaAttribute($value)
    {
        return $this->attributes['plafon_lama'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setPemakaianAttribute($value)
    {
        return $this->attributes['pemakaian'] = preg_replace('/[^0-9]/', '', $value);
    }

    public static function jenisPengajuan($value)
    {
        $jenis_pengajuan = str_replace('[', '', $value);
        $jenis_pengajuan = str_replace(']', '', $jenis_pengajuan);
        $jenis_pengajuan = str_replace('"', '', $jenis_pengajuan);
        $jenis_pengajuan = explode(',', $jenis_pengajuan);

        return $jenis_pengajuan;
    }

    public static function jenisFasilitasKredit($value)
    {
        $jenis_fasilitas_kredit = str_replace('[', '', $value);
        $jenis_fasilitas_kredit = str_replace(']', '', $jenis_fasilitas_kredit);
        $jenis_fasilitas_kredit = str_replace('"', '', $jenis_fasilitas_kredit);
        $jenis_fasilitas_kredit = explode(',', $jenis_fasilitas_kredit);

        return $jenis_fasilitas_kredit;
    }

    public static function proses($id)
    {
        $parameter['data'] = LoanApplicant::where('uuid',$id)->firstOrFail();
        $parameter['statusApplicant'] = StatusAplicant::proses($id);
        
        return $parameter;
    }

    public static function actionDatatable($id)
    {
        $action = '<div class="btn-group">';
        $action .= '<button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown">Action </button>';
        $action .= '<div class="dropdown-menu">';
        
        $report .= button_general('nak', $row->sandi_bpr, 'NAK');
        $report .= button_general('short-nak', $row->sandi_bpr, 'Short NAK');
        $report .= button_general('upload-documents-bpr', $row->sandi_bpr, 'Dokumen');
       
        return $action;
    }

    public static function actionDatatableAO($parsing)
    {
        $action = '<div class="btn-group">';
        $action .= '<button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown">Action </button>';
        $action .= '<div class="dropdown-menu">';

        if(Auth::user()->jabatan_user->kode == 'account_officer'):
            if($parsing['pengajuan_induk_id'] == null):
                $action .= button_general('edit-pengajuan-pinjaman', $parsing['uuid'], 'Edit');
            else:
                $action .= button_general('edit-perpanjangan-pinjaman', $parsing['uuid'], 'Edit');
            endif;
        endif;
        
        if($parsing['pengajuan_induk_id'] == null):
            $action .= button_general('nak', $parsing['uuid'], 'NAK');
        else:
            $action .= button_general('short-nak', $parsing['uuid'], 'Short NAK');
        endif;

        if($parsing['status_legal_opini'] == 'Yes' || Auth::user()->divisi == 'Legal'):
            $action .= button_general('legal-opini', $parsing['uuid'], 'Opini Legal');
        endif;

        //if(Auth::user()->jabatan_user->kode == 'compliance_division_head'):
        if(Auth::user()->divisi == 'Compliance'):
            if($parsing['status_worksheet_screening'] == 'Yes' || $parsing['return_worksheet_screening'] == 'Yes'):
                $action .= button_general('kertas-kerja-screening-calon-debitur', $parsing['uuid'], 'Worksheet Screening');
            endif;

            if($parsing['status_compliance_opini'] == 'Yes' || $parsing['return_compliance_opini'] == 'Yes'):
                $action .= button_general('compliance-opini', $parsing['uuid'], 'Opini Compliance');
            endif;
        endif;

        if($parsing['status_opini_cad'] == 'Yes' || Auth::user()->divisi == 'Credit Administration'):
            $action .= button_general('cad-opini', $parsing['uuid'], 'Opini CAD');
        endif;

        if(Auth::user()->divisi == 'Credit Risk Reviewer'):
            $action .= button_general('fiducia', $parsing['uuid'], 'Daftar Fiducia');
            $action .= button_general('arr', $parsing['uuid'], 'Analisis Risiko dan Rekomendasi');
        endif;

        $action .= button_general('upload-documents-bpr', $parsing['sandi_bpr'], 'Dokumen');

        if($parsing['pengajuan_induk_id'] == null && Auth::user()->jabatan_user->kode == 'account_officer'):
            $action .= button_general('perpanjangan-pinjaman', $parsing['uuid'], 'Perpanjangan Pinjaman');
        endif;

        $action .= button_general('detail-laporan-posisi-keuangan', $parsing['sandi_bpr'], 'Laporan Keuangan');
      
        if (Auth::user()->divisi == 'Credit Risk Reviewer'):
            $action .= button_general('edit-financial-highlight', $parsing['sandi_bpr'], 'Edit Financial Highlight');
        endif;

        return $action;
    }

    public static function pengajuanInduk($id)
    {
        $data = LoanApplicant::where('id', $id)->first();

        return $data;
    }
}
