<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnPrestasi extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pn_prestasi";
    protected $primaryKey = 'id_pn_prestasi';
    protected $guarded = [];
}
