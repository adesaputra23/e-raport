<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnSaran extends Model
{   
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pn_saran";
    protected $primaryKey = 'id_pn_saran';
    protected $guarded = [];
}
