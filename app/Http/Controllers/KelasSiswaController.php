<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\KelasSiswa;
use App\TahunAjaran;
use Illuminate\Http\Request;

class KelasSiswaController extends Controller
{
    public function LihatData()
    {
        $list_kelas_siswa = KelasSiswa::get();
        $list_kelas = Kelas::get();
        return view('kelas_siswa.lihat_data',
            compact(
                'list_kelas_siswa',
                'list_kelas'
            )
        );
    }

    public function FormTambahData($id)
    {
        $get_siswa_kelas = KelasSiswa::where('id_siswa_kelas', $id)->first();
        $data_siswa_kelas = $get_siswa_kelas !== null ? $get_siswa_kelas : null;
        $list_kelas = Kelas::get();
        $tahun_ajaran = TahunAjaran::where('status_aktif', 1)->first();
        return view('kelas_siswa.form_tambah_data',
            compact(
                'data_siswa_kelas',
                'list_kelas',
                'tahun_ajaran'
            )
        );
    }

    public function SimpanData(Request $request)
    {
        // dd($request->all());
        $nisn = explode('/',$request->nisn);
        if ($request->action === 'tambah') {
            $simpan_data = new KelasSiswa();
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = KelasSiswa::where('id_siswa_kelas', $request->id)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }
        
        try {
            $tahun_ajaran = TahunAjaran::where('tahun_ajaran', 'like', '%'.$request->tahun_ajaran.'%')->first();
            $simpan_data->kode_kelas = $request->kelas;
            $simpan_data->nisn = $nisn[0];
            $simpan_data->id_tahun_ajaran = $tahun_ajaran->id_tahun_ajaran;
            $simpan_data->save();
            return redirect()->route('kelas.siswa.lihat.data.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('kelas.siswa.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function hapusData($id)
    {
        try {
            $deleted = KelasSiswa::find($id);
            $deleted->delete();
            return redirect()->route('kelas.siswa.lihat.data.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('kelas.siswa.lihat.data.admin')->with('error', $th->getMessage());
        }
    }
}
