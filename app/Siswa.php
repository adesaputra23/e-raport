<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TahunAjaran;

class Siswa extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_siswa";
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function User()
    {
        return $this->hasOne('App\User', 'user_code', 'nisn');
    }

    public function SisiwaKelas()
    {
        return $this->hasOne('App\KelasSiswa', 'nisn', 'nisn');
    }

    public function SisiwaKelasByTahunAjaran()
    {
        return $this->hasOne('App\KelasSiswa', 'nisn', 'nisn')->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);
    }

    public function WaliSiswa()
    {
        return $this->hasOne('App\WaliSiswa', 'nisn', 'nisn');
    }

    public static function GetSiswaByNisn($nisn)
    {
        $siswa = Siswa::where('nisn', $nisn)->first();
        return $siswa;
    }

}
