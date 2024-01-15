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
use App\Http\Requests\OrganPelaksanaBprRequest;
use App\Models\Log;
use App\Models\DocumentBpr;
use App\Traits\UploadFile;

class OrganBprController extends Controller
{
    use UploadFile;

    public function index(Request $request, $id)
    {
        $aksi = 'create';
        
        if($request->ajax()):

            $data = DataOrganPelaksanaBpr::where('sandi_bpr', $id);

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $action = route_general(route('organ-pelaksana-bpr.edit', [$row->id]), 'Edit', 'secondary');
                $action .= button_delete(route('organ-pelaksana-bpr.destroy', [$row->id]));

                return $action;
            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        return view('informasi-detail-bpr/detail-form0003', compact('id',  'aksi'));
    }

    public function store(OrganPelaksanaBprRequest $request)
    {
        $data = DataOrganPelaksanaBpr::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->id);

        return back()->with('success', 'Berhasil tambah organ pelaksana bpr');
    }

    public function edit($id)
    {
        $data = DataOrganPelaksanaBpr::where('id', $id)->firstOrFail();

        return view('informasi-detail-bpr/edit-organ-pelaksana', compact('data', 'id'));
    }

    public function update(OrganPelaksanaBprRequest $request, $id)
    {
        $data = DataOrganPelaksanaBpr::where('id', $id)->firstOrFail();
        $data->update($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->nama_organ_pelaksana);

        return redirect('organ-pelaksana-bpr/'.$data->sandi_bpr)->with('success', 'Berhasil update Organ Pelaksana');
    }

    public function destroy($id)
    {
        $data = DataOrganPelaksanaBpr::where('id', $id)->first();

        $log = new Log;
        $log->storeLog($id, $id, 'Organ Pelaksana BPR', 'Delete');

        $data->delete();

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
