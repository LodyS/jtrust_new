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
use Illuminate\Http\Request;
use App\Http\Requests\DireksiBprRequest;
use App\Models\Log;
use App\Traits\UploadFile;

class DireksiBprController extends Controller
{
    use UploadFile;

    public function index(Request $request, $id)
    {
        $aksi = 'Create';
        $bpr = InformasiPokokBprPelapor::where('uuid', $id)->firstOrFail();
  
        $sandi_bpr = $bpr->sandi_bpr;

        if($request->ajax()):

            $data = DB::table('form_002')->where('sandi_bpr',$id);

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('foto', function($row){

                return lihat_foto('manajemen_perusahaan/'.$row->foto);
            })

            ->addColumn('keterangan', function($row){

                $keterangan = ' <b>Pendidikan</b>
                <div style="height:10px"></div>
                <textarea class="form-control" readonly rows="8" style="background-color:white;  border-left: none;
                border-right: none; border-bottom:none; border-top:none;">'.strip_tags($row->pendidikan).'</textarea>
                <div style="height:10px"></div>

                <b>Pengalaman Kerja</b>
                <div style="height:10px"></div>
                <textarea class="form-control" readonly rows="8" style="background-color:white;  border-left: none;
                border-right: none; border-bottom:none; border-top:none;">'.strip_tags($row->pengalaman_kerja).'</textarea>';

                return $keterangan;
            })
            ->addColumn('action', function($row){

                if(Auth::user()->jabatan_user->kode == 'account_officer'):
                    $action = route_general(route('anggota-direksi-komisaris.edit', [$row->id]), 'Edit', 'secondary');
                    $action .= button_delete(route('anggota-direksi-komisaris.destroy', [$row->id]));
                else:
                    $action = '';
                endif;

                return $action;
            })
            ->rawColumns(['action'])
            ->escapeColumns([]) // untuk render tag HTML
            ->make(true);

        endif;

        $dataa = null;

        return view('informasi-detail-bpr/detail-form0002', compact('id', 'sandi_bpr', 'bpr', 'aksi'));
    }

    public function store(DireksiBprRequest $request)
    {
        if($request->hasFile('foto')):
            $fotoo = $this->upload($request->file('foto'), '', 'manajemen_perusahaan', 'Tambah');
        else:
            $fotoo = $request->foto;
        endif;

        $req = $request->validated();
        $req['foto'] = $fotoo;
        $req['status_foto'] = 'Y';
        $data = DataAnggotaDireksiKomisarisBpr::create($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->id);

        return back()->with('success', 'Berhasil tambah direksi dan komisaris');
    }

    public function edit($id)
    {
        $aksi = 'Update';
        $dataa = DataAnggotaDireksiKomisarisBpr::where('id', $id)->firstOrFail();
        $bpr = InformasiPokokBprPelapor::where('uuid', $dataa->sandi_bpr)->firstOrFail();
        $id_bpr = $bpr->uuid;
        $id = $dataa->sandi_bpr;
        
        return view('informasi-detail-bpr/detail-form0002', compact('id', 'dataa', 'aksi', 'id_bpr', 'bpr'));
    }

    public function update(DireksiBprRequest $request, $id)
    {
        $req = $request->validated();
        $data = DataAnggotaDireksiKomisarisBpr::where('id', $id)->first();

        if ($request->hasFile('foto')):
            $fotoo = $this->upload($request->file('foto'), $data->foto, 'manajemen_perusahaan', 'Edit');
        endif;

        $req['foto'] = $fotoo ?? $data->foto;
        
        if(isset($fotoo)):
            $req['status_foto'] = 'Y';
        endif;

        $data->update($req);
 
        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id);

        return redirect('anggota-direksi-komisaris/'.$request->id_bpr)->with('success', 'Berhasil update direksi dan komisaris');
    }

    public function destroy($id)
    {
        $data = DataAnggotaDireksiKomisarisBpr::where('id', $id)->first();
        $hapus_foto = $this->upload($data->foto, '', 'manajemen_perusahaan', 'Hapus');
        
        $data->delete();

        $log = new Log;
        $log->storeLog($id, $data->nama, 'Manajemen Perusahaan', 'Delete');

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
