<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpiniCad extends Model
{
    protected $table = 'opini_cad';
    protected $fillable = [
        'penjelasan_mitigasi',
        'catatan',
        'section_head',
        'division_head',
        'loan_applicant_id',
        'rekomendasi',
        'penjelasan_agunan_fixed_asset',
        'fixed_asset_non_marketable',
        'opini',
        'status'
    ];

    public function set_fixed_asset_non_marketable_attribute($value)
    {
        $this->attributes['fixed_asset_non_marketable'] = json_encode($value);
    }

    public static function rekomendasi($rekomendasi)
    {
        switch($rekomendasi):
            case 'Low':
                echo 'Resiko Operasional dan Administrasi pinjaman rendah & kondisi agunan sesuai dengan ketentutan, Dapat diproses lanjut';
                break;
            case 'Medium':
                echo 'Resiko Operasional dan Administrasi pinjaman sedang & kondisi agunan tidak seluruhnya memenuhi ketentutan,
                perlu ada mitigasi yang komprehensif';
                break;
            case 'High':
                echo 'Resiko Operasional dan Administrasi pinjaman tinggi & kondisi agunan tidak seluruhnya memenuhi ketentutan,
                sebaiknya tidak dilanjutkan kecuali ada informasi baru yang berbeda dan/atau mendukung';
                break;
            default:
                echo '';
        endswitch;

        return $rekomendasi;
    }
}
