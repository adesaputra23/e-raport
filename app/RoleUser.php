<?php

namespace App;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoleUser extends Model
{

    protected $connection = 'mysql';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "roles_tabel";
    protected $primaryKey = 'id';
    protected $guarded = [];

    // admin
    const Admin     = 1;
    // wali kelas
    const WaliKelas = 2;
    // guru mata pelajaran
    const GuruMP    = 3;
    // wali murid atau orang tua siswa
    const WaliMurid = 4;
    // guru ekstra kulikuler
    // const GuruEK    = 5;
    const KP    = 6;
    const Operator = 7;

    const MAP_ROLE = [
        1 => 'ADMINISTRATOR',
        2 => 'WALI KELAS',
        // 3 => 'GURU',
        4 => 'SISWA / WALI MURID',
        // 5 => 'GURU EKSTRA KULIKULER',
        6 => 'KEPALA SEKOLAH',
        7 => 'OPERATOR'
    ];

    public static function CheckRole()
    {
        $user_code = Auth::user()->user_code;
        if (Controller::isAdminPage() == false) {
            $role = RoleUser::where('user_code', $user_code)
                ->where('user_role', '!=', RoleUser::Admin)
                ->first();
        }else{
            $role = RoleUser::where('user_code', $user_code)
            ->where('user_role', '=', RoleUser::Admin)
            ->first();
        }
        return $role;
    }

    public static function GetRoles($data)
    {
        $roles = RoleUser::where('user_code', $data)->pluck('user_role');
        $array = [];
        foreach ($roles as $key => $value) {
            $role = "<span class='badge bg-primary'>".RoleUser::MAP_ROLE[$value]."</span>";
            array_push($array, $role);
        }
        $is_roles = implode(" ", $array);   
        if (empty($is_roles)) {
            $is_roles = "-";
        }
        return $is_roles;
    }

}
