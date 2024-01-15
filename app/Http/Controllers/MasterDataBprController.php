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
use Illuminate\Support\Str;
use App\Traits\UploadFile;

class MasterDataBprController extends Controller
{
    use UploadFile;

    public function index (Request $request)
    {
        if($request->ajax()):
            $id_user = Auth::user()->id;
            $jabatan_user = Auth::user()->jabatan_user->nama_jabatan;

            // agar Bussinness Division head bisa lihat
            $param['id_user'] = $id_user;
            $param['jabatan_user'] = $jabatan_user;
            $data = InformasiPokokBprPelapor::master($param);
            $paramater['data'] = $data;

            return InformasiPokokBprPelapor::addColumn($paramater)
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['action', 'report'])
            ->make(true);

        endif;

        return view ('master-data-bpr/index');
    }

    public function create()
    {
        $informasi_grup_usaha = DB::table('informasi_grup_usaha')->get();

        return view('master-data-bpr/form', compact('informasi_grup_usaha'));
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'nama_bpr'=>'required|string',
            'alamat_bpr'=>'required|string',
            'kabupaten_kota_bpr'=>'required|string',
            'no_telepon'=>'required',
            'npwp'=>'required'
        ]);

        $cek = InformasiPokokBprPelapor::where('sandi_bpr', $request->sandi_bpr)
        ->leftJoin('users', 'users.id', 'form_00.user_id')
        ->select('form_00.id', 'users.name')
        ->first();

        if (isset($cek)):

            return back()->withError($request->nama_bpr. ' is handled by : '. $cek->name);

        else:

            $validate = $request->all();
            $validate['flag_detail'] = "D01";
            $validate['user_id'] = Auth::user()->id;
            $validate['uuid'] = Str::uuid();
            $data = InformasiPokokBprPelapor::create($validate);

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $data->id);

            return redirect('list-data-bpr')->with('success', 'Data Success Saved');

        endif;
    }

    public function edit ($id)
    {
        if(Auth::user()->jabatan_user->nama_jabatan != 'Account Officer'):
            abort(403);
        endif;

        $informasi_grup_usaha = DB::table('informasi_grup_usaha')->get();
        $data = InformasiPokokBprPelapor::where('uuid', $id)->firstOrFail();

        return view('informasi-detail-bpr/detail-form0000', compact('data', 'id', 'informasi_grup_usaha'));
    }

    public function update (Request $request)
    {
        $req = $request->except('_token', 'tabel', 'aksi', 'bagian', 'npwp_file_old');

        if($request->hasFile('npwp_file')):
           $file_baru = $this->upload($request->file('npwp_file'), $request->npwp_file_old, 'npwp', 'Edit');
        endif;

        $req['npwp_file'] = ($request->hasFile('npwp_file')) ? $request->file('npwp_file')->getClientOriginalName() : $request->npwp_file_old;
      
        InformasiPokokBprPelapor::where('uuid', $request->uuid)->update($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id);

        return back()->with('success', 'Update Data Successfly.');
    }

    public function destroy (Request $request)
    {
        $data = InformasiPokokBprPelapor::find($request->id)->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi', 'bagian'), $request->id);

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
