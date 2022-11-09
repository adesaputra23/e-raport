<?php

namespace App\Http\Controllers;

use App\Semester;
use App\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function LihatData()
    {
        $list_tahun_ajaran = TahunAjaran::get();
        $list_semster = Semester::get();
        return view('tahun_ajaran.lihat_data',
            compact(
                'list_tahun_ajaran',
                'list_semster',
            )
        );
    }

    public function FormTambahData($id)
    {
        $get_tahun_ajaran = TahunAjaran::where('id_tahun_ajaran', $id)->first();
        $data_tahun_ajaran = $get_tahun_ajaran !== null ? $get_tahun_ajaran : null;
        $list_status = TahunAjaran::MAP_STATUS;
        return view('tahun_ajaran.form_tambah_data',
            compact(
                'data_tahun_ajaran',
                'list_status'
            )
        );
    }

    public function SimpanData(Request $request)
    {
        if ($request->action === 'tambah') {
            $simpan_data = new TahunAjaran();
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = TahunAjaran::where('id_tahun_ajaran', $request->id_tahun_ajaran)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->tahun_ajaran = $request->tahun_ajaran;
            $simpan_data->ket_tahun_ajaran = $request->ket_tahun_ajaran;
            $simpan_data->status_aktif = $request->status_aktif;
            $simpan_data->save();
            return redirect()->route('tahun.ajaran.lihat.data.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('tahun.ajaran.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function UpdateSemster($id)
    {
        try {
            $update_aktif = Semester::where('status_semester', 1)->first();
            $update_aktif->status_semester = 2;
            $update_aktif->save();

            $update = Semester::where('id', $id)->first();
            $update->status_semester = 1;
            $update->save();

            return redirect()->route('tahun.ajaran.lihat.data.admin')->with('success', 'Semester Berhasil Diaktifkan');
        } catch (\Throwable $th) {
            return redirect()->route('tahun.ajaran.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function hapusData($id)
    {
        try {
            $deleted = TahunAjaran::find($id);
            $deleted->delete();
            return redirect()->route('tahun.ajaran.lihat.data.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('tahun.ajaran.lihat.data.admin')->with('error', $th->getMessage());
        }
    }
}
