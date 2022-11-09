<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaliSiswa extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_wali_siswa";
    protected $primaryKey = 'id';
    protected $guarded = [];
}
