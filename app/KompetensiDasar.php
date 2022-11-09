<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KompetensiDasar extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_kompetensi_dasar";
    protected $primaryKey = 'kode_kd';
    protected $keyType = 'string';
    protected $guarded = [];


    public function Mt()
    {
        return $this->hasOne('App\MataPelajaran', 'kode_mt', 'kode_mt');
    }

    public function Smester()
    {
        return $this->hasOne('App\Semester', 'id', 'id_semester');
    }

    public function KD()
    {
        return $this->belongsTo('App\MataPelajaran', 'kode_mt', 'kode_mt');
    }

    public function Pegetahuan()
    {
        return $this->hasMany('App\PnPengetahuan', 'kode_kd', 'kode_kd');
    }

    public function Keterampilan()
    {
        return $this->hasMany('App\PnKeterampilan', 'kode_kd', 'kode_kd');
    }

    public static function getById($id)
    {
        return KompetensiDasar::find($id);
    }
}
