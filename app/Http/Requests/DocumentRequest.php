<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'surat_permohonan_debitur'=>'mimes:pdf',
            'company_profile'=>'mimes:pdf',
            'nomor_induk_berusaha'=>'mimes:pdf',
            'akte_pendirian'=>'mimes:pdf',
            'anggaran_dasar'=>'mimes:pdf',
            'akta_perubahan_badan_usaha'=>'mimes:pdf',
            'tanda_daftar_perusahaan'=>'mimes:pdf',
            'surat_ijin_usaha'=>'mimes:pdf',
            'sistem_layanan_informasi_kredit'=>'mimes:pdf',
            'daftar_hitam_nasional'=>'mimes:pdf',
            'laporan_kunjungan_usaha'=>'mimes:pdf',
            'laporan_keuangan_tiga_periode_terakhir'=>'mimes:pdf',
            'surat_perintah_kerja_kontrak_kerja_mou'=>'mimes:pdf',
            'laporan_trade_checking_serta_daftar_supplier'=>'mimes:pdf',
            'laporan_studi_kelayakan_proyek_feasibility_study_fs'=>'mimes:pdf',
            'laporan_progress_proyek_konstruksi'=>'mimes:pdf',
            'laporan_studi_kelayakan_proyek_feasibility_study_fs_dua'=>'mimes:pdf',
            'laporan_trade_checking_serta_daftar_supplier_dua'=>'mimes:pdf',
            'sandi_bpr'=>'string|required'
        ];
    }
}
