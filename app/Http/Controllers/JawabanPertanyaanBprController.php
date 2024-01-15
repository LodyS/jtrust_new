<?php

namespace App\Http\Controllers;
use DB;
use App\Models\ManajemenPertanyaan;
use App\Models\JawabanPertanyaanBpr;
use App\Models\InformasiPokokBprPelapor;
use DataTables;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Models\Log;
use Illuminate\Http\Request;

class JawabanPertanyaanBprController extends Controller
{
    public function index (Request $request)
    {
        $bpr = InformasiPokokBprPelapor::where('uuid',$request->sandi_bpr)->firstOrFail();
        $data = DB::table('jawaban_pertanyaan_bpr')
        ->selectRaw("jawaban_pertanyaan_bpr.id, review_date_month, review_date_year, sandi_bpr, SUM(
            CASE
              WHEN kelompok_pertanyaan = 'Manajemen Umum' THEN score
              ELSE 0
              END
          ) AS total_manajemen_umum,
          SUM(
            CASE
              WHEN kelompok_pertanyaan = 'Manajemen Risiko' THEN score
              ELSE 0
              END
          ) AS total_manajemen_resiko")
        ->leftJoin('manajemen_pertanyaan', 'manajemen_pertanyaan.id', 'jawaban_pertanyaan_bpr.pertanyaan_id')
        ->where('sandi_bpr', $request->sandi_bpr)
        ->groupBy('review_date_month')
        ->groupBy('review_date_year')
        ->paginate(30);

        return view('pertanyaan-bpr/index', compact('bpr', 'data'));
    }

    public function create (Request $request)
    {
        $bpr = InformasiPokokBprPelapor::where('uuid',$request->sandi_bpr)->firstOrFail();
        $jawaban_manajemen_umum = ManajemenPertanyaan::select(
            'id',
            'kelompok_pertanyaan',
            'sub_kelompok_pertanyaan',
            'detail_pertanyaan'
        )
        ->toBase()
        ->where('kelompok_pertanyaan', 'Manajemen Umum')
        ->get()
        ->groupBy([
            function ($val){ return $val->kelompok_pertanyaan; },
            function ($val){ return $val->sub_kelompok_pertanyaan; }
        ]);

        $jawaban_manajemen_resiko = ManajemenPertanyaan::select(
            'id',
            'kelompok_pertanyaan',
            'sub_kelompok_pertanyaan',
            'detail_pertanyaan'
        )
        ->toBase()
        ->where('kelompok_pertanyaan', 'Manajemen Risiko')
        ->get()
        ->groupBy([
            function ($val){ return $val->kelompok_pertanyaan; },
            function ($val){ return $val->sub_kelompok_pertanyaan; }
        ]);

        return view('pertanyaan-bpr/create', compact('jawaban_manajemen_resiko', 'jawaban_manajemen_umum', 'bpr'));
    }

    public function store (Request $request)
    {

        $data = $request->all();
        for ($i=0; $i<count($data['pertanyaan_id']); $i++):

            $insert = array (
                'sandi_bpr'=>$request->sandi_bpr,
                'review_date_month'=>$request->review_date_month,
                'review_date_year'=>$request->review_date_year,
                'pertanyaan_id'=>$data['pertanyaan_id'][$i],
                'score'=>$data['score'][$i],
                'keterangan'=>$data['keterangan'][$i],
                'user_id'=>Auth::user()->id,
            );

            $query = JawabanPertanyaanBpr::create($insert);


        endfor;

        $review_date_month = $query->review_date_month;
        $review_date_year = $query->review_date_year;
        $sandi_bpr = $query->sandi_bpr;

        $keterangan = $sandi_bpr.' '.$review_date_month.' '.$review_date_year;


        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $keterangan);

        return redirect('jawaban-pertanyaan-bpr/'.$request->sandi_bpr)->with('success', 'Berhasil simpan');
    }

    public function edit(Request $request)
    {
        $bpr = InformasiPokokBprPelapor::where('uuid',$request->sandi_bpr)->firstOrFail();
        $param['sandi_bpr'] = $request->sandi_bpr;
        $param['bulan'] = $request->review_date_month;
        $param['tahun'] = $request->review_date_year;
     
        $jawaban_manajemen_umum_edit = JawabanPertanyaanBpr::manajemen($param)
        ->where('kelompok_pertanyaan', 'Manajemen Umum')
        ->toBase()
        ->get()
        ->groupBy([
            function ($val){ return $val->kelompok_pertanyaan; },
            function ($val){ return $val->sub_kelompok_pertanyaan; }
        ]);

        $jawaban_manajemen_resiko_edit = JawabanPertanyaanBpr::manajemen($param)
        ->where('kelompok_pertanyaan', 'Manajemen Risiko')
        ->toBase()
        ->get()
        ->groupBy([
            function ($val){ return $val->kelompok_pertanyaan; },
            function ($val){ return $val->sub_kelompok_pertanyaan; }
        ]);

        $review_date_year = $jawaban_manajemen_resiko_edit['Manajemen Risiko']['Risiko Likuiditas'][0]->review_date_year;
        $review_date_month = $jawaban_manajemen_resiko_edit['Manajemen Risiko']['Risiko Likuiditas'][0]->review_date_month;
        $sum_umum = JawabanPertanyaanBpr::scoreManajemenUmum($param);
        $sum_resiko = JawabanPertanyaanBpr::scoreManajemenResiko($param);

        return view('pertanyaan-bpr/edit', compact(
            'sum_resiko',
            'sum_umum',
            'bpr',
            'jawaban_manajemen_umum_edit',
            'jawaban_manajemen_resiko_edit',
            'review_date_year',
            'review_date_month'
        ));
    }

    public function update (Request $request)
    {
        $jumlah = count($request->id);

        for ($i=0; $i<$jumlah; $i++):

            $query = DB::table('jawaban_pertanyaan_bpr')
            ->where('id', $request->id[$i])
            ->update([
                'score'=>$request->score[$i],
                'keterangan'=>$request->keterangan[$i],
                'review_date_month'=>$request->review_date_month,
                'review_date_year'=>$request->review_date_year
            ]);

        endfor;

        $review_date_month = $request->review_date_month;
        $review_date_year = $request->review_date_year;
        $sandi_bpr = $request->sandi_bpr;

        $keterangan = $sandi_bpr.' '.$review_date_month.' '.$review_date_year;

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $keterangan);

        return redirect('jawaban-pertanyaan-bpr/'.$request->sandi_bpr)->with('success', 'Berhasil update');
    }

    public function destroy (Request $request)
    {
        $cek = JawabanPertanyaanBpr::where('id', $request->id)->first();
        $data = $cek->where('review_date_month', $cek->review_date_month)
        ->where('review_date_year', $cek->review_date_year)
        ->where('sandi_bpr', $cek->sandi_bpr)
        ->delete();

        $review_date_month = $cek->review_date_month;
        $review_date_year = $cek->review_date_year;
        $sandi_bpr = $cek->sandi_bpr;

        $keterangan = $sandi_bpr.' '.$review_date_month.' '.$review_date_year;

        $log = new Log;
        $log->storeLog($request->only('tabel', 'aksi'), $keterangan);

        echo json_encode($data);
    }
}
