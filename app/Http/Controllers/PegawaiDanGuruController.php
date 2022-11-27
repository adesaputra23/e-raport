<?php

namespace App\Http\Controllers;

use App\PegawaiDanGuru;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiDanGuruController extends Controller
{
    public function LihatData()
    {
        $list_pegawai = PegawaiDanGuru::get();
        return view('pegawai_dan_guru/lihat_data',
            compact(
                'list_pegawai'
            )
        );
    }

    public function TambahData($nik)
    {
        $data_karyawan = PegawaiDanGuru::where('nik', $nik)->first();
        $list_staus = PegawaiDanGuru::MAP_STATUS;
        return view(
            'pegawai_dan_guru/tambah_data',
                compact(
                    'data_karyawan',
                    'list_staus'
                )
        );
    }

    public function SimpanData(Request $request)
    {
        if ($request->action == 'tambah') {
            $message = [
                'unique' => ':attribute sudah digunakan!',
            ];
            $this->validate($request, [
                'nik' => 'unique:pegawais_and_gurus_tabel',
                'email' => 'unique:users',
                'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            ], $message);
            DB::beginTransaction();
            try {
                if ($request->file('foto')) {
                    $image = $request->file('foto');
                    $nama_file = $image->getClientOriginalName();
                    $tujuan_upload = 'assets/images/users';
                    $image->move($tujuan_upload, $image->getClientOriginalName());
                }
                // user insert
                $user_insert = new User();
                $user_insert->user_code = $request->nik;
                $user_insert->email = $request->email;
                $user_insert->password = bcrypt($request->nik);
                $user_insert->created_at = date('Y-m-d H:s:i');
                $user_insert->email_verified_at = date('Y-m-d H:s:i');
                $user_insert->save();

                if ($request->jabatan == 1) {
                    $role_insert = new RoleUser();
                    $role_insert->user_code = $request->nik;
                    $role_insert->user_role = 6;
                    $role_insert->created_at = date('Y-m-d h:i:s');
                    $role_insert->save();
                }

                // Pegawai insert
                $insert_data = new PegawaiDanGuru();
                $insert_data->nik = $request->nik;
                $insert_data->nama = $request->nama;
                $insert_data->jenis_kelamin = $request->jenis_kelamin;
                $insert_data->tanggal_lahir = $request->tanggal_lahir;
                $insert_data->jabatan = $request->jabatan;
                $insert_data->status = $request->status;
                $insert_data->lulusan = $request->lulusan;
                $insert_data->foto = $nama_file ?? null;
                $insert_data->save();
                DB::commit();
                return redirect()->route('pegawai.lihat.data.admin')->with('success', 'Data berhasil di simpan');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('pegawai.lihat.data.admin')->with('error', $th->getMessage());
            }
        }elseif($request->action == 'ubah'){
            $nik = $request->nik;  
            DB::beginTransaction();
            try {
                if ($request->file('foto')) {
                    $image = $request->file('foto');
                    $nama_file = $image->getClientOriginalName();
                    $tujuan_upload = 'assets/images/users';
                    $image->move($tujuan_upload, $image->getClientOriginalName());
                }
                // user update
                $user_update = User::where('user_code', $nik)->first();
                $user_update->email = $request->email;
                $user_update->save();
                // Pegawai update
                $update_data = PegawaiDanGuru::where('nik', $nik)->first();
                $update_data->nama = $request->nama;
                $update_data->jenis_kelamin = $request->jenis_kelamin;
                $update_data->tanggal_lahir = $request->tanggal_lahir;
                $update_data->jabatan = $request->jabatan;
                $update_data->status = $request->status;
                $update_data->lulusan = $request->lulusan;
                $update_data->foto = $nama_file ?? $update_data->foto;
                $update_data->save();
                DB::commit();
                return redirect()->route('pegawai.lihat.data.admin')->with('success', 'Data berhasil di ubah');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('pegawai.lihat.data.admin')->with('error', 'Data gagal di ubah');
            }
        }
    }

    public function hapusData($nik)
    {
        if ($nik != null) {
            DB::beginTransaction();
            try {
                $role = RoleUser::where('user_code', $nik)->first();
                if ($role != null) {
                    $role->delete();
                }
                $karyawan = PegawaiDanGuru::where('nik', $nik)->first();
                $karyawan->delete();
                $user = User::where('user_code', $nik)->first();
                $user->delete();
                DB::commit();
                return redirect()->route('pegawai.lihat.data.admin')->with('success', 'Data berhasil di hapus');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('pegawai.lihat.data.admin')->with('error', 'Data gagal di hapus');
            }
        }
    }

    public function detailData($nik)
    {
        $data_karyawan = PegawaiDanGuru::where('nik', $nik)->first();
        return view('pegawai_dan_guru.detail_data',
            compact(
                'data_karyawan',
            )
        );
    }

    public function SetNip()
    {
        $list_data = PegawaiDanGuru::where('jabatan', PegawaiDanGuru::KEPALA_SEKOLAH)->first();
        return view('pegawai_dan_guru/seting_nip', compact('list_data'));
    }

    public function SaveNip(Request $request)
    {
        try {
            $new_update = PegawaiDanGuru::where('id', $request->id)->first();
            $new_update->nip_2 = $request->nip;
            $new_update->save();
            return redirect()->route('guru.pegawai.set.nip')->with('success', 'Berhasil seting nip');
        } catch (\Throwable $th) {
            return redirect()->route('guru.pegawai.set.nip')->with('error', 'Error: '.$th->getMessage().' / '.$th->getLine());
        }
    }
}
