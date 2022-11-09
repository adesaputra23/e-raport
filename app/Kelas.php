<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_kelas";
    protected $primaryKey = 'kode_kelas';
    protected $keyType = 'string';
    protected $guarded = [];

    public function CK_SiswaKelas()
    {
        return $this->hasMany('App\KelasSiswa', 'kode_kelas', 'kode_kelas');
    }

    public function Guru()
    {
        return $this->hasOne('App\PegawaiDanGuru', 'nik', 'nik');
    }

    public static function getbyId($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();
        return $kelas;
    }
}
