@php
    use App\User;
    use App\TahunAjaran;
    use App\Semester;
    use App\RoleUser;
    use App\Http\Controllers\RaportController;
    use App\Siswa;
    use App\Kelas;
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
                                        <option value="">Pilih Siswa</option>
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

                                <div>
                                    {{-- data nilai sikap --}}
                                    <div class="mt-4">
                                        <h6>A. Nilai Sikap</h6>
                                        <div class="mt-2">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="2">Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 20%">Sikap Spritual</th>
                                                        <td>{{ $data_pn_sikap }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 20%">Sikap Sosial</th>
                                                        <td>{{ 'Ananda ' . $is_data->Siswa->nama . ' sangat jujur, percaya diri dan sudah mampu meningkatkan sikap disiplin.' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- data nilai pengetahuan dan pembelajaran --}}
                                    <div class="mt-4">
                                        <h6>B. Nilai Pengetahuan dan Pembelajaran</h6>
                                        <h6>Nilai KKM Satuan Pendidikan : {{ $nilai_kkm->nilai_kkm }}</h6>
                                    </div>
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

                                    {{-- nilai ekstrakulikuler --}}
                                    <div>
                                        <div class="mt-4">
                                            <h6>C. Ekstrakurikuler</h6>
                                            <div class="mt-2">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Kegiatan Ekstrakurikuler</th>
                                                            <th class="text-center">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($data_ekskul as $item => $ekskul)
                                                            <tr>
                                                                <td class="text-center">{{ $item + 1 }}</td>
                                                                <td>{{ $ekskul->Ekskul->nama_ekskul }}
                                                                </td>
                                                                <td>{{ $ekskul->keterangan }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- saran-saran --}}
                                    <div>
                                        <div class="mt-4">
                                            <h6>D. Saran-Saran</h6>
                                            <div class="mt-2">
                                                <table class="table table-bordered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $data_saran->saran }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- tinggi dan berat badan --}}
                                    <div>
                                        <div class="mt-4">
                                            <h6>E. Tinggi Dan Berat Badan</h6>
                                            <div class="mt-2">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle"
                                                                style="width: 7%; text-align: center;" rowspan="2">No
                                                            </th>
                                                            <th class="text-center align-middle" rowspan="2">Aspek
                                                                yang di
                                                                nilai</th>
                                                            <th class="text-center" colspan="2">Semester</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">1</th>
                                                            <th class="text-center">2</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td>Tinggi Badan</td>
                                                            @if ($data_TBdanBB['smt_1'] != null)
                                                                <td class="text-center">
                                                                    {{ $data_TBdanBB['smt_1']->tinggi_badan . ' cm' }}
                                                                </td>
                                                            @else
                                                                <td class="text-center">{{ '-' }}
                                                                </td>
                                                            @endif
                                                            @if ($data_TBdanBB['smt_2'] != null)
                                                                <td class="text-center">
                                                                    {{ $data_TBdanBB['smt_2']->tinggi_badan . ' cm' }}
                                                                </td>
                                                            @else
                                                                <td class="text-center">{{ '-' }}
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">2</td>
                                                            <td>Berat Badan</td>
                                                            @if ($data_TBdanBB['smt_1'] != null)
                                                                <td class="text-center">
                                                                    {{ $data_TBdanBB['smt_1']->berat_badan . ' kg' }}
                                                                </td>
                                                            @else
                                                                <td class="text-center">{{ '-' }}
                                                                </td>
                                                            @endif
                                                            @if ($data_TBdanBB['smt_2'] != null)
                                                                <td class="text-center">
                                                                    {{ $data_TBdanBB['smt_2']->berat_badan . ' kg' }}
                                                                </td>
                                                            @else
                                                                <td class="text-center">{{ '-' }}
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- kondisi kesehatan --}}
                                    <div>
                                        <div class="mt-4">
                                            <h6>F. Kondisi Kesehatan</h6>
                                            <div class="mt-2">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 7%; text-align: center;">
                                                                No</th>
                                                            <th class="text-center">Aspek Fisik</th>
                                                            <th class="text-center">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no_ks = 1;
                                                        @endphp
                                                        @foreach ($data_kodisi_kesehatan as $item => $kondisi_kesehatan)
                                                            <tr>
                                                                <td class="text-center">{{ $no_ks++ }}
                                                                </td>
                                                                <td>{{ $kondisi_kesehatan->kondisi }}
                                                                </td>
                                                                <td>
                                                                    {{ $kondisi_kesehatan->ket_kondisi }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- prestasi --}}
                                    <div>
                                        <div class="mt-4">
                                            <h6>G. Prestasi</h6>
                                            <div class="mt-2">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 7%; text-align: center;">
                                                                No</th>
                                                            <th class="text-center">Jenis Prestasi</th>
                                                            <th class="text-center">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no_prst = 1;
                                                        @endphp
                                                        @foreach ($data_prestasi as $item => $prestasi)
                                                            <tr>
                                                                <td class="text-center">{{ $no_prst++ }}
                                                                </td>
                                                                <td>{{ $prestasi->prestasi }}</td>
                                                                <td>{{ $prestasi->ket_prestasi }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ketidak hadiran --}}
                                    <div>
                                        <div class="mt-4">
                                            <h6>H. Ketidakhadiran</h6>
                                            <div class="mt-2">
                                                <table class="table table-bordered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>Sakit</td>
                                                            <td class="text-center">
                                                                {{ $data_absensi['sakit'] }} hari</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Izin</td>
                                                            <td class="text-center">{{ $data_absensi['ijin'] }}
                                                                hari</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanpa keterangan</td>
                                                            <td class="text-center">
                                                                {{ $data_absensi['tanpa_keterangan'] }} hari</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- keterangan kenaikan kelas --}}
                                    @if ($is_data->Semester->id == Semester::Genap)
                                        @php
                                            $get_CekKenaikanKelas = RaportController::CekKenaikanKelas($data_nilai, $is_data->kelas);
                                            $kelas_name = Kelas::getbyId($get_CekKenaikanKelas['status_kelas']);
                                        @endphp
                                        <div>
                                            <div class="mt-4">
                                                <h6>Keterangan :</h6>
                                                <div class="mt-2">
                                                    <table class="table table-bordered mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    Berdasarkan pencapaian seluruh kompetensi, peserta
                                                                    didik dinyatakan:
                                                                    <h6
                                                                        style="color: {{ $get_CekKenaikanKelas['color'] }};">
                                                                        {{ $get_CekKenaikanKelas['status_text'] . (empty($kelas_name) ? $get_CekKenaikanKelas['status_kelas'] : $kelas_name->kelas) }}
                                                                    </h6>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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
