<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_ekskul";
    protected $primaryKey = 'kode_ekskul';
    protected $keyType = 'string';
    protected $guarded = [];

    public function PnEkskul()
    {
        return $this->hasOne('App\PnEkskul', 'kode_ekskul', 'kode_ekskul');
    }

    public function TahunAjaran()
    {
        return $this->hasOne('App\TahunAjaran', 'id_tahun_ajaran', 'id_tahun_ajaran');
    }
}
