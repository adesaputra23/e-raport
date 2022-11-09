<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnSikap extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pn_sikap";
    protected $primaryKey = 'id_pn_sikap';
    protected $guarded = [];

    public function Siswa()
    {
        return $this->hasOne('App\Siswa', 'nisn', 'nisn');
    }

    public function Kelas()
    {
        return $this->hasOne('App\Kelas', 'kode_kelas', 'kode_kelas');
    }

    public function Semester()
    {
        return $this->hasOne('App\Semester', 'id', 'id_smester');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }
}
