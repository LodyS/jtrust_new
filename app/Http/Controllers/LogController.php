<?php

namespace App\Http\Controllers;
use DataTables;
use DB;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()):
            $data = DB::table('logs')->selectRaw("logs.id, logs.tabel, logs.aksi, logs.keterangan, logs.created_at,
                case
                    when bagian is null then 'Master Data'
                    when bagian = 'Nak' then 'NAK'
                    else
                        bagian
                    end as bagian,

            users.name")
            ->leftJoin('users', 'users.id', 'logs.user_id');

            return Datatables::of($data)
            ->addColumn('keterangan', function($rows){
                $keterangan = $rows->name.' '.$rows->aksi.' pada data di '.' '.$rows->tabel;

                return $keterangan;
            })

            ->addIndexColumn()
            ->make(true);

        endif;

        return view('log/index');
    }
}
