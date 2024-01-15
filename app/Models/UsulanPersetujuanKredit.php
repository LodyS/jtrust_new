<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanPersetujuanKredit extends Model
{
    protected $table = 'usulan_persetujuan_kredit';
    protected $fillable = [
        'jenis_fasilitas_kredit',
        'limit_fasilitas_kredit',
        'sifat_fasilitas_kredit',
        'tujuan_penggunaan',
        'jangka_waktu_fasilitas_kredit',
        'jangka_waktu_penarikan_fasilitas_kredit',
        'jangka_waktu_angsuran',
        'suku_bunga',
        'provisi',
        'biaya_administrasi',
        'grace_period',
        'lain_lain',
        'total_fasilitas_kredit',
        'loan_applicant_id',
    ];

    public function setLimitFasilitasKreditAttribute($value)
    {
        return $this->attributes['limit_fasilitas_kredit'] = preg_replace( '/[^0-9]/', '', $value);
    }

    public function setBiayaAdministrasiAttribute($value)
    {
        return $this->attributes['biaya_administrasi'] = preg_replace( '/[^0-9]/', '', $value);
    }

    public function setTotalFasilitasKreditAttribute($value)
    {
        return $this->attributes['total_fasilitas_kredit'] = preg_replace( '/[^0-9]/', '', $value);
    }
}
