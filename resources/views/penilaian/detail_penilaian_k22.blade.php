@php
    use App\User;
    use App\TahunAjaran;
    use App\Siswa;
    use App\TujuanPembelajaran;
    use App\MataPelajaran;
    use App\Http\Controllers\RaportController;
    use App\Semester;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Detail Penilaian'])
    @include('partials/head-css')
</head>

@include('partials/body')
<!-- Begin page -->
<div id="layout-wrapper">
    @include('partials/menu')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('partials/page-title', [
                    'pagetitle' => 'Dashboard',
                    'title' => 'Detail Penilaian',
                ])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    {{-- tabel content --}}
                    <div class="table-responsive">
                        <div class="mt-2">
                            <h5><b>Data siswa</b></h5>
                            <hr>
                        </div>
                        <table class="table dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>NISN / NIS</th>
                                    <th>: {{ $data_siswa->Siswa->nisn }} / {{ $data_siswa->Siswa->nis }}</th>
                                    <th>Semester</th>
                                    <th>: {{ $data_siswa->Semester->nama_smester }}</th>
                                </tr>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>: {{ $data_siswa->Siswa->nama }}</th>
                                    <th>Kelas</th>
                                    <th>: {{ $data_siswa->Kelas->ket_kelas }}</th>
                                </tr>
                                <tr>
                                    <th>Fase</th>
                                    <th>: {{ RaportController::FaseKelas($data_siswa->Kelas->kelas) }}</th>
                                    <th>Tahun Ajaran</th>
                                    <th>: {{ $data_siswa->TahunAjaran->tahun_ajaran }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card card-body">
                    {{-- tabel content --}}
                    <div class="table-responsive">
                        <div class="mt-2">
                            <h5><b>Data Nilai</b></h5>
                            <hr>
                        </div>
                        <table class="table table-bordered mb-0"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 25%;">Mata Pelajaran</th>
                                    <th>Tujuan Pembelajaran</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($get_nilai as $mapel => $value)
                                    <tr>
                                        <td rowspan="{{ count($value) + 4 }}">
                                            {{ MataPelajaran::GetbyId($mapel)->nama_mt }}</td>
                                    </tr>
                                    @foreach ($get_nilai[$mapel] as $it => $val)
                                        <tr>
                                            <td>{{ TujuanPembelajaran::GetKodeMTByKodeTujuan($val->kode_tujuan)->nama_tujuan }}
                                            </td>
                                            <td class="text-center">{{ $val->nilai_tp }}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="background-color: lightsteelblue">
                                        <td><b>Nilai Formatif</b></td>
                                        <td class="text-center">
                                            <b>{{ $list_nilai_sm_fm[$mapel]['nilai_formatif'] }}</b>
                                        </td>
                                    </tr>
                                    <tr style="background-color: lightsteelblue">
                                        <td><b>Nilai Sumatif</b></td>
                                        <td class="text-center">
                                            <b>{{ $list_nilai_sm_fm[$mapel]['nilai_sumatif'] }}</b>
                                        </td>
                                    </tr>
                                    <tr style="background-color: lightsteelblue">
                                        <td><b>Nilai Akhir Sumatif</b></td>
                                        <td class="text-center">
                                            <b>{{ $list_nilai_sm_fm[$mapel]['nilai_akhir_sumatif'] }}</b>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- end isi conten --}}

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('partials/footer')

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

{{-- modal --}}

{{-- end modal --}}

@include('partials/right-sidebar')
@include('partials/vendor-scripts')
<script src={{ asset('assets/js/app.js') }}></script>
</body>

</html>
