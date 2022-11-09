<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/* 
    class model penilaian sumatif dan formatif
    dari tabel tabel_pn_fm_sm
*/
class PnSmFm extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_pn_fm_sm";
    protected $primaryKey = 'id_penilaian_fm_sm';
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
        return $this->hasOne('App\Semester', 'id', 'id_semester');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function MT()
    {
        return $this->hasOne('App\MataPelajaran', 'kode_mt', 'kode_mt');
    }

}
