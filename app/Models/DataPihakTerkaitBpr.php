<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPihakTerkaitBpr extends Model
{
    protected $table = 'form_005';
    protected $fillable = [
        'nama_pihak_terkait',
        'no_identitas',
        'alamat_pihak_terkait',
        'jenis_pihak_terkait',
        'hubungan_pihak_terkait',
        'header_id',
        'sandi_bpr'
    ];

    public function storeDataPihakTerkait($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Data Kosong';
        $this->nama_pihak_terkait = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Data Kosong';
        $this->no_identitas  = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Data Kosong';
        $this->alamat_pihak_terkait = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[4]) ? $explodeLine[4] : 'Data Kosong';
        $this->jenis_pihak_terkait = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[5]) ? $explodeLine[5] : 'Data Kosong';
        $this->hubungan_pihak_terkait = $explodeLine[$explodeLine[0]];
        $this->header_id = $explodeLine['header_id'];
        $this->sandi_bpr = $explodeLine['sandi_bpr'];
        $save = $this->save();

        return $save;
    }
}
