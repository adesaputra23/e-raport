<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\PegawaiDanGuru;
use App\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function LihatData()
    {
        $jabatan_guru = PegawaiDanGuru::GURU;
        $user_guru = RoleUser::where('user_role', $jabatan_guru)->pluck('user_code')->toArray();
        $list_kelas = Kelas::with('guru')->get();
        $list_guru = PegawaiDanGuru::where('jabatan', $jabatan_guru)->whereNotIn('nik', $user_guru)->get();
        return view('kelas.lihat_data',
            compact(
                'list_kelas',
                'list_guru'
            )
        );
    }

    public function FormTambahData($id)
    {
        $get_kelas = Kelas::where('kode_kelas', $id)->first();
        $data_kelas = $get_kelas !== null ? $get_kelas : null;
        return view('kelas.form_tambah_data',
            compact(
                'data_kelas'
            )
        );
    }

    public function SimpanData(Request $request)
    {
        if ($request->action === 'tambah') {
            $simpan_data = new Kelas();
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = Kelas::where('kode_kelas', $request->id)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->kode_kelas = $request->kode_kelas;
            $simpan_data->kelas = $request->kelas;
            $simpan_data->ket_kelas = $request->ket_kelas;
            $simpan_data->save();
            return redirect()->route('kelas.lihat.data.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('kelas.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function hapusData($id)
    {
        try {
            $deleted = Kelas::find($id);
            $deleted->delete();
            return redirect()->route('kelas.lihat.data.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('kelas.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function setWaliKelas(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->kode_kelas;
            $simpan_wali_kelas = Kelas::find($id);
            $simpan_wali_kelas->nik = $request->nik;
            $simpan_wali_kelas->save();

            $cek_role_guru = RoleUser::where('user_code', $request->old_nik)->where('user_role', PegawaiDanGuru::GURU);
            $list_user = $cek_role_guru->get();

            if (count($list_user) > 0) {
                $cek_role_guru->delete();
            }

            $save_role = new RoleUser;
            $save_role->user_code   = $request->nik;
            $save_role->user_role   = PegawaiDanGuru::GURU;
            $save_role->created_at  = date('Y-m-d H:i:s');
            $save_role->save();

            DB::commit();
            return redirect()->route('kelas.lihat.data.admin')->with('success', 'Berhasil tambah wali kelas');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kelas.lihat.data.admin')->with('error', $th->getMessage());
        }
    }
}
