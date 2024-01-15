<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Requests\TxtRequest;

class SlikTxtController extends Controller
{
    public function create($id)
    {
        return view('informasi-detail-bpr/slik-txt', compact('id'));
    }

    public function store(TxtRequest $request)
    {
        $slik = file_get_contents($request->file('file'));
        $slik = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $slik), true);
        
        $tanggal_permintaan = $slik['header']['tanggalPermintaan'];
        $data_slik = $slik['perusahaan']['fasilitas']['kreditPembiayan'];

        for($i=0; $i<count($data_slik); $i++):

            $mulai = $data_slik[$i]['tanggalMulai'];
            $jatuh_tempo = $data_slik[$i]['tanggalJatuhTempo'];
            $jangka_waktu = diffMonth($mulai, $jatuh_tempo);
            
            DB::table('form_007')->insert([
                'sandi_bpr'=>$request->id,
                'tanggal_permintaan'=>$tanggal_permintaan,
                'nama_lembaga_keuangan'=>$data_slik[$i]['ljkKet'],
                'plafon'=>$data_slik[$i]['plafon'],
                'jenis'=>$data_slik[$i]['jenisKreditPembiayaanKet'],
                'baki_debet'=>$data_slik[$i]['bakiDebet'],
                'tanggal_mulai'=>date('Y-m-d', strtotime($data_slik[$i]['tanggalMulai'])),
                'tanggal_jatuh_tempo'=>date('Y-m-d', strtotime($data_slik[$i]['tanggalJatuhTempo'])),
                'suku_bunga_persentase'=>$data_slik[$i]['sukuBungaImbalan'],
                'jangka_waktu'=>$jangka_waktu,
                'kol'=>$data_slik[$i]['kualitas'],
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ]); 

        endfor; 

        $req['tabel'] = 'Import slik json';
        $req['aksi'] = 'create';

        $log = new Log;
        $log->storeLog($req, $request->id);
     
        return back()->with('success', 'Berhasil upload slik');
    }
}
