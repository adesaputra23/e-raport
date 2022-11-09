<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_kurikulum";
    protected $primaryKey = 'kode_kurikulum';
    protected $keyType = 'string';
    protected $guarded = [];

    const Status_Map = [
        1 => 'Aktif',
        2 => 'Tidak Aktif'
    ];

    const Aktif     = 1;
    const K13       = 'KR13';
    const Prototype = 'KR22';

    public static function GetAktiveKurikulum()
    {
        $kurikulum = Kurikulum::where('status_kurikulum', self::Aktif)->first();
        return $kurikulum;
    }
}
