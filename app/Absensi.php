<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_absensi";
    protected $primaryKey = 'id_absensi';
    protected $keyType = 'bigint';
    protected $guarded = [];

    public function Siswa()
    {
        return $this->hasOne('App\Siswa', 'nisn', 'nisn');
    }

}
