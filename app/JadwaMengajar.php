<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwaMengajar extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_jadwal_ngajar";
    protected $primaryKey = 'id_jadwal_ngajar';
    protected $guarded = [];

    public function Mapel()
    {
        return $this->hasOne('App\MataPelajaran', 'kode_mt', 'kode_mt');
    }

    public function Kurikulum()
    {
        return $this->hasOne('App\Kurikulum', 'kode_kurikulum', 'kode_kurikulum');
    }

    public function Kelas()
    {
        return $this->hasOne('App\Kelas', 'kode_kelas', 'kode_kelas');
    }

    public function Semester()
    {
        return $this->hasOne('App\Semester', 'id', 'id_semester');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

}
