<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Kelas;
use App\KelasSiswa;
use App\KKM;
use App\KompetensiDasar;
use App\Kurikulum;
use App\MataPelajaran;
use App\MateriPembelajaran;
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
use App\Semester;
use App\Siswa;
use App\TahunAjaran;
use App\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;
use PDF;

class RaportController extends Controller
{

    public function __construct()
    {
        $this->tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $this->kurikulum    = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $this->semester     = Semester::GetAktifSemester()->id;
    }

    public function index(Request $request)
    {
        $kurikulum = Kurikulum::GetAktiveKurikulum();
        $list_kelas = [];
        if (RoleUser::CheckRole()->user_role === RoleUser::KP) {
            $list_kelas = Kelas::get();
            $kelas = (object)['kode_kelas' => $request->kelas];
            $list_siswa = Siswa::whereHas('sisiwakelas', function($q) use ($kelas)
                {
                    $q->where('kode_kelas', $kelas->kode_kelas);
                    $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);  
                })->get();            
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas){
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
            $list_siswa = Siswa::whereHas('sisiwakelas', function($q) use ($kelas)
                {
                    $q->where('kode_kelas', $kelas->kode_kelas);
                    $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);  
                })->get();
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid){
            $nisn = RoleUser::CheckRole()->user_code;
            $query_get_kelas = [['id_tahun_ajaran', $this->tahun_ajaran],['nisn', $nisn]];
            $kelas = KelasSiswa::where($query_get_kelas)->first();
            $list_siswa = $nisn;
        }
        $nilai_kkm = KKM::first();
        $is_data = [];
        $data_nilai = [];
        if ($kurikulum->kode_kurikulum === Kurikulum::K13) {
            if (!empty($request->input())) {
                $data_pn_sikap = self::getPnSikap($request->nisn, $kelas->kode_kelas);
                $data_ekskul = self::getEkskul($request->nisn, $kelas->kode_kelas);
                $data_saran = self::getPnSaran($request->nisn, $kelas->kode_kelas);
                $data_TBdanBB = self::getPnTinggidanBB($request->nisn, $kelas->kode_kelas);
                $data_kodisi_kesehatan = self::getKondisiKesatan($request->nisn, $kelas->kode_kelas);
                $data_prestasi = self::getPrestasi($request->nisn, $kelas->kode_kelas);
                $data_absensi = self::GetAbsesni($request->nisn, $kelas->kode_kelas);
                $data_siswa = self::getSiswak13($request);
                $data_nilai = self::getNilaiK13($request);
                $is_data = $data_siswa;
            }
            return view('nilai_raport/k13/index', 
                compact('list_siswa', 'is_data', 'data_nilai', 'nilai_kkm', 'list_kelas', 'data_pn_sikap', 'data_ekskul', 'data_saran', 'data_TBdanBB', 'data_kodisi_kesehatan', 'data_prestasi', 'data_absensi')
            );
        }elseif($kurikulum->kode_kurikulum === Kurikulum::Prototype){
            if (!empty($request->input())) {
                $data_ekskul = self::getEkskul($request->nisn, $kelas->kode_kelas);
                $data_absensi = self::GetAbsesni($request->nisn, $kelas->kode_kelas);
                $data_siswa = self::getSiswaK22($request);
                $data_nilai = self::getNilaiK22($request);
                $is_data = $data_siswa;
            }
            return view('nilai_raport/k22/index', compact('list_siswa', 'is_data', 'nilai_kkm', 'data_nilai', 'list_kelas', 'data_ekskul', 'data_absensi'));
        }
    }

    public function getSiswak13($request)
    {
        if (RoleUser::CheckRole()->user_role === RoleUser::KP) {
            $kelas = (object)['kode_kelas' => 'KLS01'];
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas){
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid){
            $siswa_nisn = RoleUser::CheckRole()->user_code;
            $query_get_kelas = [['id_tahun_ajaran', $this->tahun_ajaran],['nisn', $siswa_nisn]];
            $kelas = KelasSiswa::where($query_get_kelas)->first();
        }
        $is_siswa = [];
        if (!empty($kelas)) {
            $is_siswa = PnKeterampilan::where('nisn', $request->nisn)
                ->where('kode_kelas', $kelas->kode_kelas)
                ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
                ->where('id_semster', Semester::GetAktifSemester()->id)
                ->first();
            if (empty($is_siswa)) {
                $is_siswa = PnPengetahuan::where('nisn', $request->nisn)
                    ->where('kode_kelas', $kelas->kode_kelas)
                    ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
                    ->where('id_semster', Semester::GetAktifSemester()->id)
                    ->first();
            }
        }
        return $is_siswa;
    }

    public function getNilaiK13($request)
    {
        if (RoleUser::CheckRole()->user_role === RoleUser::KP) {
            $kelas = (object)['kode_kelas' => 'KLS01'];
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas){
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid){
            $siswa_nisn = RoleUser::CheckRole()->user_code;
            $query_get_kelas = [['id_tahun_ajaran', $this->tahun_ajaran],['nisn', $siswa_nisn]];
            $kelas = KelasSiswa::where($query_get_kelas)->first();
        }

        $is_data = [];
        if (!empty($kelas)) {
            // nilai keterampilan
            $nilai_kd = PnKeterampilan::with('kd')
                ->where('nisn', $request->nisn)
                ->where('kode_kelas', $kelas->kode_kelas)
                ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
                ->where('id_semster', Semester::GetAktifSemester()->id)
                ->where('nilai_keterampilan', '<>', 0);

            $list_nilai_kd = $nilai_kd->get();
            $kd_array = $nilai_kd->where('type_nilai_keterampilan', 'nilai_kd')->pluck('kode_kd')->toArray('kode_kd');
            $is_data = [];
            $is_nilai_kd = [];
            foreach ($list_nilai_kd as $key => $value) {
                if ($value->type_nilai_keterampilan === 'nilai_kd') {
                    $list['nilai_kd'] = $value->nilai_total;
                }elseif($value->type_nilai_keterampilan === 'nilai_pts'){
                    $list['nilai_pts'] = $value->nilai_total;
                }elseif($value->type_nilai_keterampilan === 'nilai_pas'){
                    $list['nilai_pas'] = $value->nilai_total;
                }
                $is_nilai_kd[$value->kd->kode_mt] = $list;
            }
            $is = [];
            foreach ($is_nilai_kd as $keys => $nilai) {
                $is[$keys] = ($nilai['nilai_kd'] + $nilai['nilai_pts'] + $nilai['nilai_pas']) / 3;
            }
            $materi_belajar = KompetensiDasar::whereIn('kode_kd', $kd_array)->get();
            $a = [];
            foreach ($materi_belajar as $keys => $values) {
                $int['nama_kd'] = $values['nama_kd'];
                $a[$values['kode_mt']][] = $int;
            }
            // end nilai keterampilan
    
            // nilai pengetahuan
            $nilai_kd_p = PnPengetahuan::with('kd')
                ->where('nisn', $request->nisn)
                ->where('kode_kelas', $kelas->kode_kelas)
                ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
                ->where('id_semster', Semester::GetAktifSemester()->id)
                ->where('nilai_pengetahuan', '<>', 0)->get();
    
            $kd_array_p_s = PnPengetahuan::with('kd')
                ->where('nisn', $request->nisn)
                ->where('kode_kelas', $kelas->kode_kelas)
                ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
                ->where('id_semster', Semester::GetAktifSemester()->id)
                ->where('type_nilai_pengetahuan', 'nilai_kd')->pluck('kode_kd')->toArray('kode_kd');
    
            $is_nilai_kd_p = [];
            foreach ($nilai_kd_p as $key_p => $value_p) {
                if ($value_p->type_nilai_pengetahuan === 'nilai_kd') {
                    $list_p['nilai_kd'] = $value_p->nilai_total;
                }elseif($value_p->type_nilai_pengetahuan === 'nilai_pts'){
                    $list_p['nilai_pts'] = $value_p->nilai_total;
                }elseif($value_p->type_nilai_pengetahuan === 'nilai_pas'){
                    $list_p['nilai_pas'] = $value_p->nilai_total;
                }
                $is_nilai_kd_p[$value_p->kd->kode_mt] = $list_p;
            }
            $is_p = [];
            foreach ($is_nilai_kd_p as $keys_p => $nilai_p) {
                $is_p[$keys_p] = ($nilai_p['nilai_kd'] + $nilai_p['nilai_pts'] + $nilai_p['nilai_pas']) / 3;
            }
            $materi_belajar_p = KompetensiDasar::whereIn('kode_kd', $kd_array_p_s)->get();
            $a_p = [];
            foreach ($materi_belajar_p as $keys_p => $values_p) {
                $int_p['nama_kd'] = $values_p['nama_kd'];
                $a_p[$values_p['kode_mt']][] = $int_p;
            }
            array_push($is_data, $is, $a, $is_p, $a_p);
        }
        return $is_data;
    }

    public static function getSiswaK22($request)
    {
        $nisn = $request->nisn;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        if (RoleUser::CheckRole()->user_role === RoleUser::KP) {
            $kelas = (object)['kode_kelas' => 'KLS01'];
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas){
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid){
            $siswa_nisn = RoleUser::CheckRole()->user_code;
            $query_get_kelas = [['id_tahun_ajaran', $tahun_ajaran],['nisn', $siswa_nisn]];
            $kelas = KelasSiswa::where($query_get_kelas)->first();
        }
        $getSiswa = [];
        if (!empty($kelas)) {
            $getSiswa = PnSmFm::with('siswa')->where('nisn', $nisn)->where('kode_kelas', $kelas->kode_kelas)->where('id_semester', $semester)->where('id_tahun_ajaran', $tahun_ajaran)->first();
        }
        return $getSiswa;
    }

    public static function getNilaiK22($request)
    {
        $nisn = $request->nisn ?? $request;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        if (RoleUser::CheckRole()->user_role === RoleUser::KP) {
            $kelas = (object)['kode_kelas' => 'KLS01'];
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas){
            $nik_wali_kelas = Auth::user()->user_code;
            $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
        }elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid){
            $siswa_nisn = RoleUser::CheckRole()->user_code;
            $query_get_kelas = [['id_tahun_ajaran', $tahun_ajaran],['nisn', $siswa_nisn]];
            $kelas = KelasSiswa::where($query_get_kelas)->first();
        }
        $getNilai = [];
        if (!empty($kelas)) {
            $getNilai = PnSmFm::where('nisn', $nisn)->where('kode_kelas', $kelas->kode_kelas)->where('id_semester', $semester)->where('id_tahun_ajaran', $tahun_ajaran)->get();
        }
        $list_nilai = [];
        foreach ($getNilai as $key => $value) {
            $arn['kode_tujuan'] = TujuanPembelajaran::GetKodeMTByKodeTujuan($value['kode_tujuan'])->nama_tujuan;
            $nilai_total = ( $value['nilai_formatif'] + $value['nilai_sumatif'] + $value['nilai_akhir_sumatif'] ) / 3;
            $list_nilai[$value['kode_mt']] = [
                'tujuan' => $arn['kode_tujuan'],
                'nilai_total' => substr($nilai_total, 0, 2)
            ];
        }
        return $list_nilai;
    }

    public static function GenerateNilai($nilai)
    {
        $generate = "E";
        if ($nilai >= 80) {
            $generate = "A";
        }elseif ($nilai >= 70) {
            $generate = "B";
        }elseif ($nilai >= 65){
            $generate = "C";
        }elseif ($nilai >= 50) {
            $generate = "D";
        }
        return $generate;
    }

    public static function GeneratePredikat($predikat)
    {
        $gnt = "Sangat Tidak Baik";
        if ($predikat == "A") {
            $gnt = "Sangat Baik";
        }elseif ($predikat == "B") {
            $gnt = "Baik";
        }elseif ($predikat == "C") {
            $gnt = "Cukup Baik";
        }elseif ($predikat == "D") {
            $gnt = "Tidak Baik";
        }
        return $gnt;
    }

    public static function GetNameMapel($kode)
    {
        $mapel = MataPelajaran::where('kode_mt', $kode)->first();
        return $mapel;
    }

    public static function FaseKelas($kelas)
    {
        $fase = "-";
        if ($kelas === "I" || $kelas === "II") {
            $fase = 'A';
        }elseif ($kelas === "III" || $kelas === "IV") {
            $fase = "B";
        }elseif ($kelas === "V" || $kelas === "VI") {
            $fase = "C";
        }
        return $fase;
    }

    public function CetakRaport($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        if ($aktif_kurikulum === Kurikulum::K13) {
            $data_siswa = self::getSiswak13Raport($nisn, $kode_kelas);
            $data_pn_sikap = self::getPnSikap($nisn, $kode_kelas);
            $data_nilai = self::getNilaiK13Raport($nisn, $kode_kelas);
            $data_ekskul = self::getEkskul($nisn, $kode_kelas);
            $data_saran = self::getPnSaran($nisn, $kode_kelas);
            $data_TBdanBB = self::getPnTinggidanBB($nisn, $kode_kelas);
            $data_kodisi_kesehatan = self::getKondisiKesatan($nisn, $kode_kelas);
            $data_prestasi = self::getPrestasi($nisn, $kode_kelas);
            $data_absensi = self::GetAbsesni($nisn, $kode_kelas);
            $pdf = PDF::loadview('nilai_raport/k13/cetak_pdf', compact('data_siswa', 'data_pn_sikap', 'data_nilai', 'data_ekskul', 'data_saran', 'data_TBdanBB', 'data_kodisi_kesehatan', 'data_prestasi', 'data_absensi'));
            return $pdf->stream();
        }elseif ($aktif_kurikulum === Kurikulum::Prototype) {
            $semester = Semester::GetAktifSemester()->id;
            $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
            $data_siswa = PnSmFm::with('siswa')->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->where('id_semester', $semester)->where('id_tahun_ajaran', $tahun_ajaran)->first();
            $data_nilai = self::getNilaiK22($nisn);
            $data_ekskul = self::getEkskul($nisn, $kode_kelas);
            $data_absensi = self::GetAbsesni($nisn, $kode_kelas);
            $pdf = PDF::loadview('nilai_raport/k22/cetak_pdf', compact('data_siswa', 'data_nilai', 'data_ekskul', 'data_absensi'));
            return $pdf->stream();
        }
    }

    public function getSiswak13Raport($nisn, $kode_kelas)
    {
        $is_siswa = PnKeterampilan::where('nisn', $nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->first();
        if (empty($is_siswa)) {
            $is_siswa = PnPengetahuan::where('nisn', $nisn)
                ->where('kode_kelas', $kode_kelas)
                ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
                ->where('id_semster', Semester::GetAktifSemester()->id)
                ->first();
        }
        return $is_siswa;
    }

    public function getEkskul($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $getData = PnEkskul::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_semster', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->get();
        return $getData;
    }

    public function GetAbsesni($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $ijin = Absensi::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_semester', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->where('status_absensi', 'Ijin')->count();
        $sakit = Absensi::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_semester', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->where('status_absensi', 'Sakit')->count();
        $tanpa_keterangan = Absensi::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_semester', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->where('status_absensi', 'Tanpa Keterangan')->count();
        $is_data = [
            'ijin' => $ijin,
            'sakit' => $sakit,
            'tanpa_keterangan' => $tanpa_keterangan
        ];
        return $is_data;
    }

    public function getPnSikap($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $get_pn = PnSikap::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_smester', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->first();
        $is_data = '-';
        if ($get_pn != null) {
            $is_data = explode (",",$get_pn->desc_pn);
            $is_data[0] = "Ananda ".$get_pn->Siswa->nama;
            $is_data = implode(", ", $is_data);
        }
        return $is_data;
    }

     public function getNilaiK13Raport($nisn, $kode_kelas)
    {
        // nilai keterampilan
        $nilai_kd = PnKeterampilan::with('kd')
            ->where('nisn', $nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('nilai_keterampilan', '<>', 0);
        $list_nilai_kd = $nilai_kd->get();
        $kd_array = $nilai_kd->where('type_nilai_keterampilan', 'nilai_kd')->pluck('kode_kd')->toArray('kode_kd');
        $is_data = [];
        $is_nilai_kd = [];
        foreach ($list_nilai_kd as $key => $value) {
            if ($value->type_nilai_keterampilan === 'nilai_kd') {
                $list['nilai_kd'] = $value->nilai_total;
            }elseif($value->type_nilai_keterampilan === 'nilai_pts'){
                $list['nilai_pts'] = $value->nilai_total;
            }elseif($value->type_nilai_keterampilan === 'nilai_pas'){
                $list['nilai_pas'] = $value->nilai_total;
            }
            $is_nilai_kd[$value->kd->kode_mt] = $list;
        }
        $is = [];
        foreach ($is_nilai_kd as $keys => $nilai) {
            $is[$keys] = ($nilai['nilai_kd'] + $nilai['nilai_pts'] + $nilai['nilai_pas']) / 3;
        }
        $materi_belajar = KompetensiDasar::whereIn('kode_kd', $kd_array)->get();
        $a = [];
        foreach ($materi_belajar as $keys => $values) {
            $int['nama_kd'] = $values['nama_kd'];
            $a[$values['kode_mt']][] = $int;
        }
        // end nilai keterampilan

        // nilai pengetahuan
        $nilai_kd_p = PnPengetahuan::with('kd')
            ->where('nisn', $nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('nilai_pengetahuan', '<>', 0)->get();

        $kd_array_p_s = PnPengetahuan::with('kd')
            ->where('nisn', $nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('type_nilai_pengetahuan', 'nilai_kd')->pluck('kode_kd')->toArray('kode_kd');

        $is_nilai_kd_p = [];
        foreach ($nilai_kd_p as $key_p => $value_p) {
            if ($value_p->type_nilai_pengetahuan === 'nilai_kd') {
                $list_p['nilai_kd'] = $value_p->nilai_total;
            }elseif($value_p->type_nilai_pengetahuan === 'nilai_pts'){
                $list_p['nilai_pts'] = $value_p->nilai_total;
            }elseif($value_p->type_nilai_pengetahuan === 'nilai_pas'){
                $list_p['nilai_pas'] = $value_p->nilai_total;
            }
            $is_nilai_kd_p[$value_p->kd->kode_mt] = $list_p;
        }
        $is_p = [];
        foreach ($is_nilai_kd_p as $keys_p => $nilai_p) {
            $is_p[$keys_p] = ($nilai_p['nilai_kd'] + $nilai_p['nilai_pts'] + $nilai_p['nilai_pas']) / 3;
        }
        $materi_belajar_p = KompetensiDasar::whereIn('kode_kd', $kd_array_p_s)->get();
        $a_p = [];
        foreach ($materi_belajar_p as $keys_p => $values_p) {
            $int_p['nama_kd'] = $values_p['nama_kd'];
            $a_p[$values_p['kode_mt']][] = $int_p;
        }
        array_push($is_data, $is, $a, $is_p, $a_p);
        return $is_data;
    }

    public function getPnSaran($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $get_saran = PnSaran::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_semster', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->first();
        return $get_saran;
    }

    public function getPnTinggidanBB($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran; 
        $get_TgdanBB_1 = PnBBdanTB::where('kode_kurikulum', $aktif_kurikulum)->where('id_semster', 1)->where('id_tahun_ajaran', $tahun_ajaran)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->first();
        $get_TgdanBB_2 = PnBBdanTB::where('kode_kurikulum', $aktif_kurikulum)->where('id_semster', 2)->where('id_tahun_ajaran', $tahun_ajaran)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->first();

        $is_data = [
            'smt_1' => $get_TgdanBB_1,
            'smt_2' => $get_TgdanBB_2,
        ];

        return $is_data;
    }

    public function getKondisiKesatan($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $get_kondisi_kesahtan = PnKondisiKesehatan::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_semster', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->get();
        return $get_kondisi_kesahtan;
    }

    public function getPrestasi($nisn, $kode_kelas)
    {
        $aktif_kurikulum = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $semester = Semester::GetAktifSemester()->id;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $get_prestasi = PnPrestasi::where('kode_kurikulum', $aktif_kurikulum)->where('id_tahun_ajaran', $tahun_ajaran)->where('id_semster', $semester)->where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->get();
        return $get_prestasi;
    }

    public function AjaxGetSiswaKelas(Request $request)
    {
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $query = [
            ['kode_kelas', $request->kode_kelas],
            ['id_tahun_ajaran', $tahun_ajaran],
        ];
        $list_siswa = KelasSiswa::with('Siswa')->where($query)->get();
        return response()->json($list_siswa);
    }

}
