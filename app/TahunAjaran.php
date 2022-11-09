<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_tahun_ajaran";
    protected $primaryKey = 'id_tahun_ajaran';
    protected $guarded = [];

    const MAP_STATUS = [
        1 => 'Aktif',
        2 => 'Tidak Aktif'
    ];

    const Aktif = 1;
    const Tidak_Aktif = 2;


    public static function GetAktiveTahunAjaran()
    {
        $tahun_ajaran = TahunAjaran::where('status_aktif', self::Aktif)->first();
        return $tahun_ajaran;
    }


}
