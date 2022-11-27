<?php

namespace App\Http\Controllers;

use App\Ekskul;
use App\Kelas;
use App\KelasSiswa;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Ui\Presets\React;
use PhpParser\Node\Expr\New_;

class PenilaianControlle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kurikulum = Kurikulum::GetAktiveKurikulum();
        $title = 'Penilaian Siswa';
        $nik_wali_kelas = Auth::user()->user_code;
        $kelas = Kelas::where('nik', $nik_wali_kelas)->first();
        $list_siswa = Siswa::whereHas('sisiwakelas', function($q) use ($kelas)
                {
                    $q->where('kode_kelas', $kelas->kode_kelas);
                    $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);  
                })->get();
        return view('penilaian.index', compact('title', 'kurikulum','list_siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    public function AjaxGetSiswa(Request $request)
    {
        $nisn = $request->nisn;
        $tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran();
        $siswa = Siswa::where('nisn', $nisn)->first();
        $siswa_kelas = KelasSiswa::where('nisn', $nisn)->where('id_tahun_ajaran', $tahun_ajaran->id_tahun_ajaran)->first();
        $kelas = Kelas::where('kode_kelas', $siswa_kelas->kode_kelas)->first();
        $pn_sikap = PnSikap::where('nisn', $siswa->nisn)
            ->where('kode_kelas', $siswa_kelas->kode_kelas)
            ->where('id_smester', Semester::GetAktifSemester()->id)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum)
            ->first();
        $data = [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'pn_sikap' => $pn_sikap,
        ];
        return response()->json($data);
    }

    public function AjaxPnSikap(Request $request)
    {
        if ($request->id_pn_sikap != null) {
            $save_pn_sikap  = PnSikap::where('id_pn_sikap', $request->id_pn_sikap)->first();
            $message = 'berhasil ubah data';
        } else {
            $save_pn_sikap  = new PnSikap();
            $message = 'berhasil simpan data';
        }
        $siswa = Siswa::where('nisn', $request->siswa_nisn)->first();
        $save_pn_sikap->nisn                = $request->siswa_nisn;
        $save_pn_sikap->nama_siswa          = $siswa->nama;
        $save_pn_sikap->id_smester          = Semester::GetAktifSemester()->id;
        $save_pn_sikap->id_tahun_ajaran     = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
        $save_pn_sikap->kode_kurikulum      = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
        $save_pn_sikap->kode_kelas          = $request->kelas;
        $save_pn_sikap->beribadah           = $request->n1_beribadah;
        $save_pn_sikap->syukur              = $request->n2_syukur;
        $save_pn_sikap->berdoa              = $request->n3_berdoa;
        $save_pn_sikap->toleransi           = $request->n4_toleransi;
        $save_pn_sikap->desc_pn             = 'Ananda '.$siswa->nama.', '.$request->n1_beribadah.', '.$request->n2_syukur.', '.$request->n3_berdoa.', '.$request->n4_toleransi.'.';
        $save_pn_sikap->save();
        return response()->json($message);
    }

    // function ajax get pn pengetahuan
    public function AjaxPnPengetahuan(Request $request)
    {
        $siswa_nisn = $request->siswa_nisn;
        $kode_kelas = $request->kode_kelas;
        $kurikulum = Kurikulum::GetAktiveKurikulum();
        $list_mapel = MataPelajaran::where('kode_kurikulum', $kurikulum->kode_kurikulum)
            ->where('kode_kelas', $kode_kelas)->get();
        $list_kd = KompetensiDasar::with(['Pegetahuan' => function ($q) use ($siswa_nisn, $kode_kelas)
        {   
            $q->where('nisn', $siswa_nisn);
            $q->where('kode_kelas', $kode_kelas);
            $q->whereIn('type_nilai_pengetahuan', ['nilai_kd', 'nilai_pts', 'nilai_pas']);
            $q->where('id_semster', Semester::GetAktifSemester()->id);
            $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);
            $q->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
        }])->where('type', 'Pengetahuan')->where('id_semester', Semester::GetAktifSemester()->id)->get()->groupBy('kode_mt');
        $count = KompetensiDasar::select(DB::raw('kode_mt,count(*) as count'))
        ->where('type', 'Pengetahuan')->where('id_semester', Semester::GetAktifSemester()->id)->groupBy('kode_mt')->pluck('count', 'kode_mt');

        $data = [
            'list_mapel' => $list_mapel,
            'list_kd'    => $list_kd,
            'count' => $count
        ];
        return response()->json($data);
    }

    public function AjaxPnKeterampilan(Request $request)
    {
        $siswa_nisn = $request->siswa_nisn;
        $kode_kelas = $request->kode_kelas;
        $kurikulum = Kurikulum::GetAktiveKurikulum();
        $list_mapel = MataPelajaran::where('kode_kurikulum', $kurikulum->kode_kurikulum)
            ->where('kode_kelas', $kode_kelas)->get();
        $list_kd = KompetensiDasar::with(['Keterampilan' => function ($q) use ($siswa_nisn, $kode_kelas)
        {   
            $q->where('nisn', $siswa_nisn);
            $q->where('kode_kelas', $kode_kelas);
            $q->whereIn('type_nilai_keterampilan', ['nilai_kd', 'nilai_pts', 'nilai_pas']);
            $q->where('id_semster', Semester::GetAktifSemester()->id);
            $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);
            $q->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
        }])->where('type', 'Keterampilan')->where('id_semester', Semester::GetAktifSemester()->id)->get()->groupBy('kode_mt');
        $count = KompetensiDasar::select(DB::raw('kode_mt,count(*) as count'))
        ->where('type', 'Keterampilan')->where('id_semester', Semester::GetAktifSemester()->id)->groupBy('kode_mt')->pluck('count', 'kode_mt');

        $data = [
            'list_mapel' => $list_mapel,
            'list_kd'    => $list_kd,
            'count' => $count
        ];
        return response()->json($data);
    }

    public function AjaxPnPengetahuanSave(Request $request)
    {
        // $data = $request->all();
        $siswa_nisn     = $request->siswa_nisn;
        $kode_kelas     = $request->kode_kelas;
        $arr_nilai_kd   = $request->nilai_kd;
        $arr_nilai_pts  = $request->nilai_pts;
        $arr_nilai_pas  = $request->nilai_pas;

        DB::beginTransaction();
        try {

            $is_cek_data = PnPengetahuan::where('nisn', $siswa_nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
            
            if ($is_cek_data->count() > 0) {
                $delete = $is_cek_data;
                $delete->delete();
            }

            foreach ($arr_nilai_kd as $nilai_kd_key => $nilai_kd) { // save nilai kd 
                    $nest_kd                         = new PnPengetahuan();
                    $nest_kd->nisn                   = $siswa_nisn;
                    $nest_kd->nama_siswa             = Siswa::GetSiswaByNisn($siswa_nisn)->nama;
                    $nest_kd->id_semster             = Semester::GetAktifSemester()->id;
                    $nest_kd->id_tahun_ajaran        = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                    $nest_kd->kode_kurikulum         = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                    $nest_kd->kode_kelas             = $kode_kelas;
                    $nest_kd->type_nilai_pengetahuan = 'nilai_kd';
                    $nest_kd->nilai_total            = $request->pengetahuan_nilai_totoal_kd[$nilai_kd_key];
                    $nest_kd->kode_kd                =  $request->id_kd[$nilai_kd_key];
                    $nest_kd->nilai_pengetahuan      = $nilai_kd;
                    $nest_kd->save();
            }
            foreach ($arr_nilai_pts as $nilai_pts_key => $nilai_pts) { // save nilai pts
                    $nest_pts                         = new PnPengetahuan();
                    $nest_pts->nisn                   = $siswa_nisn;
                    $nest_pts->nama_siswa             = Siswa::GetSiswaByNisn($siswa_nisn)->nama;
                    $nest_pts->id_semster             = Semester::GetAktifSemester()->id;
                    $nest_pts->id_tahun_ajaran        = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                    $nest_pts->kode_kurikulum         = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                    $nest_pts->kode_kelas             = $kode_kelas;
                    $nest_pts->type_nilai_pengetahuan = 'nilai_pts';
                    $nest_pts->nilai_total            = $request->pengetahuan_nilai_totoal_pts[$nilai_pts_key];
                    $nest_pts->kode_kd                =  $request->id_kd[$nilai_pts_key];
                    $nest_pts->nilai_pengetahuan      = $nilai_pts;
                    $nest_pts->save();
            }
            foreach ($arr_nilai_pas as $nilai_pas_key => $nilai_pas) { // save nilai pas
                    $nest_pas                         = new PnPengetahuan();
                    $nest_pas->nisn                   = $siswa_nisn;
                    $nest_pas->nama_siswa             = Siswa::GetSiswaByNisn($siswa_nisn)->nama;
                    $nest_pas->id_semster             = Semester::GetAktifSemester()->id;
                    $nest_pas->id_tahun_ajaran        = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                    $nest_pas->kode_kurikulum         = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                    $nest_pas->kode_kelas             = $kode_kelas;
                    $nest_pas->type_nilai_pengetahuan = 'nilai_pas';
                    $nest_pas->nilai_total            = $request->pengetahuan_nilai_totoal_pas[$nilai_pas_key];
                    $nest_pas->kode_kd                =  $request->id_kd[$nilai_pas_key];
                    $nest_pas->nilai_pengetahuan      = $nilai_pas;
                    $nest_pas->save();
            }

            $data = [
                'status' => 200,
                'response'  => 'Berhasil simpan data'
            ];

            DB::commit();
            return response()->json($data);
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'response'  => 'Gagal simpan data',
                'error'     => $th->getMessage().'/'.$th->getLine(),
            ];
            return response()->json($data);
        }

        return response()->json($data = ['Gagal simpan data']);
    }

    public function AjaxPnKeterampilanSave(Request $request)
    {
        // $data = $request->all();
        $siswa_nisn     = $request->siswa_nisn;
        $kode_kelas     = $request->kode_kelas;
        $arr_nilai_kd   = $request->nilai_kd;
        $arr_nilai_pts  = $request->nilai_pts;
        $arr_nilai_pas  = $request->nilai_pas;

        DB::beginTransaction();
        try {

            $is_cek_data = PnKeterampilan::where('nisn', $siswa_nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
            
            if ($is_cek_data->count() > 0) {
                $delete = $is_cek_data;
                $delete->delete();
            }

            foreach ($arr_nilai_kd as $nilai_kd_key => $nilai_kd) { // save nilai kd 
                    $nest_kd                         = new PnKeterampilan();
                    $nest_kd->nisn                   = $siswa_nisn;
                    $nest_kd->nama_siswa             = Siswa::GetSiswaByNisn($siswa_nisn)->nama;
                    $nest_kd->id_semster             = Semester::GetAktifSemester()->id;
                    $nest_kd->id_tahun_ajaran        = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                    $nest_kd->kode_kurikulum         = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                    $nest_kd->kode_kelas             = $kode_kelas;
                    $nest_kd->type_nilai_keterampilan = 'nilai_kd';
                    $nest_kd->nilai_total            = $request->keterampilan_nilai_totoal_kd[$nilai_kd_key];
                    $nest_kd->kode_kd                =  $request->id_kd[$nilai_kd_key];
                    $nest_kd->nilai_keterampilan      = $nilai_kd;
                    $nest_kd->save();
            }
            foreach ($arr_nilai_pts as $nilai_pts_key => $nilai_pts) { // save nilai pts
                    $nest_pts                         = new PnKeterampilan();
                    $nest_pts->nisn                   = $siswa_nisn;
                    $nest_pts->nama_siswa             = Siswa::GetSiswaByNisn($siswa_nisn)->nama;
                    $nest_pts->id_semster             = Semester::GetAktifSemester()->id;
                    $nest_pts->id_tahun_ajaran        = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                    $nest_pts->kode_kurikulum         = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                    $nest_pts->kode_kelas             = $kode_kelas;
                    $nest_pts->type_nilai_keterampilan = 'nilai_pts';
                    $nest_pts->nilai_total            = $request->keterampilan_nilai_totoal_pts[$nilai_pts_key];
                    $nest_pts->kode_kd                =  $request->id_kd[$nilai_pts_key];
                    $nest_pts->nilai_keterampilan      = $nilai_pts;
                    $nest_pts->save();
            }
            foreach ($arr_nilai_pas as $nilai_pas_key => $nilai_pas) { // save nilai pas
                    $nest_pas                         = new PnKeterampilan();
                    $nest_pas->nisn                   = $siswa_nisn;
                    $nest_pas->nama_siswa             = Siswa::GetSiswaByNisn($siswa_nisn)->nama;
                    $nest_pas->id_semster             = Semester::GetAktifSemester()->id;
                    $nest_pas->id_tahun_ajaran        = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                    $nest_pas->kode_kurikulum         = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                    $nest_pas->kode_kelas             = $kode_kelas;
                    $nest_pas->type_nilai_keterampilan = 'nilai_pas';
                    $nest_pas->nilai_total            = $request->keterampilan_nilai_totoal_pas[$nilai_pas_key];
                    $nest_pas->kode_kd                =  $request->id_kd[$nilai_pas_key];
                    $nest_pas->nilai_keterampilan      = $nilai_pas;
                    $nest_pas->save();
            }

            $data = [
                'status' => 200,
                'response'  => 'Berhasil simpan data'
            ];

            DB::commit();
            return response()->json($data);
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'response'  => 'Gagal simpan data',
                'error'     => $th->getMessage().'/'.$th->getLine(),
            ];
            return response()->json($data);
        }

        return response()->json($data = ['Gagal simpan data']);
    }

    public function AjaxGetEkstrakulikuler(Request $request)
    {
        $siswa_nisn = $request->siswa_nisn;
        $kode_kelas = $request->kode_kelas;
        $list_extrakulikuler = Ekskul::where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)->with(['pnekskul' => function($q) use ($siswa_nisn, $kode_kelas)
        {
            $q->where('nisn', $siswa_nisn);
            $q->where('kode_kelas', $kode_kelas);
            $q->where('id_semster', Semester::GetAktifSemester()->id);
            $q->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran);
            $q->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
        }])->get();
        return response()->json($list_extrakulikuler);
    }

    public function AjaxPnGetSaranSaran(Request $request)
    {
        $siswa_nisn = $request->siswa_nisn;
        $kode_kelas = $request->kode_kelas;
        $list_saran_saran = PnSaran::where('nisn', $siswa_nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum)
        ->get();
        return response()->json($list_saran_saran);
    }

    public function AjaxPnGetBeratDanTinggiBadan(Request $request)
    {
        $siswa_nisn = $request->siswa_nisn;
        $kode_kelas = $request->kode_kelas;
        $list_berat_dan_tinggi_badan = PnBBdanTB::where('nisn', $siswa_nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum)
        ->get();
        return response()->json($list_berat_dan_tinggi_badan);
    }

    public function AjaxPnGetKondisiKesehatan(Request $request)
    {
        $siswa_nisn = $request->siswa_nisn;
        $kode_kelas = $request->kode_kelas;
        $list_kondisi_kesehatan = PnKondisiKesehatan::where('nisn', $siswa_nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum)
        ->get();
        return response()->json($list_kondisi_kesehatan);
    }

    public function AjaxPnGetPrestasi(Request $request)
    {
        $siswa_nisn = $request->siswa_nisn;
        $kode_kelas = $request->kode_kelas;
        $list_prestasi = PnPrestasi::where('nisn', $siswa_nisn)
            ->where('kode_kelas', $kode_kelas)
            ->where('id_semster', Semester::GetAktifSemester()->id)
            ->where('id_tahun_ajaran', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
            ->where('kode_kurikulum', Kurikulum::GetAktiveKurikulum()->kode_kurikulum)
        ->get();
        return response()->json($list_prestasi);
    }

    public function AjaxPnLainLainSave(Request $request)
    {
        DB::beginTransaction();
        try {

            if (isset($request->id_pn_ekskul)) {
                PnEkskul::whereIn('id_pn_ekskul', $request->id_pn_ekskul)->delete(); 
            }

            if (isset($request->id_saran)) {
                PnSaran::where('id_pn_saran', $request->id_saran)->delete();
            }

            if (isset($request->id_tinggi_dan_berat_badan)) {
                PnBBdanTB::where('id_pn_bb', $request->id_tinggi_dan_berat_badan)->delete();
            }

            if (isset($request->id_pn_kondisi_kesehatan)) {
                PnKondisiKesehatan::whereIn('id_pn_kondisi_kesehatan', $request->id_pn_kondisi_kesehatan)->delete(); 
            }

            if (isset($request->id_pn_prestasi)) {
                PnPrestasi::whereIn('id_pn_prestasi', $request->id_pn_prestasi)->delete(); 
            }

            // save pn ekskul
            foreach ($request->kode_ekskul as $ekskul_key => $ekskul) {
                $pn_ekskul                  = new PnEkskul();
                $pn_ekskul->nisn            = $request->siswa_nisn;
                $pn_ekskul->nama_siswa      = Siswa::GetSiswaByNisn($request->siswa_nisn)->nama;
                $pn_ekskul->id_semster      = Semester::GetAktifSemester()->id;
                $pn_ekskul->id_tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                $pn_ekskul->kode_kurikulum  = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                $pn_ekskul->kode_kelas      = $request->kode_kelas;
                $pn_ekskul->kode_ekskul     = $ekskul;
                $pn_ekskul->keterangan      = $request->ket_ekskul[$ekskul_key];
                $pn_ekskul->created_at      = date('Y-m-d H:i:s');
                $pn_ekskul->save();
            }

            // save pn saran-saran
            $pn_saran_saran = new PnSaran();
            $pn_saran_saran->nisn            = $request->siswa_nisn;
            $pn_saran_saran->nama_siswa      = Siswa::GetSiswaByNisn($request->siswa_nisn)->nama;
            $pn_saran_saran->id_semster      = Semester::GetAktifSemester()->id;
            $pn_saran_saran->id_tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
            $pn_saran_saran->kode_kurikulum  = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
            $pn_saran_saran->kode_kelas      = $request->kode_kelas;
            $pn_saran_saran->saran           = $request->saran_saran;
            $pn_saran_saran->created_at      = date('Y-m-d H:i:s');
            $pn_saran_saran->save();

            // save tinggi dan berat badan
            $pn_tinggi_dan_berat_badan  = new PnBBdanTB();
            $pn_tinggi_dan_berat_badan->nisn            = $request->siswa_nisn;
            $pn_tinggi_dan_berat_badan->nama_siswa      = Siswa::GetSiswaByNisn($request->siswa_nisn)->nama;
            $pn_tinggi_dan_berat_badan->id_semster      = Semester::GetAktifSemester()->id;
            $pn_tinggi_dan_berat_badan->id_tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
            $pn_tinggi_dan_berat_badan->kode_kurikulum  = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
            $pn_tinggi_dan_berat_badan->kode_kelas      = $request->kode_kelas;
            $pn_tinggi_dan_berat_badan->tinggi_badan    = $request->tinggi_badan;
            $pn_tinggi_dan_berat_badan->berat_badan     = $request->berat_badan;
            $pn_tinggi_dan_berat_badan->created_at      = date('Y-m-d H:i:s');
            $pn_tinggi_dan_berat_badan->save();

            // save kondisi kesehatan
            foreach ($request->konisi as $key_kondisi_kesehatan => $kondisi_kesehatan) {
                $pn_kondisi_kesehatan = new PnKondisiKesehatan();
                $pn_kondisi_kesehatan->nisn            = $request->siswa_nisn;
                $pn_kondisi_kesehatan->nama_siswa      = Siswa::GetSiswaByNisn($request->siswa_nisn)->nama;
                $pn_kondisi_kesehatan->id_semster      = Semester::GetAktifSemester()->id;
                $pn_kondisi_kesehatan->id_tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                $pn_kondisi_kesehatan->kode_kurikulum  = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                $pn_kondisi_kesehatan->kode_kelas      = $request->kode_kelas;
                $pn_kondisi_kesehatan->kondisi         = $kondisi_kesehatan;
                $pn_kondisi_kesehatan->ket_kondisi     = $request->ket_konisi[$key_kondisi_kesehatan];
                $pn_kondisi_kesehatan->created_at      = date('Y-m-d H:i:s');
                $pn_kondisi_kesehatan->save();
            }

            // save prestasi
            foreach ($request->prestasi as $key_prestasi => $prestasi) {
                $pn_prestasi = new PnPrestasi();
                $pn_prestasi->nisn            = $request->siswa_nisn;
                $pn_prestasi->nama_siswa      = Siswa::GetSiswaByNisn($request->siswa_nisn)->nama;
                $pn_prestasi->id_semster      = Semester::GetAktifSemester()->id;
                $pn_prestasi->id_tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                $pn_prestasi->kode_kurikulum  = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                $pn_prestasi->kode_kelas      = $request->kode_kelas;
                $pn_prestasi->prestasi        = $prestasi;
                $pn_prestasi->ket_prestasi    = $request->ket_prestasi[$key_prestasi];
                $pn_prestasi->created_at      = date('Y-m-d H:i:s');
                $pn_prestasi->save();
            }
            
            $data = [
                'status' => 200,
                'response'  => 'Berhasil simpan data'
            ];

            Log::info($data);
            DB::commit();
            return response()->json($data);
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'response'  => 'Gagal simpan data',
                'error'     => $th->getMessage().'/'.$th->getLine(),
            ];
            Log::info($data);
            return response()->json($data);
        }
        return response()->json($data = ['Gagal simpan data']);
    }

    public function AjaxPnGetForSum(Request $request)
    {
        $nisn = $request->nisn;
        $kode_kelas = $request->kode_kelas;
        $mata_pelajaran = MataPelajaran::where('kode_kurikulum', Kurikulum::Prototype)
            ->with(['MateriPembelajaran' => function ($query) use ($nisn){
                $query->with(['TujuanPembelajaran' => function($qer) use ($nisn){
                    $qer->with(['PnFmSm' => function($res) use ($nisn){
                        return $res->where('nisn', '=', $nisn)
                            ->where('id_semester', '=', Semester::GetAktifSemester()->id)
                            ->where('id_tahun_ajaran', '=', TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran)
                            ->where('kode_kurikulum', '=', Kurikulum::GetAktiveKurikulum()->kode_kurikulum);
                    }]);
                }]);
            }])
            ->where('kode_kelas', '=', $request->kelas_siswa)
            ->get();

        $count_mata_pelajaran = MateriPembelajaran::select(DB::raw('kode_mt,count(*) as count'))
            ->where('id_semester', Semester::GetAktifSemester()->id)
            ->groupBy('kode_mt')->pluck('count', 'kode_mt');

        $count_mata_tj = MateriPembelajaran::select(DB::raw('materi_pembelajaran.kode_mt,count(*) as count'))
            ->join('tabel_tujuan_plj', 'tabel_tujuan_plj.kode_materi', '=' ,'materi_pembelajaran.kode_materi')
            ->where('materi_pembelajaran.id_semester', Semester::GetAktifSemester()->id)
            ->groupBy('materi_pembelajaran.kode_mt')->pluck('materi_pembelajaran.count', 'materi_pembelajaran.kode_mt');

        $count_materi_pelajaran = TujuanPembelajaran::select(DB::raw('kode_materi,count(*) as count'))
            ->where('id_semester', Semester::GetAktifSemester()->id)
            ->groupBy('kode_materi')->pluck('count', 'kode_materi');

        $data = [
            'mata_pelajaran' => $mata_pelajaran,
            'count_mata_pelajaran' => $count_mata_pelajaran,
            'count_materi_pelajaran' => $count_materi_pelajaran,
            'count_mata_tj' => $count_mata_tj
        ];

        return response()->json($data);
    }

    public function AjaxSavePnSmFm(Request $request)
    {
        DB::beginTransaction();
        try {
            $message = 'Simpan';
            if (isset($request->id_pn_fm_sm)) {
                PnSmFm::whereIn('id_penilaian_fm_sm', $request->id_pn_fm_sm)->delete();
                $message = 'Simpan';
            }
            $array_nilai_foramtif       = [];
            $array_nilai_sumatif        = [];
            $array_nilai_akhir_sumatif  = [];
            foreach ($request->kode_mt as $key_mt => $kode_mt) {
                $array_nilai_foramtif[$kode_mt]      = $request->nilai_formatif[$key_mt];
                $array_nilai_sumatif[$kode_mt]       = $request->nilai_sumatif[$key_mt];
                $array_nilai_akhir_sumatif[$kode_mt] = $request->nilai_akhir_sumatif[$key_mt];
            }
            $data = [];
            foreach ($request->nilai_fm_sm as $key_nilai => $nilai_fm_sm) {
                if ($nilai_fm_sm != null) {
                    $kode_mt = TujuanPembelajaran::GetKodeMTByKodeTujuan($request->kode_tujuan[$key_nilai])->MateriPembelajaran->kode_mt;
                    $save_penilaian                             = new PnSmFm();
                    $save_penilaian->nisn                       = $request->nisn; 
                    $save_penilaian->nama_siswa                 = Siswa::GetSiswaByNisn($request->nisn)->nama;
                    $save_penilaian->kode_tujuan                = $request->kode_tujuan[$key_nilai];
                    $save_penilaian->kode_mt                    = $kode_mt;
                    $save_penilaian->nilai_tp                   = $nilai_fm_sm;
                    $save_penilaian->nilai_formatif             = $array_nilai_foramtif[$kode_mt];
                    $save_penilaian->nilai_sumatif              = $array_nilai_sumatif[$kode_mt];
                    $save_penilaian->nilai_akhir_sumatif        = $array_nilai_akhir_sumatif[$kode_mt];
                    $save_penilaian->id_tahun_ajaran            = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                    $save_penilaian->id_semester                = Semester::GetAktifSemester()->id;
                    $save_penilaian->kode_kurikulum             = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                    $save_penilaian->kode_kelas                 = $request->kode_kelas;
                    $save_penilaian->save();
                }
            }
            $data = [
                'status' => 200,
                'response'  => 'Berhasil '.$message.' data'
            ];
            DB::commit();
            return response()->json($data);
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'response'  => 'Gagal '.$message.' data',
                'error'     => $th->getMessage().'/'.$th->getLine(),
            ];
            return response()->json($data);
        }
        return response()->json($data = ['Gagal '.$message.' data']); 
    }

    public function AjaxPnEkskul2022Save(Request $request)
    {
        DB::beginTransaction();
        try {

            if (isset($request->id_pn_ekskul_2022)) {
                PnEkskul::whereIn('id_pn_ekskul', $request->id_pn_ekskul_2022)->delete(); 
            }

            // save pn ekskul
            foreach ($request->kode_ekskul_2022 as $ekskul_key => $ekskul) {
                $pn_ekskul                  = new PnEkskul();
                $pn_ekskul->nisn            = $request->siswa_nisn;
                $pn_ekskul->nama_siswa      = Siswa::GetSiswaByNisn($request->siswa_nisn)->nama;
                $pn_ekskul->id_semster      = Semester::GetAktifSemester()->id;
                $pn_ekskul->id_tahun_ajaran = TahunAjaran::GetAktiveTahunAjaran()->id_tahun_ajaran;
                $pn_ekskul->kode_kurikulum  = Kurikulum::GetAktiveKurikulum()->kode_kurikulum;
                $pn_ekskul->kode_kelas      = $request->kode_kelas;
                $pn_ekskul->kode_ekskul     = $ekskul;
                $pn_ekskul->keterangan      = $request->ket_ekskul_2022[$ekskul_key];
                $pn_ekskul->created_at      = date('Y-m-d H:i:s');
                $pn_ekskul->save();
            }
            $data = [
                'status' => 200,
                'response'  => 'Berhasil simpan data'
            ];
            DB::commit();
            return response()->json($data);
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'response'  => 'Gagal simpan data',
                'error'     => $th->getMessage().'/'.$th->getLine(),
            ];
            Log::info($data);
            return response()->json($data);
        }
        return response()->json($data = ['Gagal simpan data']);
    }

    public function MonitoringPembelajaran(Request $request)
    {
        $list_siswa = Siswa::get();
        if (RoleUser::CheckRole()->user_role === RoleUser::WaliMurid) {
            $nisn = RoleUser::CheckRole()->user_code;
            $list_siswa = Siswa::where('nisn', $nisn)->first();
        }
        return view('penilaian/monitoring_penilaian', compact('list_siswa'));
    }

    public function AjaxGetListPenilaian(Request $request)
    {
        if (Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::K13) {
            $query = PnSikap::where('nisn', $request->nisn);
            $by_kelas = $query->distinct()->get('kode_kelas')->toArray('kode_kelas'); 
            $by_semester = [];
            foreach ($by_kelas as $key => $value) {
                $kelas_nama = Kelas::getbyId($value['kode_kelas'])->ket_kelas;
                $is_query_semester = PnSikap::select('id_smester', 'kode_kelas')->where('nisn', $request->nisn)->where('kode_kelas', $value['kode_kelas'])->distinct()->get('id_smester');
                $by_semester[$kelas_nama] = $is_query_semester;
            }
        } elseif(Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::Prototype) {
            $query = PnSmFm::where('nisn', $request->nisn);
            $by_kelas = $query->distinct()->get('kode_kelas')->toArray('kode_kelas'); 
            $by_semester = [];
            foreach ($by_kelas as $key => $value) {
                $kelas_nama = Kelas::getbyId($value['kode_kelas'])->ket_kelas;
                $is_query_semester = PnSmFm::select('id_semester', 'kode_kelas')->where('nisn', $request->nisn)->where('kode_kelas', $value['kode_kelas'])->distinct()->get('id_semester');
                $by_semester[$kelas_nama] = $is_query_semester;
            }
        }
        return response()->json($by_semester);
    }

    public function DetailPenilaian($nisn, $kode_kelas, $id_semester)
    {
        $query = [
            ['nisn', $nisn],
            ['kode_kelas', $kode_kelas]
        ];
        if (Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::Prototype) {  
            $query_smester = [
                ['id_semester', $id_semester]
            ];
            $data_siswa = PnSmFm::where($query)->where($query_smester)->first();
            $get_nilai = PnSmFm::where($query)->where($query_smester)->get()->groupby('kode_mt');
            $list_nilai_sm_fm = self::getNilaiK22($nisn, $kode_kelas, $id_semester);
            return view('penilaian/detail_penilaian_k22', compact('get_nilai', 'list_nilai_sm_fm', 'data_siswa'));
        } elseif(Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::K13) {
            $query_smester = [
                ['id_smester', $id_semester]
            ];
            $data_siswa = PnSikap::where($query)->where($query_smester)->first();
            $data_nilai_pengetahuan = self::getNilaiPengetahuan($nisn, $kode_kelas, $id_semester);
            $data_nilai_keterampilan = self::getNilaiKeterampilan($nisn, $kode_kelas, $id_semester);
            return view('penilaian/detail_penilaian_k13', compact('data_siswa', 'data_nilai_pengetahuan', 'data_nilai_keterampilan'));
        }

    }

    public function getNilaiK22($nisn, $kode_kelas, $id_semester)
    {
        $getNilai = PnSmFm::where('nisn', $nisn)->where('kode_kelas', $kode_kelas)->where('id_semester', $id_semester)->get();
        $list_nilai = [];
        foreach ($getNilai as $key => $value) {
            $list_nilai[$value['kode_mt']] = [
                'nilai_formatif' => $value['nilai_formatif'],
                'nilai_sumatif' => $value['nilai_sumatif'],
                'nilai_akhir_sumatif' => $value['nilai_akhir_sumatif']
            ];
        }
        return $list_nilai;
    }

    public function getNilaiPengetahuan($nisn, $kode_kelas, $id_semester)
    {
        $query = [
            ['nisn', $nisn],
            ['kode_kelas', $kode_kelas],
            ['id_semster', $id_semester],
            ['nilai_pengetahuan', '!=', 0]
        ];
        $get_kompetensi = KompetensiDasar::where('id_semester', $id_semester)->where('type', 'Pengetahuan')->get()->groupby('kode_mt'); 
        $list_kode_kd = [];
        $list_arr_data = [];
        foreach ($get_kompetensi as $key => $value) {
            $list_kode_kd[$key] = $value->pluck('kode_kd');
        }
        foreach ($list_kode_kd as $items => $val) {
            $penilaian = PnPengetahuan::where($query)->whereIn('kode_kd', $val)->get()->groupby('kode_kd');
            $list_arr_data[$items] = $penilaian;
        }
        return $list_arr_data;
    }

    public function getNilaiKeterampilan($nisn, $kode_kelas, $id_semester)
    {
        $query = [
            ['nisn', $nisn],
            ['kode_kelas', $kode_kelas],
            ['id_semster', $id_semester],
            ['nilai_keterampilan', '!=', 0]
        ];
        $get_kompetensi = KompetensiDasar::where('id_semester', $id_semester)->where('type', 'Keterampilan')->get()->groupby('kode_mt'); 
        $list_kode_kd = [];
        $list_arr_data = [];
        foreach ($get_kompetensi as $key => $value) {
            $list_kode_kd[$key] = $value->pluck('kode_kd');
        }
        foreach ($list_kode_kd as $items => $val) {
            $penilaian = PnKeterampilan::where($query)->whereIn('kode_kd', $val)->get()->groupby('kode_kd');
            $list_arr_data[$items] = $penilaian;
        }
        return $list_arr_data;
    }
}
