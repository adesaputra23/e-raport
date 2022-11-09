<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Kurikulum;
use App\MataPelajaran;
use App\MateriPembelajaran;
use App\RoleUser;
use App\Semester;
use App\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TujuanPembelajaranController extends Controller
{
    public function index()
    {
        $list_data = TujuanPembelajaran::with('MateriPembelajaran')->get();
        if (RoleUser::CheckRole()->user_role === RoleUser::Admin) {
            $list_data = $list_data;
        }else{
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $list_data = TujuanPembelajaran::with('MateriPembelajaran')
                ->where('kode_kelas', $kelas->kode_kelas)
                ->where('id_semester', Semester::GetAktifSemester()->id)
                ->get();
        }
        return view('assesment/tujuan/index', compact('list_data'));
    }

    public function AddtujuanPebelajaran($id)
    {
        $data_materi = TujuanPembelajaran::where('kode_tujuan', '=', $id)->first();
        $list_semester = Semester::get();
        if (RoleUser::CheckRole()->user_role === RoleUser::Admin ) {
            $list_materi = MateriPembelajaran::get();
        }elseif (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas ) {
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $list_materi = MateriPembelajaran::with(['mt' => function($query) use ($kelas) {
                $query->where('kode_kurikulum', Kurikulum::Prototype);
                $query->where('kode_kelas', $kelas->kode_kelas);
            }])->get();
        }        
        return view('assesment/tujuan/form_add_data', compact('data_materi', 'list_materi', 'list_semester'));
    }

    public function Save(Request $request)
    {

        $data_materi = MateriPembelajaran::where('kode_materi', '=', $request->kode_materi)
            ->with('mt')->first();

        if ($request->action === 'tambah') {
            $simpan_data = new TujuanPembelajaran();
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = TujuanPembelajaran::where('kode_tujuan', $request->kode_tujuan)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->kode_tujuan          = $request->kode_tujuan;
            $simpan_data->kode_materi          = $request->kode_materi;
            $simpan_data->nama_tujuan          = $request->tujuan;
            $simpan_data->id_semester          = $request->smester;
            $simpan_data->kode_kelas           = $data_materi->mt->kode_kelas;
            $simpan_data->save();
            return redirect()->route('assesment.tujuan.pembelajaran.index.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('assesment.tujuan.pembelajaran.index.admin')->with('error', $th->getMessage());
        }
    }

    public function Hapus($id)
    {
        try {
            $deleted = TujuanPembelajaran::where('kode_tujuan', '=', $id)->first();
            $deleted->delete();
            return redirect()->route('assesment.tujuan.pembelajaran.index.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('assesment.tujuan.pembelajaran.index.admin')->with('error', $th->getMessage());
        }
    }
}
