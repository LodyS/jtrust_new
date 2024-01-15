<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianLiabilitasSegera extends Model
{
    protected $table = 'form_10';

    public function storeRincianLiabilitasSegera($explodeLine)
    {
        $this->flag_detail = $explodeLine[0];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[1]) ? $explodeLine[1] : 'Data Kosong';
        $this->sandi_kantor = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[2]) ? $explodeLine[2] : 'Data Kosong';
        $this->sandi_pos = $explodeLine[$explodeLine[0]];

        $explodeLine[$explodeLine[0]] = isset($explodeLine[3]) ? $explodeLine[3] : 'Data Kosong';
        $this->jumlah = $explodeLine[$explodeLine[0]];

        $this->header_id = $explodeLine['header_id'];
        $save = $this->save();

        return $save;
    }
}
