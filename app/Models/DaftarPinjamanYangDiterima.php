<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPinjamanYangDiterima extends Model
{
    protected $table = 'form_007';
    protected $fillable = [
        'flag_detail',
        'nomor_cif',
        'gol_kreditur',
        'sandi_bank',
        'lokasi_kreditur',
        'jenis',
        'hubungan_dengan_bank',
        'tanggal_mulai',
        'tanggal_jatuh_tempo',
        'suku_bunga_persentase',
        'cara_perhitungan',
        'plafon',
        'jenis_agunan_yang_dijaminkan',
        'nominal_agunan_yang_dijaminkan',
        'baki_debet',
        'biaya_transaksi_belum_diamortisasi',
        'diskonto_belum_diamortisasi',
        'baki_debet_neto',
        'header_id',
        'sandi_bpr',
        'nama_lembaga_keuangan',
        'jangka_waktu',
        'kol',
        'tanggal_permintaan'
    ];

    public function storeDaftarPinjamanYangDiterima ($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : '';
        $this->nomor_cif = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : '';
        $this->gol_kreditur =$explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : '';
        $this->sandi_bank = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[4]) ? $explodeLine[4] : '';
        $this->lokasi_kreditur = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[5]) ? $explodeLine[5] : '';
        $this->jenis = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[6]) ? $explodeLine[6] : '';
        $this->hubungan_dengan_bank = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[7]) ? $explodeLine[7] : '';
        $this->tanggal_mulai = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[8]) ? $explodeLine[8] : '';
        $this->tanggal_jatuh_tempo = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[9]) ? $explodeLine[9] : '';
        $this->suku_bunga_persentase = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[10]) ? $explodeLine[10] : '';
        $this->cara_perhitungan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[11]) ? $explodeLine[11] : '';
        $this->plafon = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[12]) ? $explodeLine[12] : '';
        $this->jenis_agunan_yang_dijaminkan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[13]) ? $explodeLine[13] : '';
        $this->nominal_agunan_yang_dijaminkan = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[14]) ? $explodeLine[14] : '';
        $this->baki_debet = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[15]) ? $explodeLine[15] : '';
        $this->biaya_transaksi_belum_diamortisasi = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[16]) ? $explodeLine[16] : '';
        $this->diskonto_belum_diamortisasi = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[16]) ? $explodeLine[16] : '';
        $this->baki_debet_neto = $explodeLine[$explodeLine[0]];

        $this->header_id = $explodeLine['header_id'];
        $this->sandi_bpr = $explodeLine['sandi_bpr'];
        $save = $this->save();

        return $save;
    }

    public function setPlafonAttribute($value)
    {
        return $this->attributes['plafon'] = preg_replace( '/[^0-9]/', '', $value);
    }

    public function setNominalAgunanYangDijaminkanAttribute($value)
    {
        return $this->attributes['nominal_agunan_yang_dijaminkan'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setBakiDebetAttribute($value)
    {
        return $this->attributes['baki_debet'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setBiayaTransaksiBelumDiamortisasiAttribute($value)
    {
        return $this->attributes['biaya_transaksi_belum_diamortisasi'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setDiskontoBelumDiamortisasiAttribute($value)
    {
        return $this->attributes['diskonto_belum_diamortisasi'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setBakiDebetNetoAttribute($value)
    {
        return $this->attributes['baki_debet_neto'] = preg_replace('/[^0-9]/', '', $value);
    }
}
