<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class LaporanLabaRugi extends Model
{
    protected $table = 'form_02';

    public function storeLaporanLabaRugi($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Kosong';
        $this->sandi_kantor = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Kosong';
        $this->sandi_pos = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Kosong';
        $this->jumlah = $explodeLine[$explodeLine[0]];

        $this->header_id = $explodeLine['header_id'];
        $save = $this->save();

        return $save;
    }

    public static function report_bulanan($sandi_bpr, $tahun, $bulan)
    {
        $data = DB::table('laporan_laba_rugi_table')
        ->selectRaw('posisi_tanggal_laporan as nominal')
        ->where(['bulan'=>$bulan, 'tahun'=>$tahun, 'sandi_bpr'=>$sandi_bpr])
        ->get();

        return $data;
    }
}
