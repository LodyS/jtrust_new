<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Pemasaran;
use App\Models\KegiatanUsaha;
use App\Models\PerhitunganKebutuhanKredit;
use App\Models\Legalitas;
use App\Models\ResumeHasilObservasi;
use App\Models\Agunan;
use App\Models\Kepatuhan;
use App\Models\UsulanKredit;
use App\Models\Disclaimer;
use App\User;
use App\Models\LoanApplicant;
use App\Models\Bwmk;
use App\Models\HeaderImport;
use App\Models\DataKepemilikanBpr;
use App\Models\InformasiPokokBprPelapor;
use App\Models\IkhtisarLaporanKeuangan;
use App\Models\KondisiKeuanganDebitur;
use App\Models\ProspekDanKinerjaUsaha;
use App\Models\InputFinancialHighlight;
use PDF;

class NakPrintController extends Controller
{
    public function index($id)
    {
        // Header
        $data_header = LoanApplicant::where('uuid', $id)->firstOrFail();
        $tanggal = date('d', strtotime($data_header->tanggal_nak));
        $bulan = bulan((int)date('m', strtotime($data_header->tanggal_nak)));
        $tahun = date('Y', strtotime($data_header->tanggal_nak));
        $tanggal = (int)$tanggal. ' ' .$bulan. ' '. $tahun;
        $departemenHead = User::select('atasan_id')->toBase()->where('id', $data_header->user_id)->first();
        $departemenHeadAtasan = $departemenHead->atasan_id ?? '';
        $departemenHead = User::select('id','name', 'atasan_id')->toBase()->where('id', $departemenHeadAtasan)->first();

        $divisionHead = User::select('id', 'name', 'atasan_id')->toBase()->where('id', $departemenHeadAtasan)->first();
        $divisionHead = User::select('id', 'name', 'atasan_id')->toBase()->where('id', $divisionHead->atasan_id)->first();
        $relationshipManager = User::select('name')->toBase()->where('id', $data_header->user_id)->first();
        $sandi_bpr = $data_header->sandi_bpr;

        // informasi debitur
        $data_informasi_debitur = InformasiPokokBprPelapor::where('uuid', $sandi_bpr)->first();
        $keteranganBpr = DataKepemilikanBpr::where('sandi_bpr', $sandi_bpr)->value('keterangan');
        $pemegangSaham = DataKepemilikanBpr::where('sandi_bpr', $sandi_bpr)->toBase()->get();

        // Informasi Group (form 00 - informasi pokok pelapor)
        $informasiPokokBprPelapor = InformasiPokokBprPelapor::select(
            'id',
            'nama_group',
            'bidang_usaha_group',
            'tahun_pendirian_group'
        )
        ->where('sandi_bpr', $sandi_bpr)
        ->toBase()
        ->first();

        $ikhtisarLaporanKeuangan = IkhtisarLaporanKeuangan::where('sandi_bpr', $sandi_bpr)->toBase()->get();

        // BWMK
        $informasi_grup_usaha = $data_header->master_bpr[0]->informasi_grup_usaha;

        $bwmk = LoanApplicant::with(['master_bpr'=> function($query) use ($informasi_grup_usaha){
            $query->where('informasi_grup_usaha', $informasi_grup_usaha);
        }])->sum('plafond');

        $grup_usaha_dua = DB::table('riwayat_pinjaman_grup_usaha')
        ->selectRaw('riwayat_pinjaman_grup_usaha.id, plafond, product_title as fasilitas, nama_perusahaan as nama_bpr, kol as kol_di_bank_jtrust')
        ->leftJoin('product_type', 'product_type.id', 'riwayat_pinjaman_grup_usaha.fasilitas')
        ->where('informasi_grup_usaha', $informasi_grup_usaha);

        $grup_usaha = DB::table('loan_applicants')
        ->selectRaw('loan_applicants.id, plafond, product_title as fasilitas, nama_bpr, kol_di_bank_jtrust')
        ->leftJoin('form_00', 'form_00.sandi_bpr', 'loan_applicants.sandi_bpr')
        ->leftJoin('product_type', 'product_type.id', 'loan_applicants.produk_id')
        ->where('informasi_grup_usaha', $informasi_grup_usaha)
        ->where('loan_applicants.id', '<>', $id)
        ->unionAll($grup_usaha_dua)
        ->get();

        // financial highlight
        $fh_berjalan = InputFinancialHighlight::cari_max($data_header->sandi_bpr,'sub_jenis', 'OJK Publikasi');
        $bulan_berjalan = ($fh_berjalan == null) ? date('m') : $fh_berjalan->bulan;
        $tahun_berjalan = ($fh_berjalan == null) ? date('Y') : $fh_berjalan->tahun;

        $desember_akhir = InputFinancialHighlight::cari_max($data_header->sandi_bpr, 'sub_jenis', 'Audit');
        $tahun_max_rkat = InputFinancialHighlight::cari_max($data_header->sandi_bpr, 'sub_jenis', 'Disampaikan ke OJK');

        $tahun_ini = $desember_akhir->tahun ?? date('Y')-1;
        $tahun_max_rkat = $tahun_max_rkat->tahun ?? '';
        $tahun_rkat_sebelumnya = ($tahun_max_rkat == null) ? '' : $tahun_max_rkat - 1;

        $keterangan = DB::table('input_financial_highlight')->selectRaw('distinct(keterangan) as keterangan')->where('sandi_bpr', $data_header->sandi_bpr)->get();
   
        $nominal = [
            'ojk_publikasi'=>InputFinancialHighlight::laporan($bulan_berjalan, $tahun_berjalan, 'Realisasi', 'OJK Publikasi'),
            'audit_satu'=>InputFinancialHighlight::laporan(12, $tahun_ini, 'Realisasi', 'Audit'),
            'audit_dua'=>InputFinancialHighlight::laporan(12, $tahun_ini-1, 'Realisasi', 'Audit'),
            'audit_tiga'=>InputFinancialHighlight::laporan(12, $tahun_ini-2, 'Realisasi', 'Audit'),
            'rkat'=>InputFinancialHighlight::laporan(12, $tahun_berjalan, 'RKAT', 'Disampaikan ke OJK'),
            'rkat_tahun_depan'=>InputFinancialHighlight::laporan(12, $tahun_berjalan, 'RKAT', 'Disampaikan ke OJK')
        ];

        $pdf = PDF::loadview('nak/print', [
            'data_header'=>$data_header,
            'tanggal'=>$tanggal,
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'tanggal'=>$tanggal,
            'departemenHead'=>$departemenHead,
            'departemenHeadAtasan'=>$departemenHeadAtasan,
            'divisionHead'=>$divisionHead,
            'relationshipManager'=>$relationshipManager,

            // Informasi debitur
            'data_informasi_debitur'=>$data_informasi_debitur,
            'keteranganBpr'=>$keteranganBpr,
            'pemegangSaham'=>$pemegangSaham,

            // Informasi Pokok Bpr Pelapor
            'informasiPokokBprPelapor'=>$informasiPokokBprPelapor,

            // Financial Highlight
            'ikhtisarLaporanKeuangan'=>$ikhtisarLaporanKeuangan,
            'dataa'=>$keterangan,
            'tahun_ini'=>$tahun_ini,
            'fh_berjalan'=>$fh_berjalan,
            'bulan_berjalan'=>$bulan_berjalan,
            'tahun_max_rkat'=>$tahun_max_rkat,
            'tahun_rkat_sebelumnya'=>$tahun_rkat_sebelumnya,
            'nominal'=>$nominal,

            // Kondisi Keuangan Debitur
            'kondisiKeuanganDebitur'=>KondisiKeuanganDebitur::where('sandi_bpr', $sandi_bpr)->toBase()->first(),
            'daftarPinjamanYangDiterima'=>DB::table('form_007')->where('sandi_bpr', $data_header->sandi_bpr)->get(),

            // Prospek Kinerja Usaha
            'prospekDanKinerjaUsaha'=>ProspekDanKinerjaUsaha::where('loan_applicant_id', $id)->first(),
            // Kegiatan Usaha
            'kegiatanUsaha'=>KegiatanUsaha::where('loan_applicant_id', $id)->first(),
            // Manajemen Perusahaan
            'manajemenPerusahaan'=>DB::table('form_002')->where('sandi_bpr', $sandi_bpr)->get(),
            // Pemasaran
            'pemasaran'=>Pemasaran::where('loan_applicant_id', $id)->toBase()->first(),
            // Perhitungan Kebutuhan Kredit
            'perhitunganKebutuhanKredit'=>PerhitunganKebutuhanKredit::where('loan_applicant_id', $id)->toBase()->first(),
            // Legalitas
            'legalitas'=>Legalitas::where('loan_applicant_id', $id)->toBase()->first(),
            // Resume Hasil Observasi
            'resumeHasilObservasi'=>ResumeHasilObservasi::where('loan_applicant_id', $id)->toBase()->first(),
            //Agunan
            'agunan'=>Agunan::where('sandi_bpr', $sandi_bpr)->toBase()->get(),
            // Kepatuhan
            'kepatuhan'=>Kepatuhan::where('loan_applicant_id', $id)->toBase()->first(),
            // Usulan Kredit
            'usulanKredit'=>UsulanKredit::where('loan_applicant_id', $id)->toBase()->first(),
            // Disclaimer
            'disclaimer'=>Disclaimer::where('sandi_bpr', $sandi_bpr)->toBase()->first(),

            // Deviasi
            'deviasi'=>DB::table('deviasi')->where('sandi_bpr', $sandi_bpr)->get(),
            'bwmk'=>$bwmk,
            'info_grup_usaha'=>DB::table('info_grup_usaha')->where('sandi_bpr', $sandi_bpr)->get(),
            'grup_usaha'=>$grup_usaha,
            'total_grup_usaha'=>$grup_usaha->count('id'),
            'plafond_debitur_grup_usaha'=>$grup_usaha->sum('plafond'),
            'bmpk'=>DB::table('bmpk')->where('sandi_bpr', $sandi_bpr)->first(),
            'fasilitas_debitur'=>DB::table('loan_applicants')->where('sandi_bpr', $data_header->sandi_bpr)->get()
        ])
        ->set_option('isRemoteEnabled', true);
      
        return $pdf->stream();
    }
}
