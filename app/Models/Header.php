<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $table = 'header';
    protected $primaryKey = 'id';
    protected $fillable = [
        'flag_header',
        'kode_sektor',
        'sandi_bpr',
        'periode_data',
        'kode_jenis_laporan',
        'kode_form_laporan',
        'kode_status_koreksi',
        'nomor_surat'
    ];

    public function scopeCheckPeriodeData($query, $periode_data_header)
    {
        return $query->where('periode_data', $periode_data_header);
    }

    public function scopeCheckKodeFormLaporan($query, $kode_form_laporan_header)
    {
        return $query->where('kode_form_laporan', $kode_form_laporan_header);
    }

    public function storeHeader($explode)
    {
        $this->flag_header = $explode[0];
        $this->kode_sektor = $explode[1];
        $this->sandi_bpr = $explode[2];
        $this->periode_data = $explode[3];
        $this->kode_jenis_laporan = $explode[4];
        $this->kode_form_laporan = $explode[5];
        $this->kode_status_koreksi = $explode[6];
        $this->nomor_surat = $explode[7];
        $save = $this->save();

        return $save;
    }

    public function informasi_bpr ()
    {
        return $this->belongsTo('App\Models\InformasiPokokBprPelapor');
    }
}
