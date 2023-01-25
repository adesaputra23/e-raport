<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\KompetensiDasar;
use App\Kurikulum;
use App\MataPelajaran;
use App\RoleUser;
use App\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KompetensiDasarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (RoleUser::CheckRole()->user_role === RoleUser::Admin || RoleUser::CheckRole()->user_role === RoleUser::Operator){  
            $list_data  = KompetensiDasar::with('mt', 'smester')->get();
        }elseif (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas) {
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $get_kode_mt = MataPelajaran::where('kode_kelas', $kelas->kode_kelas)->pluck('kode_mt')->toArray();
            $list_data  = KompetensiDasar::with('mt', 'smester')->whereIn('kode_mt', $get_kode_mt)->get();
        }else{
            $list_data = [];
        }

        $title      = 'Kompetensi Dasar';
        return view('kompetensi_dasar.index',
            compact(
                'title',
                'list_data'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $get_kd = KompetensiDasar::where('kode_kd', $id)->first();
        
        if (RoleUser::CheckRole()->user_role === RoleUser::Admin || RoleUser::CheckRole()->user_role === RoleUser::Operator){
            $list_mt = MataPelajaran::with('kelas')->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum)->get();
        }elseif (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas) {
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $list_mt = MataPelajaran::with('kelas')
                ->whereHas('kelas', function($q) use ($kelas){
                    $q->where('kode_kelas', $kelas->kode_kelas);
                })
                ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum)->get();
        }else{
            $list_mt = [];
        }

        $list_semester = Semester::get();

        // $list_kelas = Kelas::get();
        return view('kompetensi_dasar.created_form',
            compact(
                'get_kd',
                'list_mt',
                'list_semester'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->action === 'tambah') {
            $simpan_data = new KompetensiDasar();
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = KompetensiDasar::where('kode_kd', $request->id)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->no_kd = $request->no_kd;
            $simpan_data->nama_kd       = $request->nama_kd;
            $simpan_data->kode_mt       = $request->kode_mt;
            $simpan_data->id_semester   = $request->smester;
            $simpan_data->type          = $request->type;
            $simpan_data->save();
            return redirect()->route('kompetensi.dasar.lihat.data.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('kompetensi.dasar.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleted = KompetensiDasar::find($id);
            $deleted->delete();
            return redirect()->route('kompetensi.dasar.lihat.data.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('kompetensi.dasar.lihat.data.admin')->with('error', $th->getMessage());
        }
    }
}
