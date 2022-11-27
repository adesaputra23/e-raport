<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KKM extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_kkm";
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Semester()
    {
        return $this->hasOne('App\Semester', 'id', 'id_semester');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }
}
