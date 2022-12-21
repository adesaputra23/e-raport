<?php

use App\Http\Controllers\PengumumanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// user route
Route::get('/', function () {
    return view('login');
});

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth::routes();
Route::get('/login', 'UserController@ShowLogin')->name('login');
Route::post('/proses-login', 'UserController@ProsesLogin')->name('proses.login');
Route::get('/logout', 'UserController@logout')->name('logout');

// siswa
Route::get('/siswa/lihat-data', 'SiswaController@LihatData')->name('siswa.lihat.data.admin');
Route::get('/siswa/detail-data/{nisn}', 'SiswaController@detailData')->name('siswa.detail.data.admin');

// mata pelajaran
Route::get('/mata-pelajaran', 'MataPelajaranController@index')->name('mata.pelajaran.lihat.data.admin');

// kompetesni dasar
Route::get('/kompetensi-dasar', 'KompetensiDasarController@index')->name('kompetensi.dasar.lihat.data.admin');
Route::get('/kompetensi-dasar/form-tambah-data/{id}', 'KompetensiDasarController@create')->name('kompetensi.dasar.form.tambah.data.admin');
Route::post('/kompetensi-dasar/simpan-data', 'KompetensiDasarController@store')->name('kompetensi.dasar.simpan.data.admin');
Route::get('/kompetensi-dasar/hapus-data/{id}', 'KompetensiDasarController@destroy')->name('kompetensi.dasar.hapus.data.admin');

// assesment penilaian kurikulum k22
Route::get('/assesment/materi', 'MateriPembelajaranK22Controller@index')->name('assesment.materi.index.admin');
Route::get('/assesment/materi/add-data/{id}', 'MateriPembelajaranK22Controller@MateriAddData')->name('assesment.materi.add.admin');
Route::post('/assesment/materi/save-data', 'MateriPembelajaranK22Controller@Save')->name('assesment.materi.save.admin');
Route::get('/assesment/materi/hapus-data/{id}', 'MateriPembelajaranK22Controller@Hapus')->name('assesment.materi.hapus.data.admin');

// assesment tujuan pembelajaran k22
Route::get('/assesment/tujuan-pembelajaran', 'TujuanPembelajaranController@index')->name('assesment.tujuan.pembelajaran.index.admin');
Route::get('/assesment/tujuan-pembelajaran/add-data/{id}', 'TujuanPembelajaranController@AddtujuanPebelajaran')->name('assesment.tujuan.pembelajaran.add.admin');
Route::post('/assesment/tujuan-pembelajaran/save-data', 'TujuanPembelajaranController@Save')->name('assesment.tujuan.pembelajaran.save.admin');
Route::get('/assesment/tujuan-pembelajaran/hapus-data/{id}', 'TujuanPembelajaranController@Hapus')->name('assesment.tujuan.pembelajaran.hapus.data.admin');

// absensi siswa
Route::get('/absensi', 'AbsensiController@index')->name('absensi.index');
Route::post('/absensi/simpan-data', 'AbsensiController@simpanData')->name('absensi.simpan.data');
Route::get('/absensi/hapus/{id}', 'AbsensiController@hapus')->name('absensi.hapus');
Route::get('/absensi/monitoring', 'AbsensiController@Monitoring')->name('absensi.monitoring');

// nilai raport
Route::get('/nilai-raport', 'RaportController@index')->name('nilai.raport.index');

// cetak raport
Route::get('cetak-raport/{nisn}/{kode_kelas}', 'RaportController@CetakRaport')->name('cetak-raport');

// monitoring pembalrajaran
Route::get('/pemlajaran/monitoring-pembelajaran', 'PenilaianControlle@MonitoringPembelajaran')->name('monitoring.pembelajaran');
Route::get('/pemlajaran/detail-penilaian/{nisn}/{kode_kelas}/{id_semester}', 'PenilaianControlle@DetailPenilaian')->name('detail.penilaian');

Route::group(['middleware'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

// admin route
Route::prefix('admin','middleware')->group(function(){
    Route::get('/', function(){
        return redirect()->route('login.admin');
    });
    Route::get('/login', 'UserController@ShowLogin')->name('login.admin');
    Route::post('/proses-login', 'UserController@ProsesLogin')->name('proses.login.admin');
    Route::get('/logout', 'UserController@logout')->name('logout.admin');
    Route::get('/home', 'HomeController@index')->name('home.admin');

    // kurikulum
    Route::get('/kurikulum/lihat-data', 'KurikulumController@LihatData')->name('kurikulum.lihat.data.admin');
    Route::get('/kurikulum/form-tambah-data/{kode_kurikulum}', 'KurikulumController@FormTambahData')->name('kurikulum.tambah.data.admin');
    Route::post('/kurikulum/simpan-data', 'KurikulumController@SimpanData')->name('kurikulum.simpan.data.admin');
    Route::get('/kurikulum/hapus-data/{kode_kurikulum}', 'KurikulumController@hapusData')->name('kurikulum.hapus.data.admin');

    // pegawai dan guru
    Route::get('/pegawai-guru/lihat-data', 'PegawaiDanGuruController@LihatData')->name('pegawai.lihat.data.admin');
    Route::get('/pegawai-guru/tambah-data/{nik}', 'PegawaiDanGuruController@TambahData')->name('pegawai.tambah.data.admin');
    Route::post('/pegawai-guru/simpan-data', 'PegawaiDanGuruController@SimpanData')->name('pegawai.simpan.data.admin');
    Route::get('/pegawai-guru/hapus-data/{nik}', 'PegawaiDanGuruController@hapusData')->name('pegawai.hapus.data.admin');
    Route::get('/pegawai-guru/detail-data/{nik}', 'PegawaiDanGuruController@detailData')->name('pegawai.detail.data.admin');

    // user
    Route::get('/user/lihat-data', 'HomeController@LihatDataUser')->name('user.lihat.data.admin');
    Route::post('/user/post-roel', 'HomeController@SaveRole')->name('user.save.role.admin');

    // siswa
    Route::get('/siswa/lihat-data', 'SiswaController@LihatData')->name('siswa.lihat.data.admin');
    Route::get('/siswa/form-tambah-data/{nisn}', 'SiswaController@FormTambahData')->name('siswa.form.tambah.data.admin');
    Route::post('/siswa/simpan-data', 'SiswaController@SimpanData')->name('siswa.simpan.data.admin');
    Route::get('/siswa/hapus-data/{nisn}', 'SiswaController@hapusData')->name('siswa.hapus.data.admin');
    Route::get('/siswa/detail-data/{nisn}', 'SiswaController@detailData')->name('siswa.detail.data.admin');
    Route::post('/siswa/ubah-nisn', 'SiswaController@ubahNisn')->name('siswa.ubah.nisn.admin');

    // tahun ajaran
    Route::get('/tahun-ajaran/lihat-data', 'TahunAjaranController@LihatData')->name('tahun.ajaran.lihat.data.admin');
    Route::get('/tahun-ajaran/form-tambah-data/{id}', 'TahunAjaranController@FormTambahData')->name('tahun.ajaran.form.tambah.data.admin');
    Route::post('/tahun-ajaran/simpan-data', 'TahunAjaranController@SimpanData')->name('tahun.ajaran.simpan.data.admin');
    Route::get('/tahun-ajaran/hapus-data/{id}', 'TahunAjaranController@hapusData')->name('tahun.ajaran.hapus.data.admin');

    // semester update
    Route::get('/tahun-ajaran/semester/{id}', 'TahunAjaranController@UpdateSemster')->name('tahun.ajaran.update.semester.admin');

    // kelas
    Route::get('/kelas/lihat-data', 'KelasController@LihatData')->name('kelas.lihat.data.admin');
    Route::get('/kelas/form-tambah-data/{id}', 'KelasController@FormTambahData')->name('kelas.form.tambah.data.admin');
    Route::post('/kelas/simpan-data', 'KelasController@SimpanData')->name('kelas.simpan.data.admin');
    Route::get('/kelas/hapus-data/{id}', 'KelasController@hapusData')->name('kelas.hapus.data.admin');
    Route::post('/kelas/set-wali-kelas', 'KelasController@setWaliKelas')->name('kelas.set.wali.kelas.admin');

    // kelas siswa
    Route::get('/kelas-siswa/lihat-data', 'KelasSiswaController@LihatData')->name('kelas.siswa.lihat.data.admin');
    Route::get('/kelas-siswa/form-tambah-data/{id}', 'KelasSiswaController@FormTambahData')->name('kelas.siswa.form.tambah.data.admin');
    Route::post('/kelas-siswa/simpan-data', 'KelasSiswaController@SimpanData')->name('kelas.siswa.simpan.data.admin');
    Route::get('/kelas-siswa/hapus-data/{id}', 'KelasSiswaController@hapusData')->name('kelas.siswa.hapus.data.admin');

    // mata pelajaran
    Route::get('/mata-pelajaran', 'MataPelajaranController@index')->name('mata.pelajaran.lihat.data.admin');
    Route::get('/mata-pelajaran/form-tambah-data/{id}', 'MataPelajaranController@create')->name('mata.pelaran.form.tambah.data.admin');
    Route::post('/mata-pelajaran/simpan-data', 'MataPelajaranController@store')->name('mata.pelajaran.simpan.data.admin');
    Route::get('/mata-pelajaran/hapus-data/{id}', 'MataPelajaranController@destroy')->name('mata.pelajaran.hapus.data.admin');

    // kompetesni dasar
    Route::get('/kompetensi-dasar', 'KompetensiDasarController@index')->name('kompetensi.dasar.lihat.data.admin');
    Route::get('/kompetensi-dasar/form-tambah-data/{id}', 'KompetensiDasarController@create')->name('kompetensi.dasar.form.tambah.data.admin');
    Route::post('/kompetensi-dasar/simpan-data', 'KompetensiDasarController@store')->name('kompetensi.dasar.simpan.data.admin');
    Route::get('/kompetensi-dasar/hapus-data/{id}', 'KompetensiDasarController@destroy')->name('kompetensi.dasar.hapus.data.admin');

    // nilai kkm
    Route::post('/kkm/simpan-data', 'MataPelajaranController@UbahKKM')->name('mata.pelajaran.ubah.kkm.data.admin');

    // ekskul
    Route::get('/ekskul', 'EkskulController@index')->name('ekskul.lihat.data.admin');
    Route::get('/ekskul/form-tambah-data/{id}', 'EkskulController@create')->name('ekskul.form.tambah.data.admin');
    Route::post('/ekskul/simpan-data', 'EkskulController@store')->name('ekskul.simpan.data.admin');
    Route::get('/ekskul/hapus-data/{id}', 'EkskulController@destroy')->name('ekskul.hapus.data.admin');

    // assesment penilaian kurikulum k22
    Route::get('/assesment/materi', 'MateriPembelajaranK22Controller@index')->name('assesment.materi.index.admin');
    Route::get('/assesment/materi/add-data/{id}', 'MateriPembelajaranK22Controller@MateriAddData')->name('assesment.materi.add.admin');
    Route::post('/assesment/materi/save-data', 'MateriPembelajaranK22Controller@Save')->name('assesment.materi.save.admin');
    Route::get('/assesment/materi/hapus-data/{id}', 'MateriPembelajaranK22Controller@Hapus')->name('assesment.materi.hapus.data.admin');

    // assesment tujuan pembelajaran k22
    Route::get('/assesment/tujuan-pembelajaran', 'TujuanPembelajaranController@index')->name('assesment.tujuan.pembelajaran.index.admin');
    Route::get('/assesment/tujuan-pembelajaran/add-data/{id}', 'TujuanPembelajaranController@AddtujuanPebelajaran')->name('assesment.tujuan.pembelajaran.add.admin');
    Route::post('/assesment/tujuan-pembelajaran/save-data', 'TujuanPembelajaranController@Save')->name('assesment.tujuan.pembelajaran.save.admin');
    Route::get('/assesment/tujuan-pembelajaran/hapus-data/{id}', 'TujuanPembelajaranController@Hapus')->name('assesment.tujuan.pembelajaran.hapus.data.admin');

    // pengumuman
    Route::get('/pengumuman/index', 'PengumumanController@index')->name('pengumuman.index');
    Route::get('/pengumuman/form-data/{id}', 'PengumumanController@form_data')->name('penggumuman.form_data');
    Route::post('/pengumuman/save', 'PengumumanController@save')->name('penggumuman.save');
    Route::get('/pengumuman/delete/{id}', 'PengumumanController@delete')->name('penggumuman.delete');
    Route::get('/pengumuman/show/{id}', 'PengumumanController@show')->name('penggumuman.show');

});

// set jadwal ngajar kepala sekolah
Route::get('/mata-pelajaran/jadwal-ngajar', 'MataPelajaranController@jadwalNgajar')->name('mata.pelajaran.jadwal.ngajar');
Route::get('/mata-pelajaran/form-jadal-ngajar/{id}', 'MataPelajaranController@FormJadwalNgajar')->name('mata.pelajaran.form.jadwal.ngajar');
Route::post('/mata-pelajaran/save-jadal-ngajar', 'MataPelajaranController@SaveJadwalNgajar')->name('mata.pelajaran.save.jadwal.ngajar');
Route::get('/mata-pelajaran/delete-jadwal-ngajar/{id}', 'MataPelajaranController@JadwalNgajarDelete')->name('mata.pelajaran.delete.jadwal.ngajar');

// seting nip kepala sekolah
Route::get('/guru-pegawai/set-nip', 'PegawaiDanGuruController@SetNip')->name('guru.pegawai.set.nip');
Route::post('/guru-pegawai/save-nip', 'PegawaiDanGuruController@SaveNip')->name('guru.pegawai.save.nip');

// ajax get kelas
Route::post('/mata-pelajaran/ajax-get-mapel', 'MataPelajaranController@AjaxGetMapel');

// detail pengumuman
Route::get('/pengumuman/index', 'PengumumanController@index')->name('pengumuman.index');
Route::get('/pengumuman/show/{id}', 'PengumumanController@show')->name('penggumuman.show');

Route::get('/api', 'SiswaController@SiswaSerach')->name('siswa.api');

// penilaian ajax k13
Route::get('/penilaian', 'PenilaianControlle@index')->name('penilaian');
Route::get('/penilaian/ajax-get-siswa', 'PenilaianControlle@AjaxGetSiswa');
Route::get('/penilaian/ajax-save-pn-sikap', 'PenilaianControlle@AjaxPnSikap');
Route::get('/penilaian/ajax-get-pn-pengetahuan', 'PenilaianControlle@AjaxPnPengetahuan');
Route::post('/penilaian/ajax-save-pn-pengetahuan', 'PenilaianControlle@AjaxPnPengetahuanSave');
Route::get('/penilaian/ajax-get-pn-keterampilan', 'PenilaianControlle@AjaxPnKeterampilan');
Route::post('/penilaian/ajax-save-pn-keterampilan', 'PenilaianControlle@AjaxPnKeterampilanSave');
Route::get('/penilaian/ajax-get-ekstrakulikuler', 'PenilaianControlle@AjaxGetEkstrakulikuler');
Route::post('/penilaian/ajax-save-pn-lain-lain', 'PenilaianControlle@AjaxPnLainLainSave');
Route::get('/penilaian/ajax-get-saran-saran', 'PenilaianControlle@AjaxPnGetSaranSaran');
Route::get('/penilaian/ajax-get-berat-tinggi-badan', 'PenilaianControlle@AjaxPnGetBeratDanTinggiBadan');
Route::get('/penilaian/ajax-get-kondisi-kesehatan', 'PenilaianControlle@AjaxPnGetKondisiKesehatan');
Route::get('/penilaian/ajax-get-prestasi', 'PenilaianControlle@AjaxPnGetPrestasi');

// penilaian ajax k22
Route::get('/penilaian/ajax-get-pn-for-sum', 'PenilaianControlle@AjaxPnGetForSum');
Route::post('/penilaian/ajax-save-pn-fm-sm', 'PenilaianControlle@AjaxSavePnSmFm');
Route::post('/penilaian/ajax-save-ekskul-2022', 'PenilaianControlle@AjaxPnEkskul2022Save');
Route::post('/penilaian/ajax-get-list-penilaian', 'PenilaianControlle@AjaxGetListPenilaian');

// ajax get siswa absensi
Route::get('/absensi/ajax-get-siswa', 'AbsensiController@AjaxGetSiswa');

//ajax get siswa kelas
Route::get('/raport/ajax-get-siswa-kelas', 'RaportController@AjaxGetSiswaKelas');

// Ubah password
Route::post('/user/ubah-password', 'Controller@UbahPassword')->name('ubah.password');
// reset password
Route::get('/user/reset-password/{user_code}', 'Controller@ResetPassword')->name('reset.password');





