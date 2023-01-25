<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Kelas;
use App\KelasSiswa;
use App\PnBBdanTB;
use App\PnEkskul;
use App\PnKeterampilan;
use App\PnKondisiKesehatan;
use App\PnPengetahuan;
use App\PnPrestasi;
use App\PnSaran;
use App\PnSikap;
use App\PnSmFm;
use App\RoleUser;
use App\Siswa;
use App\TahunAjaran;
use App\User;
use App\WaliSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function LihatData()
    {
        if (RoleUser::CheckRole()->user_role === RoleUser::Admin || RoleUser::CheckRole()->user_role === RoleUser::Operator) {
            $list_siswa = Siswa::with('SisiwaKelas')->get();
        }elseif (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas) {
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $list_siswa = Siswa::with('SisiwaKelas')->whereHas('sisiwakelas', function($q) use ($kelas)
                {
                    $q->where('kode_kelas', $kelas->kode_kelas);
                    $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);  
                })->get();
        }else{
            $list_siswa = [];
        }

        return view('siswa.lihat_data',
            compact(
                'list_siswa',
            )
        );
    }

    public function FormTambahData($nisn)
    {
        $data_siswa = Siswa::where('nisn', $nisn)->first();
        $list_agama = User::MAP_AGAMA;
        $list_pekerjaan = User::MAP_PEKRJAAN;
        $list_pendidikan = User::MAP_PENDIDIKAN;
        return view('siswa.form_tambah_data',
            compact(
                'data_siswa',
                'list_agama',
                'list_pekerjaan',
                'list_pendidikan',
            )
        );
    }

    public function SimpanData(Request $request)
    {
        if ($request->action === 'tambah') {
            $message = [
                'unique' => ':attribute sudah digunakan!',
            ];
            $this->validate($request, [
                'nisn' => 'unique:tabel_siswa',
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
                $user_insert->user_code = $request->nisn;
                $user_insert->email = $request->email;
                $user_insert->password = bcrypt($request->nisn);
                $user_insert->created_at = date('Y-m-d H:s:i');
                $user_insert->email_verified_at = date('Y-m-d H:s:i');
                $user_insert->save();

                // role insert
                $role_insert = new RoleUser();
                $role_insert->user_code = $request->nisn;
                $role_insert->user_role = RoleUser::WaliMurid;
                $role_insert->created_at = date('Y-m-d H:i:s');
                $role_insert->save();

                // siswa insert
                $siswa_insert = new Siswa();
                $siswa_insert->nisn = $request->nisn;
                $siswa_insert->nis = $request->nis;
                $siswa_insert->nama = $request->nama;
                $siswa_insert->jenis_kelamin = $request->jenis_kelamin;
                $siswa_insert->tempat_lahir = $request->tempat_lahir;
                $siswa_insert->tanggal_lahir = $request->tanggal_lahir;
                $siswa_insert->agama = $request->agama;
                $siswa_insert->alamat = $request->alamat;
                $siswa_insert->status_anak = $request->status_anak;
                $siswa_insert->kontak = $request->kontak;
                $siswa_insert->negara = $request->negara;
                $siswa_insert->provinsi = $request->provinsi;
                $siswa_insert->kota = $request->kota;
                $siswa_insert->kode_pos = $request->kode_pos;
                $siswa_insert->no_tlp_rumah = $request->no_tlp_rumah;
                $siswa_insert->foto = $nama_file ?? null;
                $siswa_insert->save();

                // wali insert
                $wali_insert = new WaliSiswa();
                $wali_insert->nisn = $request->nisn;

                // ayah
                $wali_insert->nik_ayah = $request->nik_ayah;
                $wali_insert->nama_ayah = $request->nama_ayah;
                $wali_insert->pekerjaan_ayah = $request->pekerjaan_ayah ?? null;
                $wali_insert->pendidikan_ayah = $request->pendidikan_ayah ?? null;
                $wali_insert->email_ayah = $request->email_ayah;
                $wali_insert->no_hp_ayah = $request->n_hp_ayah;

                // ibu
                $wali_insert->nik_ibu = $request->nik_ibu;
                $wali_insert->nama_ibu = $request->nama_ibu;
                $wali_insert->pekerjaan_ibu = $request->pekerjaan_ibu ?? null;
                $wali_insert->pendidikan_ibu = $request->pendidikan_ibu ?? null;
                $wali_insert->email_ibu = $request->email_ibu;
                $wali_insert->no_hp_ibu = $request->n_hp_ibu;

                // wali
                $wali_insert->nik_wali = $request->nik_wali;
                $wali_insert->nama_wali = $request->nama_wali;
                $wali_insert->pekerjaan_wali = $request->pekerjaan_wali ?? null;
                $wali_insert->pendidikan_wali = $request->pendidikan_wali ?? null;
                $wali_insert->email_wali = $request->email_wali;
                $wali_insert->no_hp_wali = $request->n_hp_wali;

                $wali_insert->save();

                DB::commit();
                return redirect()->route('siswa.lihat.data.admin')->with('success', 'Data berhasil di simpan');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('siswa.lihat.data.admin')->with('error', $th->getMessage());
            }

        }else if ($request->action === 'ubah') {
            // dd($request->all());
            $nisn = $request->nisn;
            DB::beginTransaction();
            try {
                if ($request->file('foto')) {
                    $image = $request->file('foto');
                    $nama_file = $image->getClientOriginalName();
                    $tujuan_upload = 'assets/images/users';
                    $image->move($tujuan_upload, $image->getClientOriginalName());
                }

                // user update
                $user_update = User::where('user_code', $nisn)->first();
                $user_update->email = $request->email;
                $user_update->save();

                // siswa update
                $siswa_update = Siswa::where('nisn', $nisn)->first();
                $siswa_update->nama = $request->nama;
                $siswa_update->jenis_kelamin = $request->jenis_kelamin;
                $siswa_update->tempat_lahir = $request->tempat_lahir;
                $siswa_update->tanggal_lahir = $request->tanggal_lahir;
                $siswa_update->agama = $request->agama;
                $siswa_update->alamat = $request->alamat;
                $siswa_update->status_anak = $request->status_anak;
                $siswa_update->kontak = $request->kontak;
                $siswa_update->negara = $request->negara;
                $siswa_update->provinsi = $request->provinsi;
                $siswa_update->kota = $request->kota;
                $siswa_update->kode_pos = $request->kode_pos;
                $siswa_update->no_tlp_rumah = $request->no_tlp_rumah;
                $siswa_update->foto = $nama_file ?? $siswa_update->foto;
                $siswa_update->save();

                // wali update
                $wali_update = WaliSiswa::where('nisn', $nisn)->first();

                // ayah
                $wali_update->nik_ayah = $request->nik_ayah;
                $wali_update->nama_ayah = $request->nama_ayah;
                $wali_update->pekerjaan_ayah = $request->pekerjaan_ayah ?? null;
                $wali_update->pendidikan_ayah = $request->pendidikan_ayah ?? null;
                $wali_update->email_ayah = $request->email_ayah;
                $wali_update->no_hp_ayah = $request->n_hp_ayah;

                // ibu
                $wali_update->nik_ibu = $request->nik_ibu;
                $wali_update->nama_ibu = $request->nama_ibu;
                $wali_update->pekerjaan_ibu = $request->pekerjaan_ibu ?? null;
                $wali_update->pendidikan_ibu = $request->pendidikan_ibu ?? null;
                $wali_update->email_ibu = $request->email_ibu;
                $wali_update->no_hp_ibu = $request->n_hp_ibu;

                // wali
                $wali_update->nik_wali = $request->nik_wali;
                $wali_update->nama_wali = $request->nama_wali;
                $wali_update->pekerjaan_wali = $request->pekerjaan_wali ?? null;
                $wali_update->pendidikan_wali = $request->pendidikan_wali ?? null;
                $wali_update->email_wali = $request->email_wali;
                $wali_update->no_hp_wali = $request->n_hp_wali;

                $wali_update->save();
                DB::commit();
                return redirect()->route('siswa.lihat.data.admin')->with('success', 'Data berhasil di update');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('siswa.lihat.data.admin')->with('error', $th->getMessage());
            }

        }
    }

    public function hapusData($nisn)
    {
        if ($nisn != null) {
            DB::beginTransaction();
            try {
                $wali = WaliSiswa::where('nisn', $nisn)->first();
                $wali->delete();
                $siswa = Siswa::where('nisn', $nisn)->first();
                $siswa->delete();
                $user = User::where('user_code', $nisn)->first();
                $user->delete();
                DB::commit();
                return redirect()->route('siswa.lihat.data.admin')->with('success', 'Data berhasil di hapus');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('siswa.lihat.data.admin')->with('error', 'Data gagal di hapus', $th->getMessage().'/'.$th->getLine());
            }
        }

    }

    public function SiswaSerach(Request $request)
    {
        $get_siswa_kelas = KelasSiswa::whereHas('TahunAjaran', function ($query)
        {
            return $query->where('status_aktif', 1);
        })->pluck('nisn')->toArray();

        $posisi = Siswa::whereNotIn('nisn', $get_siswa_kelas)->get();

        $data = [];
        foreach($posisi as $row)
        {
            $data_posisi = "" . $row->nisn . "/" . $row->nis. "-" . $row->nama . "";
            $data[] = $data_posisi;
        }
        return response()->json($data);
    }

    public function detailData($nisn)
    {   
        $siswa = Siswa::with('WaliSiswa')->where('nisn', $nisn)->first();
        return view('siswa/detail_data', compact('siswa'));
    }

    public function ubahNisn(Request $request)
    {
        DB::beginTransaction();
        try {
            $query_seacrh = [['nisn', $request->nis_lama]];
            $query_updated = ['nisn' => $request->nis_baru];
            // -> tabel_siswa
            Siswa::where($query_seacrh)->update($query_updated);
            // -> tabel_siswa_kelas
            KelasSiswa::where($query_seacrh)->update($query_updated);
            // -> tabel_wali_siswa
            WaliSiswa::where($query_seacrh)->update($query_updated);
            // -> tabel_user
            User::where('user_code', $request->nis_lama)->update(
                [
                    'user_code' => $request->nis_baru,
                    'password' => bcrypt($request->nis_baru)
                ]
            );
            // -> roles_tabel
            RoleUser::where('user_code', $request->nis_lama)->update(['user_code' => $request->nis_baru]);
            // -> pn_berat_dan_tinggi_badan
            PnBBdanTB::where($query_seacrh)->update($query_updated);
            // -> pn_ekskul
            PnEkskul::where($query_seacrh)->update($query_updated);
            // -> pn_keterampilan
            PnKeterampilan::where($query_seacrh)->update($query_updated);
            // -> pn_kondisi_kesehatan
            PnKondisiKesehatan::where($query_seacrh)->update($query_updated);
            // -> pn_pengetatahuan
            PnPengetahuan::where($query_seacrh)->update($query_updated);
            // -> pn_prestasi
            PnPrestasi::where($query_seacrh)->update($query_updated);
            // -> pn_saran
            PnSaran::where($query_seacrh)->update($query_updated);
            // -> pn_sikap
            PnSikap::where($query_seacrh)->update($query_updated);
            // -> tabel_absensi
            Absensi::where($query_seacrh)->update($query_updated);
            // -> tabel_pn_fm_sm
            PnSmFm::where($query_seacrh)->update($query_updated);
            DB::commit();
            return redirect()->route('siswa.lihat.data.admin')->with('success', 'Data berhasil di update');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('siswa.lihat.data.admin')->with('error', 'Data gagal di hapus -> '.$th->getMessage().'/'.$th->getLine());
        }

    }
}
