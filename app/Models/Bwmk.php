<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Bwmk extends Model
{
    protected $table = 'bwmk';
    protected $fillable = ['karakter', 'nilai_kredit_minimum', 'nilai_kredit_maksimum', 'voting_member', 'non_voting_member'];
    protected $primaryKey = 'id';

    public function setNilaiKreditMinimumAttribute($value)
    {
        $this->attributes['nilai_kredit_minimum'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setNilaiKreditMaksimumAttribute($value)
    {
        $this->attributes['nilai_kredit_maksimum'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setVotingMemberAttribute($value)
    {
        $this->attributes['voting_member'] = json_encode($value);
    }

    public function getVotingMemberAttribute($value)
    {
        return $this->attributes['voting_member'] = json_decode($value);
    }

    public function setNonVotingMemberAttribute($value)
    {
        $this->attributes['non_voting_member'] = json_encode($value);
    }

    public function getNonVotingMemberAttribute($value)
    {
        return $this->attributes['non_voting_member'] = json_decode($value);
    }

    public static function statusBwmk ($plafond)
    {
        if($plafond):
            $data = DB::select("SELECT karakter as status FROM bwmk WHERE nilai_kredit_minimum <= $plafond;");
            $data = $data[0]->status;
        else:
            $data = 0;
        endif;

        return $data;
    }
}
