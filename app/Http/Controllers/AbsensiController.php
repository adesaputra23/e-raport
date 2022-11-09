<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Kelas;
use App\Kurikulum;
use App\RoleUser;
use App\Semester;
use App\Siswa;
use App\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DataTables;
use Carbon\Carbon;

class AbsensiController extends Controller
{

    public function __construct()
    {
        $this->semester     = Semester::GetAktifSemester()->id;
        $this->tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $this->kurikulum    = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
    }

    public function index(Request $request)
    {
        $nik_wali_kelas = Auth::user()->user_code;
        $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
        $list_siswa = Siswa::whereHas('sisiwakelas', function($q) use ($kelas)
                {
                    $q->where('kode_kelas', $kelas->kode_kelas);
                    $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);  
                })->get();

        $list_absensi = Absensi::where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('id_semester', Semester::GetAktifSemester()->id)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
        
        if (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas) {
            $list_absensi = $list_absensi->where('kode_kelas', $kelas->kode_kelas);
        }

        if (!empty($request->input())) {
            if (isset($request->tanggal_awal)) {
                $list_absensi = $list_absensi->where('tanggal_absensi', '>', $request->tanggal_awal);
            }
            if (isset($request->tanggal_akhir)) {
                $list_absensi = $list_absensi->where('tanggal_absensi', '<', $request->tanggal_akhir);
            }
            if (isset($request->status_absensi)) {
                $list_absensi = $list_absensi->where('status_absensi', '=', $request->status_absensi);
            }
        }
        $list_absensi = $list_absensi->get();
        return view('absensi/index', compact('list_siswa', 'list_absensi'));
    }

    public function simpanData(Request $request)
    {
        try {
            $save = new Absensi();
            $save->created_at = date('Y-m-d');
            $message = 'tambah';
            if ($request->type === 'ubah') {
                $save = Absensi::where('id_absensi', $request->id)->first();
                $save->created_at = $save->created_at;
                $save->updated_at = date('Y-m-d');
                $message = 'ubah';
            }
            $save->nisn             = $request->nisn;
            $save->nama_siswa       = Siswa::GetSiswaByNisn($request->nisn)->nama;
            $save->kode_kelas       = Siswa::GetSiswaByNisn($request->nisn)->SisiwaKelas->kode_kelas;
            $save->id_tahun_ajaran  = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
            $save->id_semester      = Semester::GetAktifSemester()->id;
            $save->kode_kurikulum   = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
            $save->tanggal_absensi  = $request->tanggal_absen;
            $save->jam_absensi      = $request->jam_absen;
            $save->status_absensi   = $request->status_absensi;
            $save->keterangan_absensi   = $request->ket_absen;
            $save->save();
            return redirect()->route('absensi.index')->with('success', 'Berhasil '.$message.' data siswa absensi');
        } catch (\Throwable $th) {
            return redirect()->route('absensi.index')->with('error', 'Gagal '.$message.' data siswa absensi'.' / '.$th->getMessage().' / '.$th->getLine());
        }
        return redirect()->route('absensi.index')->with('error', 'Terjadi kesalahan saat menyimpan data');
    }

    public function hapus($id)
    {
        try {
            $deleted = Absensi::find($id);
            $deleted->delete();
            $message = 'hapus';
            return redirect()->route('absensi.index')->with('success', 'Berhasil '.$message.' data siswa absensi');
        } catch (\Throwable $th) {
            return redirect()->route('absensi.index')->with('error', 'Gagal '.$message.' data siswa absensi'.' / '.$th->getMessage().' / '.$th->getLine());
        }
        return redirect()->route('absensi.index')->with('error', 'Terjadi kesalahan saat hapus data');
    }

    public function Monitoring(Request $request)
    {
        $query = [
            ['kode_kurikulum', $this->kurikulum],
            ['id_semester', $this->semester],
            ['id_tahun_ajaran', $this->tahun_ajaran]
        ];
        if (RoleUser::CheckRole()->user_role === RoleUser::KP) {
            $list_siswa = Absensi::where($query)->get()->groupBy('nisn');
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid){
            $get_nisn = RoleUser::CheckRole()->user_code;
            $list_siswa = Absensi::where($query)->where('nisn', $get_nisn)->get()->groupBy('nisn');
        }
        $nest = [];
        foreach ($list_siswa as $nisn => $siswa) {
            $nest[$nisn][] = $siswa->groupBy('status_absensi');
        }
        $list_data = [];
        foreach ($nest as $nisn => $value) {
            $kelas = Absensi::where($query)->where('nisn', $nisn)->first();
            $list_data[$nisn]['kelas'] = $kelas->kode_kelas;
            $list_data[$nisn]['Ijin'] = (isset($value[0]['Ijin'])) ? $value[0]['Ijin']->count() : 0;
            $list_data[$nisn]['Sakit'] = (isset($value[0]['Sakit'])) ? $value[0]['Sakit']->count() : 0 ;
            $list_data[$nisn]['Tanpa Keterangan'] = (isset($value[0]['Tanpa Keterangan'])) ? $value[0]['Tanpa Keterangan']->count() : 0 ;
        }
        $compact = ['list_data'];
        return view('absensi/monitoring', compact($compact));
    }

    public function AjaxGetSiswa(Request $request)
    {
        $limit          = $request->input('length');
        $start          = $request->input('start');
        $search         = $request->input('search.value');
        $query = [
            ['kode_kurikulum', $this->kurikulum],
            ['id_semester', $this->semester],
            ['id_tahun_ajaran', $this->tahun_ajaran],
            ['nisn', $request->siswa_nisn],
            ['kode_kelas', $request->kode_kelas]
        ];
        $list_siswa = Absensi::where($query);
        if (isset($search)) {
            $list_siswa->where(function($query) use ($search){
                $query->where('status_absensi', 'like', "%{$search}%");
                $query->orWhere('keterangan_absensi', 'like', "%{$search}%");
                $query->orWhere('tanggal_absensi', 'like', "%{$search}%");
                $query->orWhere('jam_absensi', 'like', "%{$search}%");
            });
        }
        $list_data = $list_siswa
            ->offset($start)
            ->limit($limit)
            ->get();
        $is_data = [];
        foreach ($list_data as $key => $value) {
            $nest['nisn']               = $value->Siswa->nisn.'/'.$value->siswa->nis;
            $nest['nama_siswa']         = $value->nama_siswa;
            $nest['status_absensi']     = $value->status_absensi;
            $nest['keterangan_absensi'] = $value->keterangan_absensi;
            $nest['tanggal_absensi']    = $value->tanggal_absensi;
            $nest['jam_absensi']        = Carbon::parse($value->jam_absensi)->format('H:i').' WIB';
            $is_data[] = $nest;
        }
        $data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($list_siswa->get()->count()),
            "recordsFiltered" => intval($list_siswa->get()->count()),
            "data" => $is_data,
            'filter' => 0,
        ];
        return  response()->json($data);
    }
}
