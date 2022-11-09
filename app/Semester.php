<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Semester extends Model
{
    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "tabel_semester";
    protected $primaryKey = 'id';
    protected $guarded = [];

    const MAP_STATUS = [
        1 => 'Aktif',
        2 => 'Tidak Aktif'
    ];

    const Aktif = 1;

    public static function GetAktifSemester()
    {
        $semester = Semester::where('status_semester', self::Aktif)->first();
        return $semester;
    }

    public static function getById($id)
    {
        Log::info($id);
        $semester = Semester::where('id', $id)->first();
        return $semester;
    }

}
