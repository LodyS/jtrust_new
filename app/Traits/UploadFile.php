<?php
namespace App\Traits;
use Storage;
use Illuminate\Support\Facades\File;

trait UploadFile
{
    function upload($foto, $foto_lama, $folder, $aksi)
    {
        if($aksi !== 'Hapus'):
            $foto_raw = $foto;
            $foto_file = $foto_raw->getClientOriginalName();
            $foto_file = date('dmyHis').'_'.$foto_file;
            $foto_raw->move(public_path($folder), $foto_file);
        endif;

        if($aksi == 'Edit'):
            File::delete(public_path($folder).'/'.$foto_lama);
        endif;

        if($aksi == 'Hapus'):
            File::delete(public_path($folder).'/'.$foto);
        endif;

        if($aksi !== 'Hapus'):
            return $foto_file;
        endif;
    }
}
