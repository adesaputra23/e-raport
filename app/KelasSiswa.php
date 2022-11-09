<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_siswa_kelas";
    protected $primaryKey = 'id_siswa_kelas';
    protected $guarded = [];

    public function CK_Kelas()
    {
        return $this->belongsTo('App\Kelas', 'kode_kelas', 'kode_kelas');
    }

    public function Siswa()
    {
        return $this->hasOne('App\Siswa', 'nisn', 'nisn');
    }

    public function Kelas()
    {
        return $this->hasOne('App\Kelas', 'kode_kelas', 'kode_kelas');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }
}
