<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KKM extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_kkm";
    protected $primaryKey = 'id';
    protected $guarded = [];
}
