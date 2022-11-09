<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    protected $connection = 'mysql';
    public $timestamps = false;
    protected $table = "materi_pembelajaran";
    protected $primaryKey = 'kode_materi';
    protected $keyType = 'string';

    public function Mt()
    {
        return $this->hasOne('App\MataPelajaran', 'kode_mt', 'kode_mt');
    }

    public function Mat()
    {
        return $this->hasMany('App\MataPelajaran', 'kode_mt', 'kode_mt');
    }

    public function Smester()
    {
        return $this->hasOne('App\Semester', 'id', 'id_semester');
    }

    public function MateriPembelajaran()
    {
        return $this->belongsTo('App\MateriPembelajaran', 'kode_mt', 'kode_mt');
    }

    public function TujuanPembelajaran()
    {
        return $this->hasMany('App\TujuanPembelajaran', 'kode_materi', 'kode_materi')->where('id_semester', Semester::GetAktifSemester()->id);
    }
}
