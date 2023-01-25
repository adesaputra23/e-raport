<?php

namespace App\Http\Controllers;

use App\JadwaMengajar;
use App\Kelas;
use App\KKM;
use App\Kurikulum;
use App\MataPelajaran;
use App\PegawaiDanGuru;
use App\RoleUser;
use App\Semester;
use App\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $list_semester = Semester::get();
        $list_tahun_ajaran = TahunAjaran::get();

        if (RoleUser::CheckRole()->user_role === RoleUser::Admin || RoleUser::CheckRole()->user_role === RoleUser::Operator){
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
                'list_semester',
                'list_tahun_ajaran'
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
        $list_semester = Semester::get();
        $list_tahun_ajaran = TahunAjaran::get();
        $list_kelas = Kelas::get();
        $list_kurikulum = Kurikulum::get();
        return view('mata_pelajaran.created_form',
            compact(
                'get_mata_pelajaran',
                'list_guru',
                'list_kelas',
                'list_kurikulum',
                'list_semester',
                'list_tahun_ajaran'
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
            $simpan_data->nilai_kkm         = $request->nilai_kkm ?? 0;
            $simpan_data->id_semester       = $request->semester;
            $simpan_data->id_tahun_ajaran   = $request->tahun_ajaran;
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
            $save_kkm->id_semester = $request->semester;
            $save_kkm->id_tahun_ajaran = $request->tahun_ajaran;
            $save_kkm->save();
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('success', 'Berhasil ubah data');
        } catch (\Throwable $th) {
            return redirect()->route('mata.pelajaran.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function jadwalNgajar()
    {
        $list_data = JadwaMengajar::get();
        return view('mata_pelajaran/jadwal_ngajar', compact('list_data'));
    }

    public function FormJadwalNgajar($id)
    {
        $jadwal_ngajar = JadwaMengajar::find($id);
        $title = 'Tambah';
        if (!empty($jadwal_ngajar)) {
            $title = 'Ubah';
        }
        $list_kurikulum = Kurikulum::get();
        $list_kelas = Kelas::get();
        $list_semester = Semester::get();
        $list_tahun_ajaran = TahunAjaran::get();
        return view('mata_pelajaran/form_jadwal_ngajar', compact('list_kurikulum', 'list_kelas', 'list_semester', 'list_tahun_ajaran', 'title', 'jadwal_ngajar'));
    }

    public function SaveJadwalNgajar(Request $request)
    {
        try {
            if ($request->action === 'tambah') {
                $new_jadwal = new JadwaMengajar();
                $message = 'Berhasil simpan data jadwal mengajar';
            }elseif ($request->action === 'ubah') {
                $new_jadwal = JadwaMengajar::find($request->id);
                $message = 'Berhasil ubah data jadwal mengajar';
            }
            $new_jadwal->kode_kurikulum = $request->kurikulum;
            $new_jadwal->kode_kelas = $request->kelas;
            $new_jadwal->kode_mt = $request->mata_pelajaran;
            $new_jadwal->jam_ngajar = $request->jam;
            $new_jadwal->id_semester = $request->semester;
            $new_jadwal->id_tahun_ajaran = $request->tahun_ajaran;
            $new_jadwal->save();
            return redirect()->route('mata.pelajaran.jadwal.ngajar')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('mata.pelajaran.jadwal.ngajar')->with('error', 'Error : '.$th->getMessage().' / '.$th->getLine());
        }
    }

    public function AjaxGetMapel(Request $request)
    {
        $kelas = $request->kelas;
        $kurikulum = $request->kurikulum;
        $list_mapel = MataPelajaran::where('kode_kurikulum', $kurikulum)->where('kode_kelas', $kelas)->get();
        return response()->json($list_mapel);
    }

    public function JadwalNgajarDelete($id)
    {
        try {
            $deleted = JadwaMengajar::find($id);
            $deleted->delete();
            $message = 'Berhasil hapus data jadwal mengajar';
            return redirect()->route('mata.pelajaran.jadwal.ngajar')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('mata.pelajaran.jadwal.ngajar')->with('error', 'Error : '.$th->getMessage().' / '.$th->getLine());
        }
    }

}
