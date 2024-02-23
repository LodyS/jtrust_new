<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RegionListingController;
use App\Http\Controllers\ManajemenPertanyaanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JabatanBprController;
use App\Http\Controllers\JenisPengajuanController;
use App\Http\Controllers\InformasiGrupUsahaController;
use App\Http\Controllers\MasterJawabanPertanyaanController;
use App\Http\Controllers\SkemaKreditController;
use App\Http\Controllers\KomponenTksController;
use App\Http\Controllers\NilaiKomponenTksController;
use App\Http\Controllers\PredikatTksController;
use App\Http\Controllers\SettingFlowController;
use App\Http\Controllers\FasilitasKreditController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\BwmkController;
use App\Http\Controllers\BackupDatabaseController;
use App\Http\Controllers\RincianBprController;
use App\Http\Controllers\PihakTerkaitController;
use App\Http\Controllers\OrganBprController;
use App\Http\Controllers\DireksiBprController;
use App\Http\Controllers\PinjamanDiterimaController;
use App\Http\Controllers\KepemilikanBprController;

Route::controller(App\Http\Controllers\BerandaController::class)->group(function(){
    Route::get('/', 'index');
    Route::get('home', 'home'); 
    Route::get('/migrate', 'migrate');
    Route::get('/clear-cache', 'clear');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => ['superadmin']], function () {
        Route::resource('list-user', UserController::class)->except(['show']);
        Route::post('update-status-user', [UserController::class, 'updateStatusUser']);
        // Product
        Route::resource('product', ProductController::class)->except(['show']);
        Route::resource('coa', CoaController::class)->except(['destroy', 'show']);
        Route::resource('branch', BranchController::class)->except(['show']);
        Route::resource('region', RegionListingController::class)->except(['show']);
        Route::resource('manajemen-pertanyaan', ManajemenPertanyaanController::class)->except(['show']);
        Route::resource('jabatan', JabatanController::class);
        Route::resource('jabatan-bpr', JabatanBprController::class);
        Route::resource('jenis-pengajuan', JenisPengajuanController::class);
        Route::resource('informasi-grup-usaha', InformasiGrupUsahaController::class);
        Route::resource('master-jawaban-pertanyaan', MasterJawabanPertanyaanController::class)->except(['show']);
        Route::resource('skema-kredit', SkemaKreditController::class)->except(['show']);
        Route::resource('komponen-tks', KomponenTksController::class)->except(['show']);
        Route::resource('nilai-komponen-tks', NilaiKomponenTksController::class)->except(['show']);
        Route::resource('predikat-tks', PredikatTksController::class)->except(['show']);
        Route::resource('setting-flow', SettingFlowController::class)->except(['show', 'destroy']);
        Route::resource('fasilitas-kredit', FasilitasKreditController::class)->except(['show']);
        Route::resource('logs', LogController::class);
        Route::resource('bwmk', BwmkController::class);

        Route::controller(BackupDatabaseController::class)->group(function(){
            Route::get('backup-database', 'index');
            Route::get('do-backup-database', 'backup');
            Route::post('download-backup-db', 'download'); 
        });
    });

    Route::controller(App\Http\Controllers\LaporanLabaRugiController::class)->group(function(){
        Route::get('detail-laporan-laba-rugi/{sandi_bpr}', 'report');
        Route::post('cari-detail-laporan-laba-rugi', 'report');
    }); // laporan laba rugi
  
    Route::controller(App\Http\Controllers\LaporanPosisiKeuangan::class)->group(function(){
        Route::get('detail-laporan-posisi-keuangan/{sandi_bpr}', 'report');
        Route::post('cari-detail-laporan-posisi-keuangan', 'report');
    }); // laporan posisi keuangan table atau trial

    Route::controller(App\Http\Controllers\LaporanAsetProduktif::class)->group(function(){
        Route::get('detail-laporan-aset-produktif/{sandi_bpr}', 'report');
        Route::post('cari-detail-laporan-aset-produktif', 'report');
    }); // laporan aset produktif index
   
    Route::get('kepemilikan-bpr/{id}', [App\Http\Controllers\KepemilikanBprController::class, 'index']); //form01
    Route::get('anggota-direksi-komisaris/{id}', [App\Http\Controllers\DireksiBprController::class, 'index']); //form02
    Route::get('organ-pelaksana-bpr/{id}', [App\Http\Controllers\OrganBprController::class, 'index']); //form03
    Route::get('slik/{id}', [App\Http\Controllers\PinjamanDiterimaController::class, 'index']); //form07
    
    Route::group(['middleware' => ['business-division']], function () {
        Route::get('list-data-bpr', [App\Http\Controllers\MasterDataBprController::class, 'index']);
    }); // master data bpr

    Route::group(['middleware' => ['ao']], function () {
        Route::controller(App\Http\Controllers\MasterDataBprController::class)->group(function(){ 
            Route::get('form-data-bpr', 'create');
            Route::post('master-data-bpr-store', 'store');
            Route::get('edit-list-bpr/{id}', 'edit');
        });

        Route::get('rincian-kantor-bpr/{id}', [RincianBprController::class, 'eindex']); //form04
        Route::get('pihak-terkait-bpr/{id}', [PihakTerkaitController::class,'index']); //form05

        Route::resource('organ-pelaksana-bpr', OrganBprController::class)->except(['index']);
        Route::resource('rincian-kantor-bpr', RincianBprController::class)->except(['index']);
        Route::resource('pihak-terkait-bpr', PihakTerkaitController::class)->except('index');
        Route::resource('anggota-direksi-komisaris', DireksiBprController::class)->except(['index']);
        Route::resource('slik', PinjamanDiterimaController::class)->except(['index']);
        Route::resource('kepemilikan-bpr', KepemilikanBprController::class)->except(['index']);

        Route::controller(App\Http\Controllers\SlikTxtController::class)->group(function(){ 
            Route::get('import-slik-txt/{id}', 'create');
            Route::post('upload-slik-txt', 'store');
        }); // import slik txt

        Route::controller(App\Http\Controllers\HeaderController::class)->group(function(){ 
            Route::get('header/{sandi_bpr}', 'index');
            Route::get('edit-header/{id}', 'edit');
            Route::post('update-header-import', 'update');
        });
    
        Route::controller(App\Http\Controllers\DataApplicantController::class)->group(function(){ 
            Route::get('tambah-pengajuan-pinjaman', 'create');
            Route::post('simpan-pengajuan-pinjaman', 'store');
            Route::get('edit-pengajuan-pinjaman/{id}', 'edit');
            Route::post('update-pengajuan-pinjaman', 'update');
            Route::get('delete-pengajuan-pinjaman', 'delete')->name('delete-pengajuan-pinjaman');
            Route::post('destroy-pengajuan-pinjaman', 'destroy')->name('destroy-pengajuan-pinjaman');
            Route::get('perpanjangan-pinjaman/{id}', 'perpanjangan');
            Route::get('edit-perpanjangan-pinjaman/{id}', 'editPerpanjangan');
            Route::post('simpan-perpanjangan-pinjaman', 'simpanPerpanjangan');
            Route::post('update-perpanjangan-pinjaman', 'updatePerpanjangan');
        }); // data applicant ataau loan application
        
        Route::controller(App\Http\Controllers\LaporanPosisiKeuanganController::class)->group(function(){
            Route::get('import-laporan-posisi-keuangan/{sandi_bpr}', 'import');
            Route::post('import-laporan-posisi-keuangan', 'store');
        }); // laporan posisi keuangan

        Route::controller(App\Http\Controllers\LaporanLabaRugiController::class)->group(function(){
            Route::get('import-laporan-laba-rugi/{sandi_bpr}', 'import');
            Route::post('import-laporan-laba-rugi', 'store');
        }); // laporan laba rugi
    
        Route::controller(App\Http\Controllers\LaporanAsetProduktifController::class)->group(function(){
            Route::get('import-laporan-aset-produktif/{sandi_bpr}', 'index');
            Route::post('import-laporan-aset-produktif', 'store');
        }); // laporan aset produktif
               
        Route::controller(App\Http\Controllers\JawabanPertanyaanBprController::class)->group(function(){
            Route::get('jawaban-pertanyaan-bpr/{sandi_bpr}', 'index');
            Route::get('jawaban-pertanyaan-bpr-create/{sandi_bpr}', 'create');
            Route::get('jawaban-pertanyaan-bpr-edit/{sandi_bpr}/{review_date_month}/{review_date_year}', 'edit');
            Route::post('jawaban-pertanyaan-bpr-store', 'store');
            Route::post('jawaban-pertanyaan-bpr-update', 'update');
            Route::post('jawaban-pertanyaan-bpr-delete', 'destroy');
        }); // jawaban pertanyaan bpr
    });

    Route::controller(App\Http\Controllers\MasterDataBprController::class)->group(function(){
        Route::post('master-data-bpr-update', 'update');
        Route::get('edit-manajemen', 'editManajemen')->name('edit-manajemen');
        Route::post('/update-manajemen', 'updateManajemen')->name('update-manajemen');
        Route::post('hapus-list-bpr', 'destroy');
    });
    
    Route::controller(App\Http\Controllers\HistoriRatioController::class)->group(function(){
        Route::get('histori-ratio/{sandi_bpr}', 'index');
        Route::post('cari-histori-ratio', 'index');
    }); // Histori Ratio

    Route::controller(App\Http\Controllers\TingkatKesehatanBankController::class)->group(function(){
        Route::get('tingkat-kesehatan-bank/{sandi_bpr}', 'index');
        Route::post('tingkat-kesehatan-bank-search', 'index');
    });  // Tingkat Kesehatan Bank
    
    Route::controller(App\Http\Controllers\NakInformasiDebiturController::class)->group(function(){
        Route::get('nak-informasi-debitur/{id}', 'index');
        Route::post('update-informasi-debitur', 'store');
    });

    Route::controller(App\Http\Controllers\FasilitasDebiturController::class)->group(function(){
        Route::get('nak-fasilitas-debitur/{id}', 'index');
        Route::post('simpan-fasilitas-debitur', 'store');
    });

    Route::controller(App\Http\Controllers\NakFinancialHiglightController::class)->group(function(){
        Route::get('nak-financial-highlight/{id}', 'index');
        Route::post('update-nak-financial-highlight', 'store');
    });

    Route::controller(App\Http\Controllers\ManajemenPerusahaanController::class)->group(function(){
        Route::get('nak-manajemen-perusahaan/{id}', 'index');
        Route::post('save-manajemen-perusahaan', 'store');
    });

    Route::controller(App\Http\Controllers\NakAgunanController::class)->group(function(){
        Route::get('nak-agunan/{id}', 'index');
        Route::post('save-agunan', 'store');
    });

    Route::controller(App\Http\Controllers\NakDeviasiController::class)->group(function(){
        Route::get('nak-deviasi/{id}', 'index');
        Route::get('edit-deviasi/{id}/{nak_id}', 'edit');
        Route::post('save-deviasi', 'save');
        Route::post('update-deviasi', 'update');
        Route::post('destroy-deviasi', 'destroy');
    });

    Route::controller(App\Http\Controllers\NakController::class)->group(function(){
        Route::get('nak/{id}', 'index');
        Route::post('update-main-page', 'updateMainPage')->name('update-main-page');
        Route::get('nak-permohonan-debitur/{id}', 'permohonanDebitur');
        Route::post('update-permohonan-debitur', 'updatePermohonanDebitur');
        Route::get('nak-informasi-group/{id}', 'informasiGroupUsaha');
        Route::post('update-informasi-group', 'updateInformasiGroupUsaha');
        Route::get('nak-kondisi-keuangan-debitur/{id}', 'kondisiKeuanganDebitur');
        Route::post('save-kondisi-keuangan-debitur', 'saveKondisiKeuanganDebitur');
        Route::get('nak-prospek-dan-kinerja-usaha/{id}', 'prospekDanKinerjaUsaha');
        Route::post('save-prospek-dan-kinerja-usaha', 'saveProspekDanKinerjaUsaha');
        Route::get('nak-kegiatan-usaha/{id}', 'kegiatanUsaha');
        Route::post('save-kegiatan-usaha', 'saveKegiatanUsaha');
        Route::get('nak-pemasaran/{id}', 'pemasaran');
        Route::post('save-pemasaran', 'savePemasaran');
        Route::get('nak-perhitungan-kredit/{id}', 'perhitunganKebutuhanKredit');
        Route::post('save-perhitungan-kredit', 'savePerhitunganKebutuhanKredit');
        Route::get('nak-legalitas/{id}', 'legalitas');
        Route::post('save-legalitas', 'saveLegalitas');
        Route::get('nak-resume-hasil-observasi/{id}', 'resumeHasilObservasi');
        Route::post('save-resume-hasil-observasi', 'saveResumeHasilObservasi');
        Route::get('nak-kepatuhan/{id}', 'kepatuhan');
        Route::post('save-kepatuhan', 'saveKepatuhan');
        Route::get('nak-usulan-kredit/{id}', 'usulanKredit');
        Route::post('save-usulan-kredit', 'saveUsulanKredit');
        Route::get('nak-disclaimer/{id}', 'disclaimer');
        Route::post('save-disclaimer', 'saveDisclaimer');
        Route::get('nak-proses-bussiness-unit/{id}', 'bussinessUnitProses');
        Route::post('nak-proses-bussiness-unit', 'prosesBussinessUnit');
        Route::get('nak-proses-corporate-legal-officer/{id}', 'corporateLegalOfficerProses');
        Route::post('nak-proses-corporate-legal-officer', 'prosesCorporateLegalOfficer');
        Route::get('nak-proses-credit-administration/{id}', 'creditAdministrationProses');
        Route::post('nak-proses-credit-administration', 'prosesCreditAdministration');
        Route::get('nak-proses-compliance/{id}', 'complianceProses');
        Route::post('nak-proses-compliance', 'prosesCompliance');
        Route::get('nak-credit-risk-reviewer/{id}', 'crrdProses');
        Route::post('nak-credit-risk-reviewer', 'prosesCrrd');
    }); // NAK

    Route::get('nak-print/{id}', [App\Http\Controllers\NakPrintController::class, 'index']);     // Print NAK
    Route::group(['middleware' => ['user_proses']], function () {
        Route::controller(App\Http\Controllers\ProsesWorkFlowController::class)->group(function(){
            Route::get('proses-workflow', 'index');
            Route::get('proses-workflow/{id}', 'show');
            Route::get('informasi-workflow/{id}', 'detail');
            Route::post('proses-workflow', 'store');  
        });
    });

    Route::controller(App\Http\Controllers\OpiniController::class)->group(function(){
        Route::get('cad-opini/{id}', 'ca');
        Route::get('compliance-opini/{id}', 'compliance');
        Route::get('legal-opini/{id}', 'legal');
        Route::post('lembar-opini-legal', 'storeLegal');
        Route::post('lembar-opini-compliance', 'storeCompliance');
        Route::post('lembar-opini-cad', 'storeCad');
    });

    Route::controller(App\Http\Controllers\OpiniPrintController::class)->group(function(){
        Route::get('print-opini-credit-administration/{id}', 'ca');
        Route::get('print-opini-legal/{id}', 'legal');
        Route::get('print-opini-compliance/{id}', 'compliance');
    });   // Print Dokumen

    Route::controller(App\Http\Controllers\ArrController::class)->group(function(){
        Route::get('arr/{id}', 'index');
        Route::get('arr-rekomendasi/{id}', 'rekomendasi');
        Route::post('arr-rekomendasi', 'storeRekomendasi');
        Route::get('informasi-debitur-dan-group/{id}', 'informasiDebiturDanGroup');
        Route::post('store-loan-applicant', 'storeLoanApplicant');
        Route::get('key-risk-issue/{id}', 'keyRiskIssue');
        Route::post('store-key-risk-issue', 'storeKeyRiskIssue');
        Route::post('tambah-pertanyaan-key-risk-issue', 'tambahKeyRiskIssue');
        Route::get('covenant-checklist/{id}', 'covenantCheckList');
        Route::post('store-covenant-checklist', 'storeCovenantCheckList');
        Route::get('catatan-penting-lainnya/{id}', 'catatanPentingLainnya');
        Route::post('store-catatan-penting-lainnya', 'storeCatatanPentingLainnya');
        Route::get('arr-financial-higlight/{id}', 'financialHiglight');
        Route::post('store-arr-financial-higlight', 'storeFinancialHighlight');
        Route::get('informasi-fasilitas-kredit-debitur-dan-group/{id}', 'informasiFasilitasKreditDebiturGroup');
        Route::get('arr-print/{id}', 'print');
    });  // ARR

    Route::controller(App\Http\Controllers\DocumentBprController::class)->group(function(){
        Route::get('upload-documents-bpr/{sandi_bpr}', 'index'); //documents
        Route::post('save-upload-document', 'store');
    }); // Document
    
    Route::controller(App\Http\Controllers\ShortNakController::class)->group(function(){
        Route::get('short-nak/{id}', 'index');
        Route::get('short-nak-informasi-debitur/{id}', 'informasiDebitur');
        Route::get('short-nak-latar-belakang/{id}', 'latarBelakang');
        Route::get('short-nak-pembahasan/{id}', 'pembahasan');
        Route::get('short-nak-usulan/{id}', 'usulan');
        Route::get('short-nak-disclaimer/{id}', 'disclaimer');
        Route::post('update-loan-applicant', 'updateLoanApplicant');
        Route::post('update-short-nak', 'update');
        Route::get('short-nak-print/{id}', 'print');
    });   // Short NAK
   
    Route::controller(App\Http\Controllers\LembarKeputusanKreditController::class)->group(function(){
        Route::get('lembar-keputusan-kredit-header/{id}', 'index');
        Route::post('lembar-keputusan-kredit-header', 'storeHeader');
        Route::get('lembar-keputusan-kredit-fasilitas-kredit/{id}', 'fasilitasKredit');
        Route::get('lembar-keputusan-kredit-agunan-fasilitas-kredit/{id}', 'agunanFasilitasKredit');
        Route::get('syarat-dan-kondisi-penyediaan-fasilitas/{id}', 'syaratKondisiFasilitasKredit');
        Route::post('store-syarat-dan-kondisi-penyediaan-fasilitas', 'storeSyaratKondisiFasilitasKredit');
        Route::get('persetujuan-khusus-dan-deviasi/{id}', 'persetujuanKhususDeviasi');
        Route::post('persetujuan-khusus-dan-deviasi', 'storePersetujuanKhususDeviasi');
        Route::get('usulan-dan-persetujuan-kredit/{id}', 'usulanPersetujuanKredit');
        Route::post('usulan-dan-persetujuan-kredit', 'storeUsulanPersetujuanKredit');
        Route::get('lembar-keputusan-kredit-print/{id}', 'print');
    }); // Lembar Keputusan Kredit
  
    Route::controller(App\Http\Controllers\FiduciaController::class)->group(function(){
        Route::get('fiducia/{id}', 'index');
        Route::post('store-fiducia', 'store');
    });   // Fiducia

    Route::controller(App\Http\Controllers\LaporanNeracaBulananController::class)->group(function(){
        Route::get('laporan-keuangan-bulanan/{sandi_bpr}', 'index');
        Route::post('simpan-laporan-neraca', 'store');
        Route::get('cari-laporan-keuangan-bulanan/{sandi_bpr}', 'search');
        Route::post('search-laporan-keuangan-bulanan', 'search');
        Route::post('update-laporan-keuangan-bulanan', 'update');
    });  // Laporan Bulanan

    Route::controller(App\Http\Controllers\LaporanLabaRugiBulananController::class)->group(function(){
        Route::get('laporan-bulanan-laba-rugi/{sandi_bpr}', 'index');
        Route::post('simpan-laporan-laba-rugi', 'store');
        Route::get('cari-laporan-laba-rugi/{sandi_bpr}', 'search');
        Route::post('search-laporan-laba-rugi', 'search');
        Route::post('update-laporan-laba-rugi', 'update');
    }); /* Laporan Laba Rugi */
  
    Route::controller(App\Http\Controllers\RekeningAdministratifBulananController::class)->group(function(){
        Route::get('rekening-administratif/{sandi_bpr}', 'index');
        Route::post('rekening-administratif-store', 'store');
        Route::get('cari-rekening-administratif/{sandi_bpr}', 'cari');
        Route::post('search-rekening-administratif', 'cari');
        Route::post('update-rekening-administratif', 'update');
    }); // rekening administratif
  
    Route::controller(App\Http\Controllers\InputProfilBulananController::class)->group(function(){
        Route::get('input-profil/{sandi_bpr}', 'index');
        Route::post('store-input-profil', 'store');
        Route::get('cari-input-profil/{sandi_bpr}', 'cari');
        Route::post('search-input-profil', 'cari');
        Route::post('update-input-profil', 'update');
    }); // input profil

    Route::controller(App\Http\Controllers\LaporanKeuanganBulananController::class)->group(function(){
        Route::get('input-financial-highlight/{sandi_bpr}', 'financialHiglight');
        Route::post('cari-financial-highlight', 'cari');
        Route::post('store-input-financial-highlight', 'store');
        Route::get('edit-financial-highlight/{sandi_bpr}', 'edit');
        Route::get('aksi-financial-highlight/{sandi_bpr}', 'edit');
        Route::post('aksi-financial-highlight', 'edit');
        Route::post('update-financial-highlight', 'update');
    }); // Input financial Highlight

    Route::controller(App\Http\Controllers\SpreadSheetController::class)->group(function(){
        Route::get('ppap/{sandi_bpr}', 'ppap');
        Route::post('cari-ppap', 'ppap');
    }); // PPAP

    Route::controller(App\Http\Controllers\AtmrController::class)->group(function(){
        Route::get('atmr/{sandi_bpr}', 'index');
        Route::post('cari-atmr', 'show');
        Route::post('store-atmr', 'store');
    });

    Route::controller(App\Http\Controllers\KpmmController::class)->group(function(){
        Route::get('kpmm/{sandi_bpr}', 'index');
        Route::post('cari-kpmm', 'index');
    });

    Route::controller(App\Http\Controllers\RasioController::class)->group(function(){
        Route::get('rasio/{sandi_bpr}', 'index');
        Route::post('cari-rasio', 'index');
        Route::post('simpan-rasio', 'store');
    });
   
    Route::controller(App\Http\Controllers\KertasKerjaScreeningCaDebController::class)->group(function(){
        Route::get('kertas-kerja-screening-calon-debitur/{sandi_bpr}', 'index');
        Route::get('print-kertas-kerja-screening-calon-debitur/{sandi_bpr}', 'print');
        Route::post('kertas-kerja-screening-cadeb-store', 'store');
    });  // kertas kerja screening calon debitur
        
    Route::get('publikasi-ojk/{sandi_bpr}', [App\Http\Controllers\FinancialHighlightController::class, 'index']);    // Publikasi OJK
    Route::controller(App\Http\Controllers\NakController::class)->group(function(){
        Route::get('edit-bmpk/{id}/{loan_applicant}', 'editBmpk');
        Route::post('update-bmpk', 'updateBmpk');
        Route::post('destroy-bmpk', 'destroyBmpk');
    }); // BMPK
});
