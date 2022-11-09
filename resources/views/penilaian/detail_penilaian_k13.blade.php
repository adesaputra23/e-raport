@php
    use App\User;
    use App\TahunAjaran;
    use App\Siswa;
    use App\TujuanPembelajaran;
    use App\MataPelajaran;
    use App\Http\Controllers\RaportController;
    use App\Semester;
    use App\KompetensiDasar;
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
                                    <th>Tahun Ajaran</th>
                                    <th>: {{ $data_siswa->TahunAjaran->tahun_ajaran }}</th>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <th>: {{ $data_siswa->Kelas->ket_kelas }}</th>
                                    <th></th>
                                    <th></th>
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

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#page1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Pengetahuan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#page2" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Keterampilan</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="page1" role="tabpanel">
                                {{-- tabel content --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th style="width: 20%;">Mata Pelajaran</th>
                                                <th style="width: 8%;">Kode Kompetensi</th>
                                                <th style="width: 40%;">Kompetensi</th>
                                                <th style="width: 5%;">Nilai Harian</th>
                                                <th style="width: 5%;">Nilai PTS</th>
                                                <th style="width: 5%;">Nilai PAS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_nilai_pengetahuan as $mapel => $value)
                                                @if (count($value) > 1)
                                                    <tr>
                                                        <td rowspan="{{ count($value) + 2 }}">
                                                            {{ MataPelajaran::GetbyId($mapel)->nama_mt }}</td>
                                                    </tr>
                                                    @foreach ($data_nilai_pengetahuan[$mapel] as $item => $kd)
                                                        @php
                                                            $nilai_kd = $kd->where('type_nilai_pengetahuan', 'nilai_kd')->first();
                                                            $nilai_pts = $kd->where('type_nilai_pengetahuan', 'nilai_pts')->first();
                                                            $nilai_pas = $kd->where('type_nilai_pengetahuan', 'nilai_pas')->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ KompetensiDasar::getById($item)->no_kd }}</td>
                                                            <td>{{ KompetensiDasar::getById($item)->nama_kd }}</td>
                                                            <td class="text-center">{{ $nilai_kd->nilai_pengetahuan }}
                                                            </td>
                                                            <td class="text-center">{{ $nilai_pts->nilai_pengetahuan }}
                                                            </td>
                                                            <td class="text-center">{{ $nilai_pas->nilai_pengetahuan }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr style="background-color: lightsteelblue">
                                                        <td colspan="2"><b>Nilai Total</b></td>
                                                        <td class="text-center">
                                                            <b>
                                                                {{ $nilai_kd->nilai_total }}
                                                            </b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b>
                                                                {{ $nilai_pts->nilai_total }}
                                                            </b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b>
                                                                {{ $nilai_pas->nilai_total }}
                                                            </b>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">Data penilaian tidak
                                                            ditemukan!</td>
                                                    </tr>
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="page2" role="tabpanel">
                                {{-- tabel content --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th style="width: 20%;">Mata Pelajaran</th>
                                                <th style="width: 8%;">Kode Kompetensi</th>
                                                <th style="width: 40%;">Kompetensi</th>
                                                <th style="width: 5%;">Nilai Harian</th>
                                                <th style="width: 5%;">Nilai PTS</th>
                                                <th style="width: 5%;">Nilai PAS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_nilai_keterampilan as $mapel_nilai_keterampilan => $nilai_keterampilan)
                                                @if (count($nilai_keterampilan) > 1)
                                                    <tr>
                                                        <td rowspan="{{ count($nilai_keterampilan) + 2 }}">
                                                            {{ MataPelajaran::GetbyId($mapel_nilai_keterampilan)->nama_mt }}
                                                        </td>
                                                    </tr>
                                                    @foreach ($data_nilai_keterampilan[$mapel_nilai_keterampilan] as $val_item => $val_kd)
                                                        @php
                                                            $nilai_kd_keterampilan = $val_kd->where('type_nilai_keterampilan', 'nilai_kd')->first();
                                                            $nilai_pts_keterampilan = $val_kd->where('type_nilai_keterampilan', 'nilai_pts')->first();
                                                            $nilai_pas_keterampilan = $val_kd->where('type_nilai_keterampilan', 'nilai_pas')->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ KompetensiDasar::getById($val_item)->no_kd }}</td>
                                                            <td>{{ KompetensiDasar::getById($val_item)->nama_kd }}</td>
                                                            <td class="text-center">
                                                                {{ $nilai_kd_keterampilan->nilai_keterampilan }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $nilai_pts_keterampilan->nilai_keterampilan }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $nilai_pas_keterampilan->nilai_keterampilan }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr style="background-color: lightsteelblue">
                                                        <td colspan="2"><b>Nilai Total</b></td>
                                                        <td class="text-center">
                                                            <b>
                                                                {{ $nilai_kd_keterampilan->nilai_total }}
                                                            </b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b>
                                                                {{ $nilai_pts_keterampilan->nilai_total }}
                                                            </b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b>
                                                                {{ $nilai_pas_keterampilan->nilai_total }}
                                                            </b>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">Data penilaian tidak
                                                            ditemukan!</td>
                                                    </tr>
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

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
