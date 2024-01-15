<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use DB;
use Auth;
use App\Models\Log;
use App\Models\RegionListing;
use App\Http\Requests\BranchRequest;
use Illuminate\Http\Request;
use DataTables;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()):

            $data = DB::table('branch')
            ->selectRaw('branch.id, region_listing.region_title, branch_code, branch_title, branch.publish')
            ->leftJoin('region_listing', 'region_listing.id', 'branch.region_id');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('branch.edit', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('branch.destroy', [$row->id]));

                return $actionBtn;
            })
            ->addColumn('publish', function($row){

                $publish = '';

                $publish .= ($row->publish == 1) ?
                '<button class="btn btn-xs btn-success">Published</button>' :
                '<button class="btn btn-xs btn-danger">Unpublished</button>';

                return $publish;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['action'])
            ->make(true);

        endif;

        return view('setup-user/branch/index');
    }

    public function create()
    {
        $region = RegionListing::pluck('region_title', 'id');
      
        return view('setup-user/branch/form', compact('region'));
    }

    public function store (BranchRequest $request)
    {
        try {
            $rekues = $request->validated();
            $rekues['sort_number'] = Branch::sortNumber();
            $rekues['modified_by'] = Auth::user()->id;
            $data = Branch::create($rekues);

            $log = new Log;
            $log->storeLog($request->only('tabel', 'aksi'), $data->id);

            DB::commit();
            return redirect('/branch')->with('success', 'Branch berhasil di simpan');

        } catch (Exception $e) {
            DB::rollback();
            return back()->withError('Gagal simpan branch');
        }
    }

    public function edit (Branch $branch)
    {
        $region = RegionListing::pluck('region_title', 'id');

        return view('setup-user/branch/form', compact('branch', 'region'));
    }

    public function update (Request $request, Branch $branch)
    {
        $branch->update($request->all());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $branch->id);

        return redirect('/branch')->with('success', 'Branch berhasil di update');
    }

    public function destroy (Branch $branch)
    {
        $log = new Log;
        $log->storeLog($branch->id, 'branch', 'Delete');

        $branch->delete();

        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
