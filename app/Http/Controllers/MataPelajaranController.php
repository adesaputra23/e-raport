<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\KKM;
use App\Kurikulum;
use App\MataPelajaran;
use App\PegawaiDanGuru;
use App\RoleUser;
use App\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Mata Pelajaran';
        $list_kkm = KKM::get();
        
        if (RoleUser::CheckRole()->user_role === RoleUser::Admin){
            $list_data = MataPelajaran::with('guru','kelas', 'kurikulum')->get();
        }elseif (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas) {
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $list_data = MataPelajaran::whereHas('kelas', function($q) use ($kelas) {
                $q->where('kode_kelas', $kelas->kode_kelas);
                $q->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
            })->with('guru', 'kurikulum')->get();
        }else {
            $list_data = [];
        }

        return view('mata_pelajaran.index', 
            compact(
                'title',
                'list_data',
                'list_kkm',
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
        $get_mata_pelajaran = MataPelajaran::where('id', $id)->first();
        $list_guru = PegawaiDanGuru::where('jabatan', PegawaiDanGuru::GURU)->get();
        $list_kelas = Kelas::get();
        $list_kurikulum = Kurikulum::get();
        return view('mata_pelajaran.created_form',
            compact(
                'get_mata_pelajaran',
                'list_guru',
                'list_kelas',
                'list_kurikulum'
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
            $simpan_data = new MataPelajaran();
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = MataPelajaran::where('id', $request->id)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->kode_mt           = $request->kode_mt;
            $simpan_data->nama_mt           = $request->nama_mt;
            $simpan_data->desc_mt           = $request->desc_mt;
            $simpan_data->nik               = $request->guru;
            $simpan_data->kode_kelas        = $request->kelas;
            $simpan_data->kode_kurikulum    = $request->kurikulum;

            $simpan_data->save();
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('error', $th->getMessage());
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
            $deleted = MataPelajaran::find($id);
            $deleted->delete();
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function UbahKKM(Request $request)
    {
        try {
            $id = $request->id;
            $save_kkm = KKM::find($id);
            $save_kkm->nilai_kkm = $request->nilai_kkm;
            $save_kkm->desc_kkm = $request->desc_kkm;
            $save_kkm->updated_at = date('Y-m-d H:i:s');
            $save_kkm->save();
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('success', 'Berhasil ubah data');
        } catch (\Throwable $th) {
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('error', $th->getMessage());
        }
    }
}
