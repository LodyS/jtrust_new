<?php

namespace App\Http\Controllers;
use DB;
use App\Models\HeaderImport;
use App\Models\InformasiPokokBprPelapor;
use App\Models\LaporanAsetProduktif;
use Illuminate\Http\Request;

class HistoriRatioController extends Controller
{
    public function index (Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        $bpr = HeaderImport::where('sandi_bpr', $request->sandi_bpr)->toBase()->first();
        $bprr = InformasiPokokBprPelapor::where('uuid', $request->sandi_bpr)->toBase()->first();
        $sandi_bpr = $request->sandi_bpr;

        $data = DB::select("SELECT
        DISTINCT A.pos,
        COALESCE(jumlah_januari, 0) AS jumlah_januari,
        COALESCE(jumlah_februari, 0) AS jumlah_februari,
        COALESCE(jumlah_maret, 0) AS jumlah_maret,
        COALESCE(jumlah_april, 0) AS jumlah_april,
        COALESCE(jumlah_mei, 0) AS jumlah_mei,
        COALESCE(jumlah_juni, 0) AS jumlah_juni,
        COALESCE(jumlah_juli, 0) AS jumlah_juli,
        COALESCE(jumlah_agustus, 0) AS jumlah_agustus,
        COALESCE(jumlah_september, 0) AS jumlah_september,
        COALESCE(jumlah_oktober, 0) AS jumlah_oktober,
        COALESCE(jumlah_november, 0) AS jumlah_november,
        COALESCE(jumlah_desember, 0) AS jumlah_desember

        FROM

        (SELECT DISTINCT pos FROM laporan_aset_produktif) A

        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_januari, pos, jumlah AS jumlah_januari FROM laporan_aset_produktif WHERE bulan='1' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) januari ON januari.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_februari, pos, jumlah AS jumlah_februari FROM laporan_aset_produktif WHERE bulan='2' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) februari ON februari.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_maret, pos, jumlah AS jumlah_maret FROM laporan_aset_produktif WHERE bulan='3' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) B ON B.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_april, pos, jumlah AS jumlah_april FROM laporan_aset_produktif WHERE bulan='4' AND tahun=:tahun AND sandi_bpr=:sandi_bpr ) april ON april.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_mei, pos, jumlah AS jumlah_mei FROM laporan_aset_produktif WHERE bulan='5' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) mei ON mei.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_juni, pos, jumlah AS jumlah_juni FROM laporan_aset_produktif WHERE bulan='6' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) C ON C.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_juli, pos, jumlah AS jumlah_juli FROM laporan_aset_produktif WHERE bulan='7' AND tahun=:tahun AND sandi_bpr=:sandi_bpr ) juli ON juli.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_agustus, pos, jumlah AS jumlah_agustus FROM laporan_aset_produktif WHERE bulan='8' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) agustus ON agustus.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_september, pos, jumlah AS jumlah_september FROM laporan_aset_produktif WHERE bulan='9' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) D ON D.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_oktober, pos, jumlah AS jumlah_oktober FROM laporan_aset_produktif WHERE bulan='10' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) oktober ON oktober.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_november, pos, jumlah AS jumlah_november FROM laporan_aset_produktif WHERE bulan='11' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) november ON november.pos = A.pos
        LEFT JOIN (SELECT laporan_aset_produktif.id AS id_desember, pos, jumlah AS jumlah_desember FROM laporan_aset_produktif WHERE bulan='12' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) E ON E.pos = A.pos",

        ['sandi_bpr'=>$request->sandi_bpr, 'tahun'=>$tahun]);

        $query_grafik = collect(DB::select("SELECT
        A.bulan,
        B.jumlah AS ldr,
        C.jumlah AS kewajiban_bersih_terhadap_modal_inti,
        D.jumlah AS cash_ratio,
        E.jumlah AS npl_gross,
        F.jumlah AS roaa,
        G.jumlah AS roae,
        H.jumlah AS bopo,
        I.jumlah AS der,
        J.jumlah AS ngr,
        K.jumlah AS car,
        L.jumlah AS nim,
        M.jumlah AS rasio_pemenuhan_ppap,
        N.jumlah AS net_kredite_terhadap_total_aktiva,
        O.jumlah AS bdr,
        P.jumlah AS return_on_paid_in_capital,
        Q.jumlah AS cost_of_fund_funding,
        R.jumlah AS yield_ykd,
        S.jumlah AS bad_debt_write_off_ratio,
        T.jumlah AS bad_debt_ratio

        FROM
        (SELECT bulan FROM laporan_aset_produktif WHERE tahun=:tahun AND sandi_bpr=:sandi_bpr) A
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='LDR' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) B ON B.bulan = A.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Kewajiban bersih terhadap modal inti' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) C ON C.bulan = B.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Cash Ratio' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) D ON D.bulan = C.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='NPL (Gross)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) E ON E.bulan = D.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='ROAA (Return of Average Asset)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) F ON F.bulan = E.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='ROAE (Return of Average Equity)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) G ON G.bulan = F.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='BOPO (Biaya Operasional thd Pendapatan Ops.)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) H ON H.bulan = G.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='DER (Debt to Equity Ratio)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) I ON I.bulan = H.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='NGR (Net Gearing Ratio)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) J ON J.bulan = I.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='CAR (Capital Adequacy Ratio)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) K ON K.bulan = J.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='NIM (Net Interest Margin)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr)  L ON L.bulan = J.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Rasio Pemenuhan PPAP' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) M ON M.bulan = L.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Net Kredit Terhadap Total Aktiva' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) N ON N.bulan = M.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='BDR (Bad Debt Ratio)' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) O ON O.bulan = N.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Return on Paid In Capital' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) P ON P.bulan = O.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Cost of Fund Funding' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) Q ON Q.bulan = P.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Yield KYD' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) R ON R.bulan = Q.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Bad Debt Write Off Ratio' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) S ON S.bulan = R.bulan
        LEFT JOIN (SELECT bulan, jumlah FROM laporan_aset_produktif WHERE pos='Bad Debt Ratio' AND tahun=:tahun AND sandi_bpr=:sandi_bpr) T ON T.bulan = S.bulan
        
        GROUP BY A.bulan", ['tahun'=>$tahun, 'sandi_bpr'=>$request->sandi_bpr]));

        $result[] = [
            'Periode Waktu',
            'ldr',
            'kewajiban_bersih_terhadap_modal_inti',
            'cash_ratio',
            'npl_gross',
            'roaa',
            'roae',
            'bopo',
            'der',
            'ngr',
            'car',
            'nim',
            'rasio_pemenuhan_ppap',
            'net_kredite_terhadap_total_aktiva',
            'bdr',
            'return_on_paid_in_capital',
            'cost_of_fund_funding',
            'yield_ykd',
            'bad_debt_write_off_ratio',
            'bad_debt_ratio'
        ];

        foreach ($query_grafik as $key => $value):

            $result[++$key] = [

                bulan($value->bulan),
                (float)$value->ldr,
                (float)$value->kewajiban_bersih_terhadap_modal_inti,
                (float)$value->cash_ratio,
                (float)$value->npl_gross,
                (float)$value->roaa,
                (float)$value->roae,
                (float)$value->bopo,
                (float)$value->der,
                (float)$value->ngr,
                (float)$value->car,
                (float)$value->nim,
                (float)$value->rasio_pemenuhan_ppap,
                (float)$value->net_kredite_terhadap_total_aktiva,
                (float)$value->bdr,
                (float)$value->return_on_paid_in_capital,
                (float)$value->cost_of_fund_funding,
                (float)$value->yield_ykd,
                (float)$value->bad_debt_write_off_ratio,
                (float)$value->bad_debt_ratio
            ];

        endforeach;

        return view('financial-highlight/histori-ratio/index', compact('data', 'tahun', 'bpr', 'bprr', 'sandi_bpr'))->with('grafik',json_encode($result));
    }
}
