<?php

namespace App\Http\Controllers;

use App\Ekskul;
use App\Kelas;
use App\Kurikulum;
use App\MataPelajaran;
use App\PegawaiDanGuru;
use App\Pengumuman;
use App\RoleUser;
use App\Semester;
use App\Siswa;
use App\TahunAjaran;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nik_wali_kelas = Auth::user()->user_code;
        $kelas = Kelas::where('nik', $nik_wali_kelas)->first();

        $tahun_ajaran = TahunAjaran::where('status_aktif', 1)->first();
        $kurikulum = Kurikulum::where('status_kurikulum', 1)->first();
        $semester = Semester::where('status_semester', 1)->first();
        $message_tahun_ajaran = 'Tahun ajaran '.$tahun_ajaran->tahun_ajaran;
        $message_kurikulum = $kurikulum->nama_kurikulum;
        $message_semester = 'Semester '.$semester->nama_smester;
        $list_kelas = Kelas::get();
        $count_kelas = [];
        $count_siswa = [];
        $count_mapel = []; 
        $count_tahun_ajaran = [];
        $count_ekskul = [];
        $count_mp_k13 = [];
        $count_mp_22 = [];
        $count_user = [];
        $count_guru_pegawai = [];
        $pengumumans = [];
        if (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas) {
            $count_siswa = Siswa::whereHas('sisiwakelas', function($q) use ($kelas)
                    {
                        $q->where('kode_kelas', $kelas->kode_kelas);
                        $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);  
                    })->count();
    
            $count_mapel = MataPelajaran::where('kode_kurikulum', $kurikulum->kode_kurikulum)->where('kode_kelas', $kelas->kode_kelas)->count();
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::Admin){
            $count_siswa = Siswa::count();
            $count_kelas = Kelas::count();
            $count_tahun_ajaran = TahunAjaran::count();
            $count_ekskul = Ekskul::count();
            $count_mp_k13 = MataPelajaran::where('kode_kurikulum', Kurikulum::K13)->count();
            $count_mp_22 = MataPelajaran::where('kode_kurikulum', Kurikulum::Prototype)->count();
            $count_user = User::count();
            $count_guru_pegawai = PegawaiDanGuru::count();
        }elseif (RoleUser::CheckRole()->user_role === RoleUser::WaliMurid) {
            $pengumumans = Pengumuman::get();
        }

        return view('home',
            compact(
                'message_tahun_ajaran',
                'message_kurikulum',
                'message_semester',
                'list_kelas',
                'count_kelas',
                'count_siswa',
                'count_mapel',
                'count_tahun_ajaran',
                'count_ekskul',
                'count_mp_k13',
                'count_mp_22',
                'count_user',
                'count_guru_pegawai',
                'pengumumans'
            )
        );
    }

    public function LihatDataUser(Request $req)
    {
        // $list_pg = PegawaiDanGuru::

        $sidebar_partial = $req->menu;
        if ($sidebar_partial === 'pegawai') {
            $list_role = RoleUser::MAP_ROLE;
            $list_user = User::WhereHas('role', function ($queri)
            {return $queri->whereNotIn('user_role', [RoleUser::WaliMurid]);})->get();
        } else {
            $list_role = [];
            $list_user = User::WhereHas('role', function ($queri)
            {return $queri->where('user_role', RoleUser::WaliMurid);})->get();
        }

        // dd($list_user);

        return view('user/lihat_data',
            compact(
                'list_user', 
                'list_role',
                'sidebar_partial',
            )
        );
    }

    public function SaveRole(Request $req)
    {
        if ($req->ajax()) {
            $list_role = RoleUser::where('user_code', $req->user_code)->pluck('user_role');
            $data = [
                'data' => $list_role,
            ];
            return json_encode($data);
        }
        
        DB::beginTransaction();
        try {
            $get_role = RoleUser::where('user_code', $req->user_code)->get();
            if ($get_role !== null) {
                $get_role = RoleUser::where('user_code', $req->user_code)->delete();
            }
            foreach ($req->role as $key => $value) {
                $save_role = new RoleUser();
                $save_role->user_code = $req->user_code;
                $save_role->user_role = $value;
                $save_role->created_at = date('Y-m-d H:i:s');
                $save_role->save();
            }
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil simpan role');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

    }


}
