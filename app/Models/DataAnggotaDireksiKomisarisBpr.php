<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAnggotaDireksiKomisarisBpr extends Model
{
    protected $table = 'form_002';
    protected $primaryKey = 'id';
    protected $fillable = [
        'flag_detail',
        'nama',
        'alamat',
        'nik',
        'jabatan',
        'tanggal_mulai_menjabat',
        'tanggal_selesai_menjabat',
        'no_sk',
        'tanggal_sk',
        'sertifikat_kompetensi_kerja_berlaku',
        'tanggal_berakhir_masa_berlaku_sertifikat_kompetensi_kerja',
        'pendidikan_terakhir',
        'tanggal_kelulusan',
        'nama_lembaga',
        'jenis_pelatihan_terakhir',
        'tanggal_pelatihan',
        'lembaga_penyelenggara',
        'komite_audit',
        'komite_pemantauan',
        'komite_remunerasi_dan_nominasi',
        'membawahkan_fungsi_kepatuhan',
        'komisaris_independen',
        'header_id',
        'sandi_bpr',
        'ttl',
        'pendidikan',
        'pengalaman_kerja',
        'foto',
        'status_foto'
    ];

    public function storeDataAnggotaDireksiKomisarisBpr($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Data Kosong';
        $this->nama = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Data Kosong';
        $this->alamat =$explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Data Kosong';
        $this->nik = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[4]) ? $explodeLine[4] : 'Data Kosong';
        $this->jabatan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[5]) ? $explodeLine[6] : 'Data Kosong';
        $this->tanggal_mulai_menjabat =$explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[6]) ? $explodeLine[6] : 'Data Kosong';
        $this->tanggal_selesai_menjabat = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[7]) ? $explodeLine[7] : 'Data Kosong';
        $this->no_sk = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[8]) ? $explodeLine[8] : 'Data Kosong';
        $this->tanggal_sk  = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[9]) ? $explodeLine[9] : 'Data Kosong';
        $this->sertifikat_kompetensi_kerja_berlaku = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[10]) ? $explodeLine[10] : 'Data Kosong';
        $this->tanggal_berakhir_masa_berlaku_sertifikat_kompetensi_kerja = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[11]) ? $explodeLine[11] : 'Data Kosong';
        $this->pendidikan_terakhir = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[12]) ? $explodeLine[12] : 'Data Kosong';
        $this->tanggal_kelulusan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[13]) ? $explodeLine[13] : 'Data Kosong';
        $this->nama_lembaga  = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[14]) ? $explodeLine[14] : 'Data Kosong';
        $this->jenis_pelatihan_terakhir  = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[15]) ? $explodeLine[15] : 'Data Kosong';
        $this->tanggal_pelatihan  = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[16]) ? $explodeLine[16] : 'Data Kosong';
        $this->lembaga_penyelenggara = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[17]) ? $explodeLine[17] : 'Data Kosong';
        $this->komite_audit  = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[18]) ? $explodeLine[18] : 'Data Kosong';
        $this->komite_pemantauan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[19]) ? $explodeLine[19] : 'Data Kosong';
        $this->komite_remunerasi_dan_nominasi = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[20]) ? $explodeLine[20] : 'Data Kosong';
        $this->membawahkan_fungsi_kepatuhan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[21]) ? $explodeLine[21] : 'Data Kosong';
        $this->komisaris_independen  = $explodeLine[$explodeLine[0]];
        $this->header_id = $explodeLine['header_id'];
        $this->sandi_bpr = $explodeLine['sandi_bpr'];
        $save = $this->save();

        return $save;
    }

    public static function getHtml($value)
    {
        return htmlspecialchars($value);
    }
}
