<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataOrganPelaksanaBpr extends Model
{
    protected $table = 'form_003';
    protected $fillable = [
        'nama_organ_pelaksana',
        'alamat',
        'nik',
        'kepatuhan',
        'manajemen_resiko',
        'audit_intern',
        'apu_dan_ppt',
        'lainnya',
        'tanggal_mulai_menjabat',
        'no_surat_pengangkatan',
        'tanggal_surat_pengangkatan',
        'no_surat_penegasan',
        'tanggal_no_surat_penegasan',
        'komite_audit',
        'komite_pemantauan_resiko',
        'komite_remunerasi_dan_nominasi',
        'header_id',
        'sandi_bpr'
    ];

    public function storeDataOrganPelaksanaBpr($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Data Kosong';
        $this->nama_organ_pelaksana = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Data Kosong';
        $this->alamat = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Data Kosong';
        $this->nik = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[4]) ? $explodeLine[4] : 'Data Kosong';
        $this->kepatuhan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[5]) ? $explodeLine[5] : 'Data Kosong';
        $this->manajemen_resiko = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[7]) ? $explodeLine[6] : 'Data Kosong';
        $this->audit_intern = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[8]) ? $explodeLine[8] : 'Data Kosong';
        $this->apu_dan_ppt= $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[9]) ? $explodeLine[9] : 'Data Kosong';
        $this->lainnya = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[10]) ? $explodeLine[10] : 'Data Kosong';
        $this->tanggal_mulai_menjabat = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[11]) ? $explodeLine[11] : 'Data Kosong';
        $this->no_surat_pengangkatan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[12]) ? $explodeLine[12] : 'Data Kosong';
        $this->tanggal_surat_pengangkatan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[13]) ? $explodeLine[13] : 'Data Kosong';
        $this->no_surat_penegasan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[14]) ? $explodeLine[14] : 'Data Kosong';
        $this->tanggal_no_surat_penegasan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[15]) ? $explodeLine[15] : 'Data Kosong';
        $this->komite_audit = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[16]) ? $explodeLine[16] : 'Data Kosong';
        $this->komite_pemantauan_resiko = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[17]) ? $explodeLine[17] : 'Data Kosong';
        $this->komite_remunerasi_dan_nominasi= $explodeLine[$explodeLine[0]];
        $this->header_id = $explodeLine['header_id'];
        $this->sandi_bpr = $explodeLine['sandi_bpr'];
        $save = $this->save();

        return $save;
    }
}
