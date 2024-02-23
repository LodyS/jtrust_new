<?php

namespace App\Http\Controllers;
use DB;
use App\Models\LoanApplicant;
use Auth;
use DataTables;
use App\Models\JenisPengajuan;
use App\Models\ProductType;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataApplicantController extends Controller
{
    public function create ()
    {
        $param = [
            'aksi'=>'Create',
            'data'=>null,
            'bpr' =>DB::table('form_00')->get(['nama_bpr', 'uuid']),
            'produk'=>DB::table('product_type')->get(['id', 'product_title']),
            'jenisPengajuan'=>JenisPengajuan::toBase()->where('publish', 'Ya')->get(['kode_pengajuan', 'nama_pengajuan']),
            'skemaKredit'=>DB::table('skema_kredit')->get(),
            'fasilitas_kredit'=>DB::table('fasilitas_kredits')->get(),
        ];

        return view('data-applicant/form')->with($param);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'tanggal_apply'=>'required',
            'produk_id'=>'required',
            'sandi_bpr'=>'required',
            'bunga'=>'required',
            'label_biaya_provisi'=>'required',
        ]);
     
        $validate = $request->all();
        $validate['user_id'] = Auth::user()->id;
        $validate['status'] = 'Diproses';
        $validate['status_level_proses'] = '1';
        $validate['jenis_pengajuan'] = $request->jenis_pengajuan;
        $validate['uuid'] = Str::uuid();
        $validate['label_biaya_provisi'] = $request->label_biaya_provisi;
        $validate['baki_debet'] = 0;
        $validate['pemakaian'] = $request->pemakaian ?? 0;
        $validate['plafon_lama'] = $request->plafon_lama ?? 0;
     
        $data = LoanApplicant::create($validate);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('proses-workflow')->with('success', 'Success Add Loan Applicant');
    }

    public function edit ($id)
    {
        $param = [
            'aksi'=>'Update',
            'data'=>LoanApplicant::where('uuid', $id)->firstOrFail(),
            'produk'=>DB::table('product_type')->get(['id', 'product_title']),
            'bpr'=>DB::table('form_00')->get(['nama_bpr', 'uuid']),
            'jenisPengajuan'=>JenisPengajuan::toBase()->where('publish', 'Ya')->get(['kode_pengajuan', 'nama_pengajuan']),
            'skemaKredit'=>DB::table('skema_kredit')->get(),
            'fasilitas_kredit'=>DB::table('fasilitas_kredits')->get(),
        ];

        return view('data-applicant/form')->with($param);
    }

    public function update(Request $request)
    {
        $req = $request->except('_token');

        $update = LoanApplicant::where('id', $req['id'])->first();
        $update->update($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('proses-workflow')->with('success', 'Success update loan applicant');
    }

    public function delete (Request $request)
    {
        $data = LoanApplicant::where('loan_applicants.id', $request->id)->first();

        echo json_encode($data);
    }

    public function destroy (Request $request)
    {
        LoanApplicant::where('id', $request->id)->delete();
        return response()->json(['success'=>"Delete Data Successfly."]);
    }

    public function perpanjangan($id)
    {
        $data = LoanApplicant::where('uuid', $id)->firstOrFail();
        $aksi = 'Create';

        return view('data-applicant/form-perpanjangan', compact('data', 'aksi')); 
    }

    public function simpanPerpanjangan (Request $request)
    {
        $this->validate($request, [
            'tanggal_apply'=>'required',
            'sandi_bpr'=>'required',
            'baki_debet'=>'required',
            'tenor_perpanjang'=>'required'
        ]);

        $validate = $request->all();
        $validate['plafond'] = 0;
        $validate['user_id'] = Auth::user()->id;
        $validate['status'] = 'Diproses';
        $validate['status_level_proses'] = 1;
        $validate['baki_debet'] = $request->baki_debet;
        $validate['tenor_perpanjang'] = $request->tenor_perpanjang;
        $validate['pengajuan_induk_id'] = $request->id;
        $validate['uuid'] = Str::uuid();
  
        $data = LoanApplicant::create($validate);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('proses-workflow')->with('success', 'Sukses nambah data perpanjangan data pinjaman');
    }

    public function editPerpanjangan($id)
    {
        $data = LoanApplicant::where('uuid', $id)->firstOrFail();
        $aksi = 'Update';

        return view('data-applicant/form-perpanjangan', compact('data', 'aksi')); 
    }

    public function updatePerpanjangan(Request $request)
    {
        $req = $request->except('_token');

        $update = LoanApplicant::where('id', $req['id'])->first();
        $update->update($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('proses-workflow')->with('success', 'Success update loan applicant');
    }
}
