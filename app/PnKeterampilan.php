<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnKeterampilan extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pn_keterampilan";
    protected $primaryKey = 'id_pn_keterampilan';
    protected $guarded = [];

    public function Pegetahuan()
    {
        return $this->belongsTo('App\KompetensiDasar', 'kode_kd', 'kode_kd');
    }

    public function Keterampilan()
    {
        return $this->belongsTo('App\KompetensiDasar', 'kode_kd', 'kode_kd');
    }

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
        return $this->hasOne('App\Semester', 'id', 'id_semster');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function KD()
    {
        return $this->hasOne('App\KompetensiDasar', 'kode_kd', 'kode_kd');
    }
}
