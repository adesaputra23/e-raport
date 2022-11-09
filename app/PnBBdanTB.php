<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnBBdanTB extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pn_berat_dan_tinggi_badan";
    protected $primaryKey = 'id_pn_bb';
    protected $guarded = [];
}
