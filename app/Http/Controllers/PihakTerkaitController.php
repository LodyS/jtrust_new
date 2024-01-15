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
use App\Http\Requests\PihakTerkaitBprRequest;
use App\Models\Log;
use App\Models\DocumentBpr;

class PihakTerkaitController extends Controller
{
    public function index(Request $request, $id)
    {
        $sandi_bpr = InformasiPokokBprPelapor::where('uuid', $id)->value('uuid');

        if($request->ajax()):
            $data = DataPihakTerkaitBpr::where('sandi_bpr', $sandi_bpr);

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $action = route_general(route('pihak-terkait-bpr.edit', [$row->id]), 'Edit', 'secondary');
                $action .= button_delete(route('pihak-terkait-bpr.destroy', [$row->id]));

                return $action;
            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        return view('informasi-detail-bpr/detail-form0005', compact('id', 'sandi_bpr'));
    }

    public function store(PihakTerkaitBprRequest $request)
    {
        $data = DataPihakTerkaitBpr::create($request->validated());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->id);

        return back()->with('success', 'Berhasil tambah pihak terkait BPR');
    }

    public function edit($id)
    {
        $data = DataPihakTerkaitBpr::where('id', $id)->firstOrFail();
        $sandi_bpr = InformasiPokokBprPelapor::where('uuid', $data->sandi_bpr)->value('uuid');
      
        return view('informasi-detail-bpr/edit-pihak-terkait-bpr', compact('data', 'id', 'sandi_bpr'));
    }

    public function update(PihakTerkaitBprRequest $request, $id)
    {
        $data = DataPihakTerkaitBpr::where('id', $id)->first();
      
        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->nama_pihak_terkait);

        $data->update($request->except('_token', 'aksi', 'tabel', 'bagian')); 

        return redirect('pihak-terkait-bpr/'.$data->sandi_bpr)->with('success', 'Berhasil update pihak terkait bpr');
    }

    public function destroy($id)
    {
        $data = DataPihakTerkaitBpr::where('id', $id)->first();

        $log = new Log;
        $log->storeLog($id, $data->nama_pihak_terkait, 'Pihak Terkait BPR', 'Delete');

        $data->delete();

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
