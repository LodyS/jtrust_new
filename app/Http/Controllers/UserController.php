<?php

namespace App\Http\Controllers;
use App\Models\User;
use DB;
use Auth;
use DataTables;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\Log;

class UserController extends Controller
{
    public function index (Request $request)
    {
        if($request->ajax()):
            $data = DB::table('users')
            ->select('users.id', 'name', 'nama_jabatan as jabatan', 'status')
            ->leftJoin('jabatan', 'jabatan.id', 'users.jabatan');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $id = $row->id;
                $url = route('list-user.destroy', [$id]);
                $url = "'".$url."'";

                $actionBtn = '

                <div class="dropdown">
                    <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Action
                    <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="'. route('list-user.edit', $id).'">Edit</a></li>
                        <br/>
                        <li><a tabindex="-1" href="javascript:void(0);" onClick="block('. $id.')">Block</a></li>
                        <br/>
                        <li><a tabindex="-1" href="javascript:void(0);" onClick="openBlock('. $id.')">Open Block</a></li>
                        <br/>
                        <li><a tabindex="-1" href="javascript:void(0);" onClick="deactive('. $id.')">Deactive</a></li>
                        <br/>
                        <li><a tabindex="-1" href="javascript:void(0);" onClick="hapus('.$url.')">Delete</a></li>
                    </ul>
                </div>';

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('user/index');
    }

    public function create ()
    {
        $atasan = User::where('id', '<>', Auth::user()->id)->get();
        $jabatan = DB::table('jabatan')->get(['id','nama_jabatan']);

        return view('user/form', compact('atasan', 'jabatan'));
    }

    public function store (UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $user = new User;
            $user = $user->storeUser($req);

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $user->id);

            DB::commit();
            return redirect('list-user')->with('success', 'Berhasil tambah user');
        } catch (Exception $e){
            DB::rollback();
            return back()->withError('Gagal tambah user');
        }
    }

    public function edit (User $list_user)
    {
        $atasan = User::where('id', '<>', Auth::user()->id)->get();
        $jabatan = DB::table('jabatan')->get(['id', 'nama_jabatan']);

        return view('user/form', compact('atasan', 'jabatan', 'list_user'));
    }

    public function update (Request $request, User $list_user)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            
            if (empty($data['password'])):
                unset($data['password']);
                $list_user->update($data);
            else:
                $list_user->update($data);
            endif;

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $list_user->id);

            DB::commit();
            return redirect('list-user')->with('success', 'Success Update User');

        } catch(Exception $e){
            DB::rollback();
            return back()->withError('Gagal update user');
        }
    }

    public function updateStatusUser(Request $request)
    {
        $data = User::where('id', $request->id)->update(['status'=>$request->status]);

        $req['tabel'] = 'user';
        $req['aksi'] = 'update '.'status menjadi '.$request->status;
        $log = new Log;
        $log->storeLog($req, $request->id);

        return response()->json(['success'=>"Data berhasil di update."]);
    }

    public function destroy(Request $request, User $list_user)
    {
        $log = new Log;
        $log->storeLog($list_user->id, 'users', 'Delete');

        $list_user->delete();

        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
