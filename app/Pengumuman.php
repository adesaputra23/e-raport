<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_pengumuman";
    protected $primaryKey = 'id_pengumuman';
    protected $guarded = [];
}
