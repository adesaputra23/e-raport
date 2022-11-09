<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Kurikulum;
use App\MataPelajaran;
use App\MateriPembelajaran;
use App\RoleUser;
use App\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriPembelajaranK22Controller extends Controller
{
    public function index()
    {   
        if (RoleUser::CheckRole()->user_role === RoleUser::Admin) {
            $list_data = MateriPembelajaran::get();
        }else{
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $list_data = MateriPembelajaran::with('Mt')
                ->where('kode_kelas', '=', $kelas->kode_kelas)
                ->get();
        }
        return view('assesment.materi.index', compact('list_data'));
    }

    public function MateriAddData($id)
    {
        $data_materi = MateriPembelajaran::find($id);
        if (RoleUser::CheckRole()->user_role === RoleUser::Admin){
            $list_mt = MataPelajaran::with('kelas')->where('kode_kurikulum', Kurikulum::Prototype)->get();
        }elseif (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas) {
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first(); 
            $list_mt = MataPelajaran::with('kelas')
                ->whereHas('kelas', function($q) use ($kelas){
                    $q->where('kode_kelas', $kelas->kode_kelas);
                })
                ->where('kode_kurikulum', Kurikulum::Prototype)->get();
        }else{
            $list_mt = [];
        }

        $list_semester = Semester::get();
        return view('assesment.materi.form_add_data', compact('data_materi', 'list_mt', 'list_semester'));
    }

    public function Save(Request $request)
    {

        $mt = MataPelajaran::where('kode_mt', $request->kode_mt)->first();

        if ($request->action === 'tambah') {
            $simpan_data = new MateriPembelajaran();
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = MateriPembelajaran::where('kode_materi', $request->id)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->kode_materi           = $request->kode_materi;
            $simpan_data->materi_pembelajaran   = $request->materi;
            $simpan_data->kode_mt               = $request->kode_mt;
            $simpan_data->id_semester           = $request->smester;
            $simpan_data->kode_kelas            = $mt->kode_kelas;
            $simpan_data->save();
            return redirect()->route('assesment.materi.index.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('assesment.materi.index.admin')->with('error', $th->getMessage());
        }
    }

    public function Hapus($id)
    {
        try {
            $deleted = MateriPembelajaran::find($id);
            $deleted->delete();
            return redirect()->route('assesment.materi.index.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('assesment.materi.index.admin')->with('error', $th->getMessage());
        }
    }
}
