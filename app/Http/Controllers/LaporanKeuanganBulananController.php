<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\LaporanPosisiKeuanganTable;
use App\Models\InformasiPokokBprPelapor;
use App\Models\RekeningAdministratif;
use App\Models\HeaderImport;
use App\Models\InputProfil;
use App\Models\LaporanLabaRugiTable;
use App\Http\Requests\LaporanBulananRequest;
use App\Http\Requests\InputProfilRequest;
use App\Models\InputFinancialHighlight;
use App\Models\LaporanAsetProduktif;
use Illuminate\Http\Request;

class LaporanKeuanganBulananController extends Controller
{
    public function index($sandi_bpr)
    {
        return view('laporan-keuangan-bulanan/financial-highlight', compact('sandi_bpr'));
    }

    // Input financial highlight
    public function financialHiglight($sandi_bpr)
    {
        return view('laporan-keuangan-bulanan/financial-highlight', compact('sandi_bpr'));
    }

    public function cari(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $sandi_bpr = $request->sandi_bpr;

        $req['sandi_bpr'] = $request->sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanPosisiKeuanganTable::max_tahun($req);
        $req['bulan'] = $request->bulan ?? LaporanPosisiKeuanganTable::max_bulan($req);
        $req['data'] = LaporanPosisiKeuanganTable::spreadSheet($req);
        $perhitungan_ppap_wajib =LaporanPosisiKeuanganTable::getPerhitunganPpapWajib($req);

        // hitung asset 
        $req['pos'] = 'Aset tetap dan inventaris';
        $aset_tetap_dan_inventaris = LaporanPosisiKeuanganTable::search_one_column($req);

        // akumulasi penyusutan
        $req['pos'] = 'Akumulasi penyusutan dan penurunan nilai   -/-';
        $akumulasi_penyusutan = LaporanPosisiKeuanganTable::search_one_column($req);

        // aset tidak berwujud
        $req['pos'] = 'Aset tidak berwujud';
        $aset_tidak_berwujud = LaporanPosisiKeuanganTable::search_one_column($req);

        // Akumulasi amortisasi dan penurunan nilai  
        $req['pos'] = 'Akumulasi amortisasi dan penurunan nilai   -/-';
        $akumulasi_amortisasi = LaporanPosisiKeuanganTable::search_one_column($req);

        // Aset antar kantor
        $req['pos'] = 'Aset antarkantor';
        $aset_antar_kantor = LaporanPosisiKeuanganTable::search_one_column($req);

        // Aset lain lain
        $req['pos'] = 'Aset lain-lain';
        $aset_lain_lain = LaporanPosisiKeuanganTable::search_one_column($req);

        $aset = $aset_tetap_dan_inventaris -  $akumulasi_penyusutan +  $aset_tidak_berwujud -  $akumulasi_amortisasi +  $aset_antar_kantor +  $aset_lain_lain;

        // laba di tahan 
        $req['pos'] = 'Laba tahun-tahun yang lalu';
        $laba_ditahan = LaporanPosisiKeuanganTable::search_one_column($req);

        // pemulihan papp yang diberikan
        $req['pos'] = 'Penyisihan penghapusan aktiva produktif   -/-';
        $ppap_yang_dipulihkan = LaporanPosisiKeuanganTable::where([
            'pos'=>$req['pos'], 
            'bulan'=>$req['bulan'],
            'tahun'=>$req['tahun'],
            'sandi_bpr'=>$req['sandi_bpr']
        ])
        ->orderByDesc('id')
        ->value('posisi_tanggal_laporan');

        // pemulihan wo
        $pemulihan_wo = DB::table('laporan_laba_rugi_table')
        ->where([
            'pos'=>'e. Pemulihan penyisihan penghapusan aset produktif', 
            'bulan'=>$req['bulan'],
            'tahun'=>$req['tahun'],
            'sandi_bpr'=>$req['sandi_bpr']
        ])
        ->value('posisi_tanggal_laporan');

        $data = collect(DB::select("SELECT
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Pembiayaan Yang Diberikan') AS pembiayaan_yang_diberikan,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Pembiayaan Yang Diberikan Bermasalah') AS pembiayaan_yang_diberikan_bermasalah,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Pembiayaan yg diterima dengan jatuh tempo <= 3 bln') AS kredit_kurang_tiga_bulan,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Pembiayaan yg diterima dengan jatuh tempo > 3 bln') AS kredit_lebih_tiga_bulan,
        (SELECT posisi_tanggal_laporan FROM laporan_posisi_keuangan_table WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Modal Dasar') AS modal_dasar,
        (SELECT posisi_tanggal_laporan FROM laporan_posisi_keuangan_table WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Laba tahun berjalan') AS laba_tahun_berjalan,
        (SELECT posisi_tanggal_laporan FROM laporan_posisi_keuangan_table WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Simpanan') AS simpanan,


        (SELECT posisi_tanggal_laporan FROM laporan_laba_rugi_table WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'LABA/(RUGI) TAHUN BERJALAN SEBELUM PAJAK') AS ebit,
        (SELECT posisi_tanggal_laporan FROM laporan_laba_rugi_table WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'LABA/(RUGI) BERSIH TAHUN BERJALAN') AS ebitda,

        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Tabungan') AS tabungan,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Deposito') AS deposito,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Tabungan Dari Bank Lain') AS tabungan_dari_bank_lain,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Deposito Dari Bank Lain') AS deposito_dari_bank_lain,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Penempatan Pada Bank Lain') AS penempatan_pada_bank_lain,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'LDR') AS ldr,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Cash Ratio') AS cash_ratio,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'CAR (Capital Adequacy Ratio)') AS car,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'ROAA (Return of Average Asset)') AS roa,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'ROAE (Return of Average Equity)') AS roe,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'BOPO (Biaya Operasional thd Pendapatan Ops.)') AS bopo,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'DER (Debt to Equity Ratio)') AS der,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'NPL (Gross)') AS npl,
        (SELECT jumlah FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'NPL (Nett)') AS npl_nett,
        (SELECT '$perhitungan_ppap_wajib' AS ppap_yang_diberikan) AS ppap_yang_diberikan,
        (SELECT '$aset' AS aset) AS aset,
        (SELECT '$laba_ditahan' AS laba_ditahan) AS laba_ditahan,
        (SELECT '$ppap_yang_dipulihkan' AS ppap_yang_dipulihkan) as ppap_yang_dipulihkan,
        (SELECT '$pemulihan_wo' AS pemulihan_wo) as pemulihan_wo, 
        (SELECT nominal FROM rekening_administratif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr AND pos = 'Aktiva produktif yang dihapusbuku') AS aktiva_produktif_yang_dihapus
        FROM laporan_aset_produktif WHERE bulan = :bulan AND tahun = :tahun AND sandi_bpr = :sandi_bpr
      
        LIMIT 1", ['bulan'=>$bulan, 'tahun'=>$tahun, 'sandi_bpr'=>$sandi_bpr]));

        echo json_encode($data);
        exit;
    }

    public function store(Request $request)
    {
        $jumlah = count($request->keterangan);

        for ($i=0; $i<$jumlah; $i++):

            DB::table('input_financial_highlight')
            ->insert([
                'sandi_bpr'=>$request->sandi_bpr,
                'jenis'=>$request->jenis,
                'sub_jenis'=>$request->sub_jenis,
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
                'keterangan'=>$request->keterangan[$i],
                'nominal'=>$request->nominal[$i] ?? 0,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return back()->with('success', 'Berhasil simpan data Financial Highlight');
    }

    public function edit(Request $request)
    {         
        $req['sandi_bpr'] = $request->sandi_bpr;
      	$req['jenis'] = $request->jenis;
        $req['tahun'] = $request->tahun ?? InputFinancialHighlight::max_tahun($req);
        $req['bulan'] = $request->bulan ?? InputFinancialHighlight::max_bulan($req); 

        $jenis = $request->jenis;
   
        $data = DB::table('input_financial_highlight')
        ->where('tahun', $req['tahun'])
        ->where('sandi_bpr', $req['sandi_bpr'])
        ->where('bulan', $req['bulan'])
        ->when($jenis, function($query, $jenis){
            return $query->where('jenis', $jenis);
        })
        ->orderBy('id', 'asc')
        ->get();

        $parsing = [
            'tahun'=>$req['tahun'],
            'sandi_bpr'=>$req['sandi_bpr'],
            'jenis'=>$req['jenis'],
            'bulan'=>$req['bulan'],
            'data'=>$data
        ];

        return view('laporan-keuangan-bulanan/edit-financial-highlight')->with($parsing);
    }

    public function update(Request $request)
    {
        $jumlah = count($request->id);

        for ($i=0; $i<$jumlah; $i++):

            DB::table('input_financial_highlight')
            ->where('id', $request->id[$i])
            ->update([
                'nominal'=>$request->nominal[$i] ?? 0,
                'updated_at'=>\Carbon\Carbon::now(),
            ]);

        endfor;

        return redirect('aksi-financial-highlight/'.$request->sandi_bpr)->with('success', 'Berhasil update financial highlight');
    }

}
