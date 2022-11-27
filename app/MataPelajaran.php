<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_mata_pelajaran";
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Guru()
    {
        return $this->hasOne('App\PegawaiDanGuru', 'nik', 'nik');
    }

    public function Kelas()
    {
        return $this->hasOne('App\Kelas', 'kode_kelas', 'kode_kelas');
    }

    public function Kurikulum()
    {
        return $this->hasOne('App\Kurikulum', 'kode_kurikulum', 'kode_kurikulum');
    }

    public function KD()
    {
        return $this->hasMany('App\KompetensiDasar', 'kode_mt', 'kode_mt');
    }

    public function MateriPembelajaran()
    {
        return $this->hasMany('App\MateriPembelajaran', 'kode_mt', 'kode_mt')->where('id_semester', Semester::GetAktifSemester()->id);
    }

    public function MateriPembelajaran2()
    {
        return $this->hasOne('App\MateriPembelajaran', 'kode_mt', 'kode_mt')->where('id_semester', Semester::GetAktifSemester()->id);
    }

    public function Semester()
    {
        return $this->hasOne('App\Semester', 'id', 'id_semester');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public static function GetbyId($id)
    {
        return MataPelajaran::where('kode_mt', $id)->first();
    }

}
