<?php

namespace App\Models;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'jabatan', 'atasan_id', 'status', 'kode_rm', 'divisi', 'relationship_manager'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function storeUser ($req)
    {
        $save = $this->create($req);

        return $save;
    }

    public static function username($id)
    {
        $data = User::where('id', $id)->first();

        return $data;
    }

    public static function atasan($id_user)
    {
        $data = DB::table('users')
        ->leftJoin('users as bawahan', 'bawahan.atasan_id', 'users.id')
        ->where('users.jabatan', 'Business Division Head')
        ->where('users.id', $id_user)
        ->value('bawahan.id');

        return $data;
    }

    public static function depHead($id_user)
    {
        $bawahan = DB::table('users')->where('id', $id_user)->value('atasan_id');

        $data = DB::table('users')
        ->where('jabatan', 'Account Officer Departemen Head')
        ->where('id', $bawahan)
        ->value('name');

        return $data;
    }

    public static function divHead($nama)
    {
        $atasan = DB::table('users')->where('name', $nama)->value('atasan_id');
        $data = DB::table('users')->where('id', $atasan)->value('name');

        return $data;
    }

    public function jabatan_user ()
    {
        return $this->hasOne('App\Models\Jabatan', 'id', 'jabatan');
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = Hash::make($value);
    }
}
