@php
    use App\User;
    use App\TahunAjaran;
    use App\Semester;
    use App\RoleUser;
    use App\Siswa;
    use App\Http\Controllers\RaportController;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Nilai Raport K22'])
    <link href={{ asset('assets/libs/select2/css/select2.min.css') }} rel="stylesheet" type="text/css">
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
                    'title' => 'Data Nilai Raport K22',
                ])
                @include('partials/alert_mesage')

                {{-- isi conten --}}
                <div class="card card-body">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">

                            @if (RoleUser::CheckRole()->user_role === RoleUser::WaliKelas)
                                <div class="col-md-10">
                                    <label for="">Pilih Siswa</label>
                                    <select class="form-control form-control-sm" name="nisn" id="nisn">
                                        <option value="">Pilih Siswa</option>
                                        @foreach ($list_siswa as $item => $siswa)
                                            <option value="{{ $siswa->nisn }}">{{ $siswa->nisn }} -
                                                {{ $siswa->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif(RoleUser::CheckRole()->user_role === RoleUser::KP)
                                <div class="col-md-5">
                                    <label for="">Pilih Kelas</label>
                                    <select class="form-control" name="kelas" id="kelas">
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($list_kelas as $item => $kelas)
                                            <option value="{{ $kelas->kode_kelas }}"
                                                {{ request()->kelas == $kelas->kode_kelas ? 'selected' : '' }}>
                                                {{ $kelas->kode_kelas }} -
                                                {{ $kelas->ket_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="">Pilih Siswa</label>
                                    <select class="form-control" name="nisn" id="nisn">
                                        <option value="" selected disabled>Pilih Siswa</option>
                                        @if (!empty(request()->kelas))
                                            @foreach ($list_siswa as $key => $siswa)
                                                <option value="{{ $siswa->nisn }}"
                                                    {{ request()->nisn == $siswa->nisn ? 'selected' : '' }}>
                                                    {{ $siswa->nisn . '/' . $siswa->nis . ' - ' . $siswa->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid)
                                @php
                                    $siswa = Siswa::GetSiswaByNisn($list_siswa);
                                @endphp
                                <div class="col-md-10">
                                    <label for="">Pilih Siswa</label>
                                    <select class="form-control" name="nisn" id="nisn">
                                        <option value="" selected disabled>Pilih Siswa</option>
                                        <option value="{{ $siswa->nisn }}">
                                            {{ $siswa->nisn . '/' . $siswa->nis . ' - ' . $siswa->nama }}
                                        </option>
                                    </select>
                                </div>
                            @endif

                            <div class="col-md-2 mt-4">
                                <button type="submit" class="btn btn-success w-100"
                                    style="margin-bottom: -26px;">Tampilkan</button>
                            </div>
                        </div>
                    </form>

                    @if (empty($is_data))
                        {{-- default view --}}
                        <div class="mt-4 border border-dark">
                            <div class="card-body">
                                @if (Request::get('nisn') == null)
                                    <p class="mt-3 text-center">Harap pilih siswa terlebih dahulu.</p>
                                @else
                                    <p class="mt-3 text-center">Siswa tidak ditemukan!</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (!empty($is_data))
                        <div class="mt-3">
                            <a href="{{ route('cetak-raport', ['nisn' => $is_data->siswa->nisn, 'kode_kelas' => $is_data->Kelas->kode_kelas]) }}"
                                target="_blank" class="btn btn-primary w-100">Cetak
                                Raport
                                PDF</a>
                        </div>
                        {{-- data siswa view --}}
                        <div class="mt-2 border border-dark">
                            <div class="card-body">

                                {{-- list data pribadi --}}
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-sm m-0" style="width: 80%">
                                                <tr>
                                                    <th>Nama Peserta Didik</th>
                                                    <th>: {{ $is_data->siswa->nama }}</th>
                                                </tr>
                                                <tr>
                                                    <th>NISN/NIS</th>
                                                    <th>: {{ $is_data->siswa->nisn }} / {{ $is_data->siswa->nis }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Nama Sekolah</th>
                                                    <th>: SDN ARDISAENG 01
                                                    <th>
                                                </tr>
                                                <tr>
                                                    <th>Alamat Sekolah</th>
                                                    <th>: Bondowoso
                                                    <th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-sm m-0" style="width: 80%">
                                                <tr>
                                                    <th>Kelas</th>
                                                    <th>: {{ $is_data->Kelas->kelas }}
                                                    <th>
                                                </tr>
                                                <tr>
                                                    <th>Fase</th>
                                                    <th>: {{ RaportController::FaseKelas($is_data->Kelas->kelas) }}
                                                    <th>
                                                </tr>
                                                <tr>
                                                    <th>Semester</th>
                                                    <th>: {{ $is_data->Semester->nama_smester }}
                                                    <th>
                                                </tr>
                                                <tr>
                                                    <th>Tahun Ajaran</th>
                                                    <th>: {{ $is_data->TahunAjaran->tahun_ajaran }}
                                                    <th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- end --}}

                                <hr class="mt-4">

                                {{-- data nilai mata pelajaran --}}
                                <div>
                                    {{-- tabel penilaian --}}
                                    <div class="mt-4">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th class="text-center">Mata Pelajaran</th>
                                                    <th class="text-center">Nilai Akhir</th>
                                                    <th class="text-center">Capaian Kompetensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($data_nilai as $items => $nilai)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ RaportController::GetNameMapel($items)->nama_mt }}
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $grnerate_nilai = RaportController::GenerateNilai($nilai['nilai_total']);
                                                                $gnerate_predikat = RaportController::GeneratePredikat($grnerate_nilai);
                                                                $line_text = 'Ananda ' . $is_data->nama_siswa . ', ' . $gnerate_predikat . ' ';
                                                            @endphp
                                                            {{ $nilai['nilai_total'] }}
                                                        </td>
                                                        <td>{{ $line_text . $nilai['tujuan'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- eksul --}}
                                <div>
                                    <div class="mt-4">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 7%; text-align: center;">No</th>
                                                    <th class="text-center">Ekstrakulikuler</th>
                                                    <th class="text-center">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no_start = 1;
                                                @endphp
                                                @if (count($data_ekskul) < 1)
                                                    <tr>
                                                        <td class="border text-center">1</td>
                                                        <td class="border">.................</td>
                                                        <td class="border">.................</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border text-center">2</td>
                                                        <td class="border">.................</td>
                                                        <td class="border">.................</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border text-center">3</td>
                                                        <td class="border">.................</td>
                                                        <td class="border">.................</td>
                                                    </tr>
                                                @else
                                                    @foreach ($data_ekskul as $key => $ekskul)
                                                        @if ($ekskul->Ekskul != null)
                                                            <tr>
                                                                <td class="border text-center">{{ $key + 1 }}</td>
                                                                <td class="border">{{ $ekskul->Ekskul->nama_ekskul }}
                                                                </td>
                                                                <td class="border">{{ $ekskul->keterangan }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- ketidak hadiran --}}
                                <div>
                                    <div class="mt-4">
                                        <table class="table table-bordered mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="border" style="width: 7%; text-align: center;"
                                                        colspan="2">Ketidakhadiran</th>
                                                </tr>
                                                <tr>
                                                    <td class="border" style="width: 25%;">Sakit</td>
                                                    <td class="border text-center" style="width: 15%;">
                                                        {{ $data_absensi['sakit'] }} hari</td>
                                                </tr>
                                                <tr>
                                                    <td class="border">Ijin</td>
                                                    <td class="border text-center">{{ $data_absensi['ijin'] }} hari
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border">Tanpa Keterangan</td>
                                                    <td class="border text-center">
                                                        {{ $data_absensi['tanpa_keterangan'] }} hari</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- end --}}

                            </div>
                        </div>
                    @endif
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
<script src={{ asset('assets/libs/select2/js/select2.min.js') }}></script>
<script src={{ asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}></script>
<script src={{ asset('assets/js/pages/form-advanced.init.js') }}></script>
<script src={{ asset('assets/libs/parsleyjs/parsley.min.js') }}></script>
<script src={{ asset('assets/js/pages/form-validation.init.js') }}></script>
<script src={{ asset('assets/libs/node-waves/waves.min.js') }}></script>
<script src={{ asset('assets/js/app.js') }}></script>
</body>
<script>
    $('#kelas').select2();
    $('#nisn').select2();
    $('#kelas').on('change', function() {
        var kelas = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ url('/raport/ajax-get-siswa-kelas') }}",
            data: {
                kode_kelas: kelas,
                _token: '{{ csrf_token() }}'
            },
            dataType: "json",
            success: function(response) {
                var bodyData = '';
                if (response.length > 0) {
                    $.each(response, function(index, value) {
                        bodyData +=
                            `<option value="${value.siswa.nisn}">${value.siswa.nisn + '/' + value.siswa.nis +' - '+value.siswa.nama}</option>`;
                    });
                } else {
                    bodyData +=
                        `<option value="">Tidak ada data siswa!</option>`;
                }
                $('#nisn').html(bodyData);
            }
        });
    })
</script>

</html>
