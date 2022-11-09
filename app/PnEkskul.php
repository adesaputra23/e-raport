<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnEkskul extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "pn_ekskul";
    protected $primaryKey = 'id_pn_ekskul';
    protected $guarded = [];

    public function Ekskul()
    {
        return $this->hasOne('App\Ekskul', 'kode_ekskul', 'kode_ekskul');
    }

}
