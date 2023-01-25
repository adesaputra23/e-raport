<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const SES_PREFIX  = 'prefix';
    const MAP_JENIS_KELAMIN = [
        1 => 'Laki-Laki',
        2 => 'Perempuan',
    ];
    const MAP_AGAMA = [
        0 => 'Islam',
        1 => 'Kristen Protestan',
        2 => 'Katolik',
        3 => 'Hindu',
        4 => 'Buddha',
        5 => 'Khonghucu',
    ];
    const MAP_PEKRJAAN = [
        0 => 'Pegawai Negeri',
        1 => 'Wiraswasta',
        2 => 'Tidak Bekerja',
        3 => 'Militer',
        4 => 'Pengawai Swasta',
        5 => 'Pensiun',
        6 => 'Petani',
    ];
    const MAP_PENDIDIKAN = [
        0 => 'Tidak Tamat SD',
        1 => 'Tamat SD',
        2 => 'Tamat SMP',
        3 => 'Tamat SMA',
        4 => 'Diploma',
        5 => 'Sarjana Muda',
        6 => 'Sarjana',
        7 => 'Profesi',
        8 => 'Profesional',
        9 => 'Pascasarjana',
        10 => 'Doktor',
    ];

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','user_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne('App\RoleUser', 'user_code', 'user_code');
    }

    public function roles()
    {
        return $this->hasMany('App\RoleUser', 'user_code', 'user_code');
    }

    public function PegawaiGuru()
    {
        return $this->hasOne('App\PegawaiDanGuru', 'nik', 'user_code');
    }

    public function Siswa()
    {
        return $this->hasOne('App\Siswa', 'nisn', 'user_code');
    }

    public static function GetNameUser($partial_menu, $data)
    {
        if ($partial_menu === 'pegawai') {
            $nama = PegawaiDanGuru::where('nik', $data)->first();
        }else{
            $nama = Siswa::where('nisn', $data)->first();
        }
        if (!empty($nama)) {
            return $nama->nama;
        }
        return 'ADMIN';
    }


}
