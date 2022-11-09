@php
    use App\User;
    use App\TahunAjaran;
    use App\Semester;
    use App\RoleUser;
    use App\Http\Controllers\RaportController;
    use App\Siswa;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Nilai Raport K13'])
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
                    'title' => 'Data Nilai Raport K13',
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
                                            <option value="{{ $siswa->nisn }}">{{ $siswa->nisn . '/' . $siswa->nis }} -
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
                                            <option value="{{ $kelas->kode_kelas }}">{{ $kelas->kode_kelas }} -
                                                {{ $kelas->ket_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="">Pilih Siswa</label>
                                    <select class="form-control" name="nisn" id="nisn">
                                        <option value="">Pilih Siswa</option>
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
                                            {{ $siswa->nisn . '/' . $siswa->nisn . ' - ' . $siswa->nama }}
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

                    {{-- default view --}}
                    @if (empty($is_data))
                        <div class="mt-4 border border-dark">
                            <div class="card-body">
                                {{-- {{ dd(Request::get('nisn')) }} --}}
                                @if (Request::get('nisn') == null)
                                    <p class="mt-3 text-center">Harap pilih siswa terlebih dahulu.</p>
                                @else
                                    <p class="mt-3 text-center">Siswa tidak ditemukan!</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- data siswa view --}}
                    @if (!empty($is_data))
                        <div class="mt-3">
                            <a href="{{ route('cetak-raport', ['nisn' => $is_data->siswa->nisn, 'kode_kelas' => $is_data->Kelas->kode_kelas]) }}"
                                target="_BLANK" class="btn btn-primary w-100">Cetak Raport PDF</a>
                        </div>
                        <div class="mt-2 border border-dark">
                            <div class="card-body">

                                {{-- list data pribadi --}}
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-sm m-0" style="width: 80%">
                                                <tr>
                                                    <th>Nama Peserta Didik</th>
                                                    <th>: {{ $is_data->Siswa->nama }}</th>
                                                </tr>
                                                <tr>
                                                    <th>NISN/NIS</th>
                                                    <th>: {{ $is_data->Siswa->nisn ?? '-' }} /
                                                        {{ $is_data->siswa->nis ?? '-' }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Nama Sekolah</th>
                                                    <th>: SDN ARDISAENG 01</th>
                                                </tr>
                                                <tr>
                                                    <th>Alamat Sekolah</th>
                                                    <th>: Bondowoso</th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-sm m-0" style="width: 80%">
                                                <tr>
                                                    <th>Kelas</th>
                                                    <th>: {{ $is_data->kelas->kelas }}
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
                                    <div class="mt-4">
                                        <h6>Nilai Pengetahuan dan Pembelajaran</h6>
                                        <h6>Nilai KKM Satuan Pendidikan : {{ $nilai_kkm->nilai_kkm }}</h6>
                                    </div>
                                    {{-- tabel penilaian --}}
                                    <div class="mt-2">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th class="text-center" rowspan="2">Muatan Pelajaran</th>
                                                    <th class="text-center" colspan="3">Pengetahuan</th>
                                                    <th class="text-center" colspan="3">Keterampilan</th>
                                                </tr>
                                                <tr>
                                                    <th>Nilai</th>
                                                    <th>Predikat</th>
                                                    <th class="text-center">Deskripsi</th>
                                                    <th>Nilai</th>
                                                    <th>Predikat</th>
                                                    <th class="text-center">Deskripsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($data_nilai[0] as $items => $value)
                                                    @php
                                                        $converter_nilai_pengetahuan = RaportController::GenerateNilai(Str::substr($data_nilai[2][$items] ?? '-', 0, 2));
                                                        $converter_nilai_keterampilan = RaportController::GenerateNilai(Str::substr($value, 0, 2));
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ RaportController::GetNameMapel($items)->nama_mt }}</td>
                                                        <td class="text-center">
                                                            {{ Str::substr($data_nilai[2][$items] ?? '-', 0, 2) ?? '-' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $converter_nilai_pengetahuan }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $conversi_a = Str::substr($data_nilai[2][$items] ?? '-', 0, 2);
                                                                $retVal_a = RaportController::GeneratePredikat($converter_nilai_pengetahuan);
                                                            @endphp
                                                            @foreach ($data_nilai[3][$items] as $it)
                                                                @if ($conversi_a != 0)
                                                                    {{ 'Ananda ' . $is_data->Siswa->nama . ' ' . $retVal_a . ', ' . implode(',', $it) }}
                                                                @else
                                                                    -
                                                                @endif
                                                                @php
                                                                    break;
                                                                @endphp
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">{{ Str::substr($value, 0, 2) }}</td>
                                                        <td class="text-center">{{ $converter_nilai_keterampilan }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $conversi = Str::substr($value, 0, 2);
                                                                $retVal = RaportController::GeneratePredikat($converter_nilai_keterampilan);
                                                            @endphp
                                                            @foreach ($data_nilai[1][$items] as $item)
                                                                @if ($conversi != 0)
                                                                    {{ 'Ananda ' . $is_data->Siswa->nama . ' ' . $retVal . ', ' . implode(',', $item) }}
                                                                @else
                                                                    -
                                                                @endif
                                                                @php
                                                                    break;
                                                                @endphp
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
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
