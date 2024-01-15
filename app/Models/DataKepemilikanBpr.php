<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKepemilikanBpr extends Model
{
    protected $table = 'form_001';
    protected $fillable = [
        'flag_detail',
        'nama',
        'alamat',
        'jenis',
        'no_identitas',
        'psp',
        'jumlah_nominal',
        'persentase_kepemilikan',
        'header_id',
        'sandi_bpr',
        'keterangan',
        'jabatan'
    ];

    protected $primaryKey = 'id';

    public function storeDataKepemilikanBpr($explodeLine)
    {
        $explodeLine[$explodeLine[0]] = isset($explodeLine[0]) ? $explodeLine[0] : 'Data Kosong Laravel';
        $this->flag_detail = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Data Kosong Laravel';
        $this->nama = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Data Kosong Laravel';
        $this->alamat = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Data Kosong Laravel';
        $this->jenis = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[4]) ? $explodeLine[4] : 'Data Kosong Laravel';
        $this->no_identitas = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[5]) ? $explodeLine[5] : 'Data Kosong Laravel';
        $this->psp = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[6]) ? $explodeLine[6] : 'Data Kosong Laravel';
        $this->jumlah_nominal = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[7]) ? $explodeLine[7] : 'Data Kosong Laravel';
        $this->persentase_kepemilikan = $explodeLine[$explodeLine[0]];
        $this->header_id = $explodeLine['header_id'];
        $this->sandi_bpr = $explodeLine['sandi_bpr'];
        $save = $this->save();

        return $save;
    }

    public function setJumlahNominalAttribute($value)
    {
        return $this->attributes['jumlah_nominal'] = preg_replace('/[^0-9]/', '', $value);
    }
}
