<?php

namespace App\Http\Controllers;
use DB;
use App\Models\LaporanAsetProduktif;
use App\Models\KomponenTks;
use App\Models\JawabanPertanyaanBpr;
use App\Models\HeaderImport;
use Illuminate\Http\Request;

class TingkatKesehatanBankController extends Controller
{
    public function index (Request $request)
    {
        $sandi_bpr = $request->sandi_bpr;
        $req['sandi_bpr'] = $sandi_bpr;
        $req['tahun'] = $request->tahun ?? LaporanAsetProduktif::max_tahun($req);
        $header = LaporanAsetProduktif::max_bulan($req);
        //$periode = $header->periode_waktu ?? '';

        $bulan = $request->bulan ?? $header;
        $tahun =  $req['tahun'];

        $param['sandi_bpr'] = $sandi_bpr;
        $param['bulan'] = $bulan;
        $param['tahun'] = $tahun;

        $manajemen_umum = JawabanPertanyaanBpr::scoreManajemenUmum($param);
        $manajemen_resiko = JawabanPertanyaanBpr::scoreManajemenResiko($param);

         // CAR
        $nilai_car = LaporanAsetProduktif::nilaiKap($param)->where('pos', 'a. KPMM')->value('jumlah') ?? 0;
        $bobot_komponen_car = KomponenTks::where('sub_komponen', 'CAR/KPMM')->toBase()->first();
        $bobot_komponen_dalam_faktor_car = KomponenTks::where('sub_komponen', 'CAR/KPMM')->sum('bobot');
        $nilai_kredit_car = ($nilai_car - $bobot_komponen_car->minimum_ratio)/$bobot_komponen_car->perubahan_ratio;
        $nilai_kredit_car = $nilai_kredit_car + $bobot_komponen_car->nilai_minimum_kredit;
        $nilai_kredit_car = ($nilai_kredit_car >=100) ? 100 : $nilai_kredit_car;

        // KAP
        $nilai_kap = LaporanAsetProduktif::nilaiKap($param)->where('pos', 'b. KAP')->value('jumlah') ?? 0;
        $bobot_komponen_kap = KomponenTks::where('sub_komponen', 'KAP')->toBase()->first();
        $bobot_komponen_dalam_faktor_kap = KomponenTks::where('komponen', 'KAP')->sum('bobot');
        $nilai_kredit_kap = ((float)$nilai_kap - (float)$bobot_komponen_kap->minimum_ratio);
        $nilai_kredit_kap = (float)$nilai_kredit_kap/(float)$bobot_komponen_kap->perubahan_ratio;
        $nilai_kredit_kap = (float)$nilai_kredit_kap + (float)$bobot_komponen_kap->nilai_minimum_kredit;
        $nilai_kredit_kap = ($nilai_kredit_kap >=100) ? 100 : $nilai_kredit_kap;

        // PPAP
        $nilai_ppap = LaporanAsetProduktif::nilaiKap($param)->where('pos', 'c. PPAP')->value('jumlah') ?? 0;
        $bobot_komponen_ppap = KomponenTks::where('sub_komponen', 'PPAP')->toBase()->first();
        $bobot_komponen_dalam_faktor_ppap = KomponenTks::where('komponen', 'KAP')->sum('bobot');
        $nilai_kredit_ppap = ($nilai_ppap - $bobot_komponen_ppap->minimum_ratio);
        $nilai_kredit_ppap = $nilai_kredit_ppap/$bobot_komponen_ppap->perubahan_ratio;
        $nilai_kredit_ppap = $nilai_kredit_ppap + $bobot_komponen_ppap->nilai_minimum_kredit;
        $nilai_kredit_ppap = ($nilai_kredit_ppap >=100) ? 100 : $nilai_kredit_ppap;

        $review_date_month = JawabanPertanyaanBpr::where('sandi_bpr', $request->sandi_bpr)->max('review_date_month');
        $review_date_year = JawabanPertanyaanBpr::where('sandi_bpr', $request->sandi_bpr)->max('review_date_year');
        // Manajemen Umum
        $manajemen_umum_nilai = JawabanPertanyaanBpr::where('kelompok_pertanyaan', 'Manajemen Umum')
        ->leftJoin('manajemen_pertanyaan', 'jawaban_pertanyaan_bpr.pertanyaan_id', 'manajemen_pertanyaan.id')
        ->where('sandi_bpr', $request->sandi_bpr)
        ->where('review_date_month', $review_date_month)
        ->where('review_date_year', $review_date_year)
        ->sum('jawaban_pertanyaan_bpr.score');

        $manajemen_umum_bobot = KomponenTks::where('sub_komponen', 'Manajemen Umum')->sum('bobot');

        // Manajemen Resiko
        $manajemen_resiko_nilai = JawabanPertanyaanBpr::where('kelompok_pertanyaan', 'Manajemen Risiko')
        ->leftJoin('manajemen_pertanyaan', 'jawaban_pertanyaan_bpr.pertanyaan_id', 'manajemen_pertanyaan.id')
        ->where('sandi_bpr', $request->sandi_bpr)
        ->where('review_date_month', $review_date_month)
        ->where('review_date_year', $review_date_year)
        ->sum('jawaban_pertanyaan_bpr.score');

        $manajemen_resiko_bobot = KomponenTks::where('sub_komponen', 'Manajemen Risiko')->sum('bobot');
        $manajemen_komponen_faktor = KomponenTks::where('komponen', 'MANAJEMEN')->sum('bobot');

        // ROA
        $roa_nilai = LaporanAsetProduktif::nilaiKap($param)->where('pos', 'e. ROA')->value('jumlah') ?? 0;
        $roa_komponen = KomponenTks::where('sub_komponen', 'ROA')->first();
        $roa_bobot = KomponenTks::where('sub_komponen', 'ROA')->sum('bobot');
        $roa_nilai_kredit = ($roa_nilai - $roa_komponen->minimum_ratio);
        $roa_nilai_kredit = ($roa_nilai_kredit/$roa_komponen->perubahan_ratio);
        $roa_nilai_kredit = ($roa_nilai_kredit * $roa_komponen->perubahan_nilai_kredit) + $roa_komponen->nilai_kredit_minimum;
        $total_bobot_rentabilitas = KomponenTks::where('komponen', 'RENTABILITAS')->sum('bobot');

        // BOPO
        $bopo_nilai = LaporanAsetProduktif::nilaiKap($param)->where('pos', 'f. BOPO')->value('jumlah') ?? 0;
        $bopo_komponen = KomponenTks::where('sub_komponen', 'CR')->first();
        $bopo_bobot = KomponenTks::where('sub_komponen', 'CR')->sum('bobot');
        $bopo_nilai_kredit = ($bopo_nilai - $bopo_komponen->minimum_ratio);
        $bopo_nilai_kredit = ($bopo_nilai_kredit/$bopo_komponen->perubahan_ratio);
        $bopo_nilai_kredit = ($bopo_nilai_kredit * $bopo_komponen->perubahan_nilai_kredit) + $bopo_komponen->nilai_kredit_minimum;

        //Cash Ratio
        $cr_nilai = LaporanAsetProduktif::nilaiKap($param)->where('pos', 'h. Cash Ratio')->value('jumlah') ?? 0;
        $cr_komponen = KomponenTks::where('sub_komponen', 'CR')->first();
        $cr_bobot = KomponenTks::where('sub_komponen', 'CR')->sum('bobot');
        $cr_nilai_kredit = ($cr_nilai - $cr_komponen->minimum_ratio);
        $cr_nilai_kredit = ($cr_nilai_kredit/$cr_komponen->perubahan_ratio);
        $cr_nilai_kredit = ($cr_nilai_kredit * $cr_komponen->perubahan_nilai_kredit) + $cr_komponen->nilai_kredit_minimum;

        // LDR
        $ldr_nilai = LaporanAsetProduktif::nilaiKap($param)->where('pos', 'g. LDR')->value('jumlah') ?? 0;
        $ldr_komponen = KomponenTks::where('sub_komponen', 'LDR')->first();
        $ldr_bobot = KomponenTks::where('sub_komponen', 'LDR')->sum('bobot');
        $ldr_nilai_kredit = ($ldr_nilai - $ldr_komponen->minimum_ratio);
        $ldr_nilai_kredit = ($ldr_nilai_kredit/$ldr_komponen->perubahan_ratio);
        $ldr_nilai_kredit = ($ldr_nilai_kredit * $ldr_komponen->perubahan_nilai_kredit) + $ldr_komponen->nilai_kredit_minimum;

        $total_bobot_likuiditas = KomponenTks::where('komponen', 'LIKUIDITAS')->sum('bobot');

        if($header== null):
             return back()->withError('Belum upload laporan aset produktif');
        else :
            return view ('financial-highlight/tingkat-kesehatan-bank/index', compact(
                'bulan',
                'tahun',
                'sandi_bpr',
                // Nilai
                'nilai_car',
                'nilai_kap',
                'nilai_ppap',
                'roa_nilai',
                'bopo_nilai',
                'cr_nilai',
                'ldr_nilai',

                'manajemen_umum',
                'manajemen_resiko',
                'header',
                'bobot_komponen_car',
                'bobot_komponen_dalam_faktor_car',
                'nilai_kredit_car',
                // KAP
                'bobot_komponen_kap',
                'bobot_komponen_dalam_faktor_kap',
                'nilai_kredit_kap',
                // PPAP
                'bobot_komponen_ppap',
                'bobot_komponen_dalam_faktor_ppap',
                'nilai_kredit_ppap',

                // Manajemen Umum
                'manajemen_umum_nilai',
                'manajemen_umum_bobot',
                // Manajemen Resiko
                'manajemen_resiko_nilai',
                'manajemen_resiko_bobot',
                'manajemen_komponen_faktor',
                // ROA
                'roa_nilai',
                'roa_bobot',
                'roa_nilai_kredit',

                // BOPO
                'bopo_nilai',
                'bopo_bobot',
                'bopo_nilai_kredit',
                'total_bobot_rentabilitas',

                // CR
                'cr_nilai',
                'cr_bobot',
                'cr_nilai_kredit',
                // LDR
                'ldr_nilai',
                'ldr_bobot',
                'ldr_nilai_kredit',
                'total_bobot_likuiditas'
             ));

        endif;
    }
}
