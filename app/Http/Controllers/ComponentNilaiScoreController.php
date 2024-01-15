<?php

namespace App\Http\Controllers;
use App\Models\ComponentNilaiScore;
use Illuminate\Http\Request;

class ComponentNilaiScoreController extends Controller
{
    public function index ()
    {
        $data = ComponentNilaiScore::all();

        return view('config/component-nilai-score/index', compact('data'));
    }

    public function edit (Request $request)
    {
        $data = ComponentNilaiScore::where('id',$request->id)->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $data = ComponentNilaiScore::where('id', $request->id)->update($request->except('_token'));
        return back()->with('success', 'Update Success');
    }
}
