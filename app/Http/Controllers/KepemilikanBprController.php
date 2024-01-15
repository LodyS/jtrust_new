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
use App\Http\Requests\KepemilikanBprRequest;
use App\Models\Log;
use App\Models\DocumentBpr;

class KepemilikanBprController extends Controller
{
    public function index(Request $request, $id)
    {
        $sandi_bpr = InformasiPokokBprPelapor::where('uuid', $id)->value('sandi_bpr');

        if($request->ajax()):
            $data = DataKepemilikanBpr::where('sandi_bpr', $id);

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('jumlah_nominal', function($row){
                $plafond = 'Rp. '. number_format((float)$row->jumlah_nominal);

                return $plafond;
            })
            ->addColumn('action', function($row){

                if(Auth::user()->jabatan_user->kode == 'account_officer'):
                    $action = route_general(route('kepemilikan-bpr.edit', [$row->id]), 'Edit', 'secondary');
                    $action .= button_delete(route('kepemilikan-bpr.destroy', [$row->id]));
                else: 
                    $action = '';
                endif;

                return $action;

            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;
        return view('informasi-detail-bpr/detail-form0001',compact('id', 'sandi_bpr'));
    }

    public function edit($id)
    {
        $data = DataKepemilikanBpr::where('id', $id)->firstOrfail();
        return view('informasi-detail-bpr/edit-detail-form-001', compact('data'));
    }

    public function store(KepemilikanBprRequest $request)
    {
        DataKepemilikanBpr::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id);

        return back()->with('success', 'Berhasil menambahkan data kepemilikan BPR');
    }

    public function update(KepemilikanBprRequest $request, $id)
    {
        $data = DataKepemilikanBpr::where('id', $id)->first();
        $data->update($request->except('tabel', 'aksi', 'bagian'));

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $id);

        return redirect('kepemilikan-bpr/'.$data->sandi_bpr)->with('success', 'Berhasil update');
    }

    public function destroy($id)
    {
        $data = DataKepemilikanBpr::where('id', $id)->first();

        $log = new Log;
        $log->storeLog($id, $data->nama, 'Kepemilikan BPR', 'Delete');

        $data->delete();

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
