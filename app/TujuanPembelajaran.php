<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TujuanPembelajaran extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_tujuan_plj";
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function MateriPembelajaran()
    {
        return $this->hasOne('App\MateriPembelajaran', 'kode_materi', 'kode_materi');
    }

    public function TujuanPembelajaran()
    {
        return $this->belongsTo('App\MateriPembelajaran', 'kode_materi', 'kode_materi');
    }

    public function PnFmSm()
    {
        return $this->hasOne('App\PnSmFm', 'kode_tujuan', 'kode_tujuan');
    }

    public function Semester()
    {
        return $this->hasOne('App\Semester', 'id', 'id_semester');
    }

    public static function GetKodeMTByKodeTujuan($kode_tujuan)
    {
        $getData = TujuanPembelajaran::where('kode_tujuan', '=', $kode_tujuan)
            ->with('MateriPembelajaran')
            ->first();
        return $getData;
    }
}
