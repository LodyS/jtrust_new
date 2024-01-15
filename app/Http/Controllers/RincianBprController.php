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
use App\Http\Requests\RincianKantorBprRequest;
use App\Models\Log;
use App\Models\DocumentBpr;

class RincianBprController extends Controller
{
    public function eindex(Request $request, $id)
    {
        if($request->ajax()):
            $data = DaftarRincianKantorBpr::where('sandi_bpr', $id);

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                
                $action = route_general(route('rincian-kantor-bpr.edit', [$row->id]), 'Edit', 'secondary');
                $action .= button_delete(route('rincian-kantor-bpr.destroy', [$row->id]));

                return $action;
            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        return view('informasi-detail-bpr/detail-form0004', compact('id'));
    }

    public function store(RincianKantorBprRequest $request)
    {
        $data = DaftarRincianKantorBpr::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->id);

        return back()->with('success', 'Berhasil tambah rincian kantor bpr');
    }

    public function edit($id)
    {
        $data = DaftarRincianKantorBpr::where('id', $id)->firstOrFail();
        $sandi_bpr = $data->sandi_bpr;

        return view('informasi-detail-bpr/edit-daftar-rincian-bpr', compact('data', 'id', 'sandi_bpr'));
    }

    public function update(RincianKantorBprRequest $request, $id)
    {
        $data = DaftarRincianKantorBpr::where('id', $request->id)->first();
        
        $data->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->nama_kantor);

        return redirect('rincian-kantor-bpr/'.$data->sandi_bpr)->with('success', 'Berhasil update');
    }

    public function destroy($id)
    {
        $data = DaftarRincianKantorBpr::where('id', $id)->first();

        $log = new Log;
        $log->storeLog($id, $data->nama_kantor, 'Rincian Kantor BPR', 'Delete');

        $data->delete();

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
