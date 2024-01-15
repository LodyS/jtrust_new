<?php

namespace App\Http\Controllers;
use App\Models\Bwmk;
use DB;
use Auth;
use DataTables;
use App\Models\Log;
use App\Http\Requests\BwmkRequest;
use Illuminate\Http\Request;

class BwmkController extends Controller
{
    public function index ()
    {
        $data = Bwmk::select('*')->toBase()->paginate(10);

        return view ('setup-user/bwmk/index', compact('data'));
    }

    public function create()
    {
        $jabatan = DB::table('jabatan')->select('id', 'nama_jabatan')->where('member_of_credit_committee', 'Yes')->get();
        return view('setup-user/bwmk/create', compact('jabatan'));
    }

    public function store(BwmkRequest $request)
    {
        $req = $request->validated();

        $nilai_kredit_minimum = preg_replace('/[^0-9]/', '', $req['nilai_kredit_minimum']);
        $nilai_kredit_maksimum = preg_replace('/[^0-9]/', '', $req['nilai_kredit_maksimum']);

        if ($nilai_kredit_minimum > $nilai_kredit_maksimum):
            return back()->withError('Nilai kredit maksimum harus lebih besar dari nilai kredit minimum');
        endif;

        $data = Bwmk::create($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('/bwmk')->with('success', 'Berhasil tambah Bwmk');
    }

    public function edit($id)
    {
        $data = Bwmk::findOrFail($id);
        $jabatan = DB::table('jabatan')->where('member_of_credit_committee', 'Yes')->get(['id', 'nama_jabatan']);
        $voting_member = $data->voting_member;
        $non_voting_member = $data->non_voting_member;

        return view('setup-user/bwmk/form', compact('data', 'non_voting_member', 'voting_member', 'jabatan'));
    }

    public function update(BwmkRequest $request)
    {
        $req = $request->validated();

        $nilai_kredit_minimum = preg_replace('/[^0-9]/', '', $req['nilai_kredit_minimum']);
        $nilai_kredit_maksimum = preg_replace('/[^0-9]/', '', $req['nilai_kredit_maksimum']);

        if ($nilai_kredit_minimum > $nilai_kredit_maksimum):
            return back()->withError('Nilai kredit maksimum harus lebih besar dari nilai kredit minimum');
        endif;

        $update = Bwmk::where('id',$request->id)->first();
        $update->update($req);

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('/bwmk')->with('success', 'Bwmk berhasil di update');
    }

    public function destroy (Request $request, Bwmk $bwmk)
    {
        $bwmk->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), '');

        return response()->json(['success'=>"Delete Data Successfly."]);
    }
}
