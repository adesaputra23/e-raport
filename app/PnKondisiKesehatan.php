<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnKondisiKesehatan extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pn_kondisi_kesehatan";
    protected $primaryKey = 'id_pn_kondisi_kesehatan';
    protected $guarded = [];
}
