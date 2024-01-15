<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use DataTables;
use App\Models\LoanApplicant;
use App\Models\InformasiPokokBprPelapor;
use App\Models\DataKepemilikanBpr;
use App\Models\DataAnggotaDireksiKomisarisBpr;
use App\Models\DataOrganPelaksanaBpr;
use App\Models\DaftarRincianKantorBpr;
use App\Models\DataPihakTerkaitBpr;
use App\Models\DaftarPinjamanYangDiterima;
use App\Models\HeaderImport;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest;
use App\Models\Log;
use App\Models\DocumentBpr;

class PinjamanDiterimaController extends Controller
{
    public function index(Request $request, $id)
    {
        $sandi_bpr = InformasiPokokBprPelapor::where('uuid', $id)->value('uuid');

        if($request->ajax()):

            $data = DaftarPinjamanYangDiterima::where('sandi_bpr', $sandi_bpr);

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('plafon', function($row){
                return (is_numeric($row->plafon)) ? 'Rp. '. number_format((float)$row->plafon) : 'Rp. 0';
            })
            ->addColumn('baki_debet', function($row){
                return (is_numeric($row->baki_debet)) ? 'Rp. '. number_format((float)$row->baki_debet) : 'Rp. 0';
            })
            ->addColumn('suku_bunga', function($row){
                return $row->suku_bunga_persentase.' %';
            })
            ->addColumn('periode', function($row){

                $periode_awal = ($row->tanggal_mulai == null) ? '' : date('d-m-Y', strtotime($row->tanggal_mulai));
                $periode_akhir = ($row->tanggal_jatuh_tempo == null) ? '' : date('d-m-Y', strtotime($row->tanggal_jatuh_tempo));

                $periode = $periode_awal.' s/d '.$periode_akhir;

                return $periode;
            })
            ->addColumn('action', function($row){

                if(Auth::user()->jabatan_user->kode == 'account_officer'):
                    $action = route_general(route('slik.edit', [$row->id]), 'Edit', 'secondary');
                    $action .= button_delete(route('slik.destroy', [$row->id]));
                else:
                    $action = '';
                endif;

                return $action;
            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        return view('informasi-detail-bpr/detail-form0007', compact('id', 'sandi_bpr'));
    }

    public function store(Request $request)
    {
        $req = $request->except('_token', 'aksi', 'bagian', 'tabel');
        
        $data = DaftarPinjamanYangDiterima::create($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->id);

        return back()->with('success', 'Berhasil simpan');
    }

    public function edit($id)
    {
        $data = DaftarPinjamanYangDiterima::where('id', $id)->firstOrFail();
    
        return view('informasi-detail-bpr/edit-pinjaman-diterima', compact('data'));
    }

    public function update(Request $request)
    {
        $req = $request->except('_token', 'aksi', 'bagian', 'tabel');
        
        $update = DaftarPinjamanYangDiterima::where('id', $request->id)->first();
        $update->update($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id);

        return redirect('slik/'.$update->sandi_bpr)->with('success', 'Berhasil update');
    }

    public function destroy ($id)
    {
        $data = DaftarPinjamanYangDiterima::where('id', $id)->first();

        $log = new Log;
        $log->storeLog($id, $data->nama_lembaga_keuangan, 'SLIK', 'Delete');

        $data->delete();

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
