<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarRincianKantorBpr extends Model
{
    protected $table = 'form_004';
    protected $fillable = [
        'flag_detail',
        'sandi_kantor',
        'nama_kantor',
        'koordinat_kantor',
        'nama_jalan_dan_no',
        'desa_kecamatan',
        'kab_kota',
        'kode_pos',
        'nama_pimpinan',
        'no_telp',
        'jumlah_karyawan_tetap_s3',
        'jumlah_karyawan_tetap_s2',
        'jumlah_karyawan_tetap_s1',
        'jumlah_karyawan_tetap_d3',
        'jumlah_karyawan_tetap_slta',
        'jumlah_karyawan_tetap_lainnya',
        'jumlah_karyawan_tidak_tetap_s3',
        'jumlah_karyawan_tidak_tetap_s2',
        'jumlah_karyawan_tidak_tetap_s1',
        'jumlah_karyawan_tidak_tetap_d3',
        'jumlah_karyawan_tidak_tetap_slta',
        'jumlah_karyawan_tidak_tetap_lainnya',
        'jumlah_kantor_kas',
        'status_kepemilikan_gedung',
        'jumlah_kas_mobil_dan_kas_terapung',
        'edc_milik_sendiri',
        'edc_milik_bu',
        'edc_milik_bpr_lain',
        'jumlah_atm_diselenggarakan_sendiri',
        'jumlah_atm_bekerja_sama_dengan_pihak_lain',
        'header_id',
        'sandi_bpr'
    ];

    public function storeDaftarRincianKantorBpr($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Data Kosong';
        $this->sandi_kantor = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Data Kosong';
        $this->nama_kantor = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Data Kosong';
        $this->koordinat_kantor = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[4]) ? $explodeLine[4] : 'Data Kosong';
        $this->nama_jalan_dan_no = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[5]) ? $explodeLine[5] : 'Data Kosong';
        $this->desa_kecamatan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[6]) ? $explodeLine[6] : 'Data Kosong';
        $this->kab_kota = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[7]) ? $explodeLine[7] : 'Data Kosong';
        $this->kode_pos = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[8]) ? $explodeLine[8] : 'Data Kosong';
        $this->nama_pimpinan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[9]) ? $explodeLine[9] : 'Data Kosong';
        $this->no_telp = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[10]) ? $explodeLine[10] : 'Data Kosong';
        $this->jumlah_karyawan_tetap_s3 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[11]) ? $explodeLine[11] : 'Data Kosong';
        $this->jumlah_karyawan_tetap_s2 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[12]) ? $explodeLine[12] : 'Data Kosong';
        $this->jumlah_karyawan_tetap_s1 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[13]) ? $explodeLine[13] : 'Data Kosong';
        $this->jumlah_karyawan_tetap_d3 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[14]) ? $explodeLine[14] : 'Data Kosong';
        $this->jumlah_karyawan_tetap_slta = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[15]) ? $explodeLine[15] : 'Data Kosong';
        $this->jumlah_karyawan_tetap_lainnya = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[16]) ? $explodeLine[16] : 'Data Kosong';
        $this->jumlah_karyawan_tidak_tetap_s3 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[17]) ? $explodeLine[17] : 'Data Kosong';
        $this->jumlah_karyawan_tidak_tetap_s2 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[18]) ? $explodeLine[18] : 'Data Kosong';
        $this->jumlah_karyawan_tidak_tetap_s1 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[19]) ? $explodeLine[19] : 'Data Kosong';
        $this->jumlah_karyawan_tidak_tetap_d3 = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[20]) ? $explodeLine[20] : 'Data Kosong';
        $this->jumlah_karyawan_tidak_tetap_slta = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[21]) ? $explodeLine[21] : 'Data Kosong';
        $this->jumlah_karyawan_tidak_tetap_lainnya =  $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[22]) ? $explodeLine[22] : 'Data Kosong';
        $this->jumlah_kantor_kas = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[23]) ? $explodeLine[23] : 'Data Kosong';
        $this->status_kepemilikan_gedung = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[24]) ? $explodeLine[24] : 'Data Kosong';
        $this->jumlah_kas_mobil_dan_kas_terapung = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[25]) ? $explodeLine[25] : 'Data Kosong';
        $this->edc_milik_sendiri = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[26]) ? $explodeLine[26] : 'Data Kosong';
        $this->edc_milik_bu = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[27]) ? $explodeLine[27] : 'Data Kosong';
        $this->edc_milik_bpr_lain = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[28]) ? $explodeLine[28] : 'Data Kosong';
        $this->jumlah_atm_diselenggarakan_sendiri = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[29]) ? $explodeLine[29] : 'Data Kosong';
        $this->jumlah_atm_bekerja_sama_dengan_pihak_lain = $explodeLine[$explodeLine[0]];

        $this->header_id = $explodeLine['header_id'];
        $this->sandi_bpr = $explodeLine['sandi_bpr'];

        $save = $this->save();

        return $save;
    }
}
