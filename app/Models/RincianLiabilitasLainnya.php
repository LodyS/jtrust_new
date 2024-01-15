<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianLiabilitasLainnya extends Model
{
    protected $table = 'form_14';
    protected $fillable = ['flag_detail', 'sandi_kantor', 'sandi_pos', 'jumlah', 'header_id'];

    public function storeRincianLiabilitasLainnya ($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Kosong';
        $this->sandi_kantor = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Kosong';
        $this->sandi_pos = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Kosong';
        $this->jumlah = $explodeLine[$explodeLine[0]];

        $this->header_id = $explodeLine['header_id'];
        $save =$this->save();

        return $save;
    }
}
