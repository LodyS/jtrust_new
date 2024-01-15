<?php

namespace App\Models;
Use Auth;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'tabel', 'aksi', 'keterangan', 'user_id', 'bagian'
    ];

    public function storeLog ($req=false, $id=false, $tabel=false, $aksi=false)
    {
        if(!empty($req)):
            $req = array();
        else:
            $req;
        endif;

        $req['keterangan'] = $id;
        $req['user_id'] = Auth::user()->id;
        
        if(empty($req['tabel'])):
            $req['tabel'] = $tabel;
        endif;

        if(empty($req['aksi'])):
            $req['aksi'] = $aksi;
        endif;

        $save = $this->create($req);

        return $save;
    }
}
