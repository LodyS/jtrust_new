<?php

namespace App\Models;
use DB;
use DataTables;
use Auth;
use Illuminate\Database\Eloquent\Model;

class InformasiPokokBprPelapor extends Model
{
    protected $table = 'form_00';
    protected $primaryKey = 'id';
    protected $fillable = [
        'flag_detail',
        'nama_bpr',
        'alamat_bpr',
        'kabupaten_kota_bpr',
        'no_telepon',
        'npwp',
        'nama_penanggung_jawab_penyusun_laporan',
        'bagian_divisi',
        'no_telepon_penanggung_jawab_penyusun_laporan',
        'email',
        'nominal_deviden_yang_dibayar',
        'tahun_rpus_rat',
        'bonus_tahunan_dan_tantiem',
        'nama_kap_yang_mengaudit',
        'nama_ap_yang_menandatangani_laporan_audit',
        'pemeriksaan_ke_kap_yang_sama',
        'nilai_nominal_per_lembar_saham',
        'memiliki_izin_pva',
        'tanggal_izin_pva',
        'jumlah_pva',
        'nama_ultimate_shareholder',
        'user_id',
        'sandi_bpr',
        'tahun_pendirian_usaha',
        'jenis_usaha',
        'bidang_usaha',
        'bidang_ekonomi',
        'sub_bidang_ekonomi',
        'manajemen_inti_nama',
        'manajemen_inti_jabatan',
        'cp_nama',
        'cp_jabatan',
        'cp_no_telp',
        'cp_email',
        'group_usaha',
        'jenis_usaha_lainnya',
        'nomor_cif',
        'bulan_tahun_cif',
        'nama_group',
        'bidang_usaha_group',
        'tahun_pendirian_group',
        'keterangan',
        'kode_sektor_bi',
        'npwp_file',
        'kol_di_bank_jtrust',
        'informasi_grup_usaha',
        'uuid'
    ];

    public function storeInformasiPokokBprPelapor ($explodeLine)
    {
        $explodeLine[$explodeLine[0]] = isset($explodeLine[0]) ? $explodeLine[0] : 'Kosong';
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Kosong';
        $this->nama_bpr = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Kosong';
        $this->alamat_bpr = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Kosong';
        $this->kabupaten_kota_bpr = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[4]) ? $explodeLine[4] : 'Kosong';
        $this->no_telepon = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[5]) ? $explodeLine[5] : 'Kosong';
        $this->npwp = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[6]) ? $explodeLine[6] : 'Kosong';
        $this->nama_penanggung_jawab_penyusun_laporan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[7]) ? $explodeLine[7] : 'Kosong';
        $this->bagian_divisi = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[8]) ? $explodeLine[8] : 'Kosong';
        $this->no_telepon_penanggung_jawab_penyusun_laporan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[9]) ? $explodeLine[9] : 'Kosong';
        $this->email = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[10]) ? $explodeLine[10] : 'Kosong';
        $this->nominal_deviden_yang_dibayar = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[11]) ? $explodeLine[11] : 'Kosong';
        $this->tahun_rpus_rat = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[12]) ? $explodeLine[12] : 'Kosong';
        $this->bonus_tahunan_dan_tantiem = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[13]) ? $explodeLine[13] : 'Kosong';
        $this->nama_kap_yang_mengaudit = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[14]) ? $explodeLine[14] : 'Kosong';
        $this->nama_ap_yang_menandatangani_laporan_audit = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[15]) ? $explodeLine[15] : 'Kosong';
        $this->pemeriksaan_ke_kap_yang_sama = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[16]) ? $explodeLine[16] : 'Kosong';
        $this->nilai_nominal_per_lembar_saham = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[17]) ? $explodeLine[17] : 'Kosong';
        $this->memiliki_izin_pva = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[18]) ? $explodeLine[18] : 'Kosong';
        $this->tanggal_izin_pva = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[19]) ? $explodeLine[19] : 'Kosong';
        $this->jumlah_pva = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[20]) ? $explodeLine[20] : 'Kosong';
        $this->nama_ultimate_shareholder = $explodeLine[$explodeLine[0]];
        $this->user_id = $explodeLine['user_id'];
        $this->header_id = $explodeLine['header_id'];
        $this->sandi_bpr = $explodeLine['sandi_bpr'];
        $save = $this->save();

        return $save;
    }

    public static function namaBpr($sandi_bpr)
    {
        $data = InformasiPokokBprPelapor::where('uuid', $sandi_bpr)->first();

        return $data;
    }

    public static function master ($param)
    {
        $jabatan_user = $param['jabatan_user'];
        $id_user = $param['id_user'];

        $data = DB::table('form_00')
        ->selectRaw('form_00.id, nama_bpr, sandi_bpr, alamat_bpr, name, atasan_id, user_id, jabatan, uuid')
        ->selectRaw('CASE WHEN sandi_bpr IN (SELECT sandi_bpr FROM loan_applicants) THEN "Ada" ELSE "Tidak Ada" END AS status')
        ->leftJoin('users', 'users.id', 'form_00.user_id')
        ->where(function($query) use ($jabatan_user, $id_user){

            if ($jabatan_user == 'Account Officer'):
                $query->where('user_id', $id_user);
            endif;

            if ($jabatan_user == 'Account Officer Departemen Head'):
                $query->where('atasan_id', $id_user);
            endif;

            if ($jabatan_user == 'Business Division Head'):

                $query->whereIn('atasan_id', function($query) use($id_user){
                    $query->select('bawahan.id')
                    ->from('users')
                    ->leftJoin('users as bawahan', 'bawahan.atasan_id', 'users.id')
                    ->where('bawahan.atasan_id', $id_user);
                });

            endif;
        })
        ->orderBy('form_00.id');

        return $data;
    }

    public static function addColumn($parameter)
    {
        $data = $parameter['data'];

        $data = Datatables::of($data)->addIndexColumn()

        ->addColumn('alamat_bpr', function($row){
            $alamat_bpr = '<textarea rows="4" cols="50" class="form-control" readonly style="background-color:white;  border-left: none;
            border-right: none; border-bottom:none; border-top:none; ">'.strip_tags($row->alamat_bpr).'</textarea>';

            return $alamat_bpr;
        })
        ->addColumn('action', function($row){
            $actionBtn = '';
            $id_user = Auth::user()->id;
            $jabatan_user = Auth::user()->jabatan_user->nama_jabatan;

            $actionBtn = '
                <div class="dropdown">
                    <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                    <ul class="dropdown-menu">';
                        
            $actionBtn .= button_general('edit-list-bpr', $row->uuid, 'Edit');

            if ($row->status == 'Tidak Ada' && $jabatan_user == 'Account Officer'):
                $actionBtn .= '<li><a class="nav-link"  style="font-size: 11px;" href="javascript:void(0);" onClick="hapus('.$row->id.')">Delete</a></li>';
            endif;

            $actionBtn .= button_general('import-laporan-posisi-keuangan', $row->uuid, 'Upload Excel Laporan Keuangan');
            $actionBtn .= button_general('jawaban-pertanyaan-bpr', $row->uuid, 'Manajemen Scoring');
            //$actionBtn .= button_general('header', $row->uuid, 'Edit Header Laporan Keuangan');
            $actionBtn .= button_general('laporan-keuangan-bulanan', $row->uuid, 'Input Laporan Bulanan');
            $actionBtn .= button_general('cari-laporan-keuangan-bulanan', $row->uuid, 'Edit Laporan Bulanan');
            $actionBtn .= button_general('fiducia', $row->uuid, 'Daftar Fiducia');
            $actionBtn .= button_general('detail-laporan-posisi-keuangan', $row->uuid, 'Laporan Keuangan');
            $actionBtn .='</ul></div>';

            if($jabatan_user != 'Account Officer'):
                $actionBtn = '';
            endif;

            return $actionBtn;
        });
        return $data;
    }
}
