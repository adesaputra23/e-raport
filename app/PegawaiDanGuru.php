<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PegawaiDanGuru extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pegawais_and_gurus_tabel";
    protected $primaryKey = 'id';
    protected $guarded = [];

    const MAP_JABATAN = [
        1 => 'Kepala Sekolah',
        2 => 'Guru',
        3 => 'Lain-Lain',
        4 => 'Petugas TU'
    ];

    const GURU = 2;

    const MAP_STATUS = [
        1 => 'PNS',
        2 => 'CPNS',
        3 => 'Honorer',
        4 => 'PPPK',
        5 => 'GTT',
        6 => 'Penjaga'
    ];

    public function User()
    {
        return $this->hasOne('App\User', 'user_code', 'nik');
    }
}
