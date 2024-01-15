<?php

namespace App\Http\Controllers;
use App\Models\RegionListing;
use Illuminate\Http\Request;
use App\Http\Requests\RegionListingRequest;
use DB;
use App\Models\Log;
use DataTables;

class RegionListingController extends Controller
{
    public function index (Request $request)
    {
        if ($request->ajax()):
            $data = DB::table('region_listing')->select('id', 'region_title', 'region_code');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = route_general(route('region.destroy', [$row->id]), 'Edit', 'secondary');
                $actionBtn .= button_delete(route('region.destroy', [$row->id]));

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        endif;

        return view ('setup-user/region-listing/index');
    }

    public function create ()
    {
        $data = null;
        $sortNumber = RegionListing::sortNumber();
        $aksi = "Create";

        return view ('setup-user/region-listing/form', compact('sortNumber', 'data', 'aksi'));
    }

    public function store (Request $request)
    {
        $data = RegionListing::create($request->all());

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $data->id);

        return redirect('/region')->with('success', 'Region berhasil di simpan');
    }

    public function edit ($id)
    {
        $data = RegionListing::findOrFail($id);
        $sortNumber = RegionListing::sortNumber();
        $aksi = "Update";

        return view ('setup-user/region-listing/form', compact('sortNumber', 'data', 'aksi'));
    }

    public function update (Request $request)
    {
        RegionListing::find($request->id)->update($request->except('sortnumber', 'modified_by'));

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $request->id);

        return redirect('/region')->with('success', 'Region berhasil di update');
    }

    public function destroy (Request $request, RegionListing $region)
    {
        $region->delete();

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $region->id);
        return response()->json(['success'=>"Data berhasil di hapus."]);
    }
}
