@php
use App\User;
use App\TahunAjaran;
use App\Kurikulum;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => $title])
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
                @include('partials/page-title', ['pagetitle' => 'Dashboard', 'title' => $title])
                @include('partials/alert_mesage')

                <div class="alert alert-success alert-dismissible fade show succ" role="alert" style="display: none">
                    <i class="mdi mdi-check-all me-2"></i>
                    <p class="scc-text"></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                {{-- isi conten --}}

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Pilih Siswa: </h4>
                            <p class="mb-0 text-danger">Note: Pilih siswa terlebih dahulu jika ingin melakukan
                                penilaian.</p>
                            <p class="text-danger">Penilaian menggunakan format
                                {{ $kurikulum->nama_kurikulum }}</p>
                            <div>
                                <div class="mb-2 mt-2">
                                    <div class="row mb-3">
                                        <div class="col-sm-10">
                                            <select id="nisn" class="form-control select2">
                                                <option selected disabled>Pilih Siswa</option>
                                                @foreach ($list_siswa as $item => $siswa)
                                                    <option value="{{ $siswa->nisn }}">
                                                        {{ $siswa->nisn . ' - ' . $siswa->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary w-100 m-1"
                                                id="btn-pilih-siswa">Pilih</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($kurikulum->kode_kurikulum === Kurikulum::K13)
                    @include('penilaian.pn_k13')
                @else
                    @include('penilaian.pn_prototype')
                @endif

                <!-- end row -->

                {{-- end isi conten --}}

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('partials/footer')

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

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

{{-- script penilaian k2013 --}}
<script>
    $(document).on('click', '#btn-pilih-siswa', function() {
        let siswa = $('#nisn').val();
        if (siswa !== null) {
            $('#form-pn-2013').css('display', 'flex');
            $('#form-pn-2022').css('display', 'flex');
            $('#default-2013').css('display', 'block');
            $('#penilaian-pengetahuan-2013').css('display', 'none');
            $('#penilaian-keterampilan-2013').css('display', 'none');
            $('#penilaian-lain-lain-2013').css('display', 'none');
            $('#penilaian-sikap-2013').css('display', 'none');
        }

        $.ajax({
            url: "{{ url('penilaian/ajax-get-siswa') }}",
            method: "GET",
            data: {
                nisn: siswa,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(resp) {
                let siswa = resp.siswa;
                let kelas = resp.kelas;
                let pn_sikap = resp.pn_sikap;
                $('#nisn-siswa').text(': ' + siswa.nisn + '/' + (siswa.nis === null ? '-' : siswa
                    .nis));
                $('#nama-siswa').text(': ' + siswa.nama);
                $('#kelas-siswa').text(': ' + kelas.ket_kelas);
                $('#jk-siswa').text(': ' + (siswa.jenis_kelamin === 1 ? 'Laki-Laki' : 'Prempuan'));
                $('#sw-nisn').val(siswa.nisn);
                $('#kelas').val(kelas.kode_kelas);
                if (pn_sikap !== null) {
                    $('#id_pn_sikap').val(pn_sikap.id_pn_sikap);

                    // beribadah
                    if (pn_sikap.beribadah == 'Baik dalam beribadah') {
                        $('#beribadah_formRadios1').prop('checked', true);
                    } else if (pn_sikap.beribadah == 'Cukup baik dalam beribadah') {
                        $('#beribadah_formRadios2').prop('checked', true);
                    }

                    // syukur
                    if (pn_sikap.syukur == 'Baik dalam bersyukur') {
                        $('#syukur_formRadios1').prop('checked', true);
                    } else if (pn_sikap.syukur == 'Cukup baik dalam bersyukur') {
                        $('#syukur_formRadios2').prop('checked', true);
                    }

                    // berdoa
                    if (pn_sikap.berdoa == 'Baik dalam berdoa') {
                        $('#berdoa_formRadios1').prop('checked', true);
                    } else if (pn_sikap.berdoa == 'Cukup baik dalam berdoa') {
                        $('#berdoa_formRadios2').prop('checked', true);
                    }

                    // toleransi
                    if (pn_sikap.toleransi == 'Baik dalam toleransi') {
                        $('#toleransi_formRadios1').prop('checked', true);
                    } else if (pn_sikap.toleransi == 'Cukup baik dalam toleransi') {
                        $('#toleransi_formRadios2').prop('checked', true);
                    }

                } else {
                    $('#id_pn_sikap').val('');

                    // beribadah
                    $('#beribadah_formRadios1').prop('checked', false);
                    $('#beribadah_formRadios2').prop('checked', false);

                    // syukur
                    $('#syukur_formRadios1').prop('checked', false);
                    $('#syukur_formRadios2').prop('checked', false);

                    // berdoa
                    $('#berdoa_formRadios1').prop('checked', false);
                    $('#berdoa_formRadios2').prop('checked', false);

                    // toleransi
                    $('#toleransi_formRadios1').prop('checked', false);
                    $('#toleransi_formRadios2').prop('checked', false);
                }
            }
        });
    });

    $(document).on('click', '#btn-2013-sikap', function() {
        $('#default-2013').css('display', 'block');
        $('#penilaian-pengetahuan-2013').css('display', 'none');
        $('#penilaian-keterampilan-2013').css('display', 'none');
        $('#penilaian-lain-lain-2013').css('display', 'none');
        $('#penilaian-sikap-2013').css('display', 'block');
    });

    $(document).on('click', '#btn-2013-pengetahuan', function() {

        var kode_kelas = $('#kelas').val();
        var siswa_nisn = $('#sw-nisn').val();

        $('#default-2013').css('display', 'block');
        $('#penilaian-sikap-2013').css('display', 'none');
        $('#penilaian-keterampilan-2013').css('display', 'none');
        $('#penilaian-lain-lain-2013').css('display', 'none');
        $('#penilaian-pengetahuan-2013').css('display', 'block');

        $.ajax({
            url: "{{ url('penilaian/ajax-get-pn-pengetahuan') }}",
            method: "GET",
            data: {
                siswa_nisn: siswa_nisn,
                kode_kelas: kode_kelas,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(resp) {
                var tabel = '';
                tabel += `
                        <table class="table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>No.KD</th>
                                    <th style="width:50%">Kompetensi Dasar</th>
                                    <th>Nilai Harian</th>
                                    <th>Nilai PTS</th>
                                    <th>Nilai PAS</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                $(resp.list_mapel).each(function(key, value) {
                    tabel += '<tr>';
                    tabel += '<td rowspan="' + (resp.count[value.kode_mt] + 2) + '">' +
                        value.nama_mt + '</td>';
                    $(resp.list_kd[value.kode_mt]).each(function(key_kd, kd) {
                        if (kd['pegetahuan'].length > 0) {
                            tabel += '<tr>';
                            tabel += '<td>' + kd.no_kd + '</td>';
                            tabel += '<td>' + kd.nama_kd + '</td>';
                            $(kd['pegetahuan']).each(function(key_type_pengetahuan,
                                type_pengetahuan) {
                                if (type_pengetahuan
                                    .type_nilai_pengetahuan == 'nilai_kd') {
                                    tabel += `<td>
                                                            <input type="hidden" name="pengetahuan_id_kd" id="pengetahuan_id_kd" class="form-control form-control-sm" value="${kd.kode_kd}">
                                                            <input value="${type_pengetahuan.nilai_total ?? ''}" type="hidden" name="pengetahuan_nilai_totoal_kd" id="pengetahuan_nilai_totoal_kd" class="form-control form-control-sm pengetahuan_nilai_totoal_kd${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                            <input value="${type_pengetahuan.nilai_pengetahuan}" type="text" name="pengetahuan_nilai_kd" id="pengetahuan_nilai_kd" class="form-control form-control-sm pengetahuan_nilai_kd${value.kode_mt}" placeholder="Nilai" required>
                                                    </td>`;
                                } else if (type_pengetahuan
                                    .type_nilai_pengetahuan == 'nilai_pts'
                                ) {
                                    tabel += `<td>
                                                            <input value="${type_pengetahuan.nilai_total ?? ''}" type="hidden" name="pengetahuan_nilai_totoal_pts" id="pengetahuan_nilai_totoal_pts" class="form-control form-control-sm pengetahuan_nilai_totoal_pts${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                            <input value="${type_pengetahuan.nilai_pengetahuan}" type="text" name="pengetahuan_nilai_pts" id="pengetahuan_nilai_pts" class="form-control form-control-sm pengetahuan_nilai_pts${value.kode_mt}" placeholder="Nilai" required>
                                                    </td>`;
                                } else if (type_pengetahuan
                                    .type_nilai_pengetahuan == 'nilai_pas'
                                ) {
                                    tabel += `<td>
                                                            <input value="${type_pengetahuan.nilai_total ?? ''}" type="hidden" name="pengetahuan_nilai_totoal_pas" id="pengetahuan_nilai_totoal_pas" class="form-control form-control-sm pengetahuan_nilai_totoal_pas${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                            <input value="${type_pengetahuan.nilai_pengetahuan}" type="text" name="pengetahuan_nilai_pas" id="pengetahuan_nilai_pas" class="form-control form-control-sm pengetahuan_nilai_pas${value.kode_mt}" placeholder="Nilai" required>
                                                    </td>`;
                                }
                            });
                            tabel += '</tr>';
                        } else {
                            tabel += '<tr>';
                            tabel += '<td>' + kd.no_kd + '</td>';
                            tabel += '<td>' + kd.nama_kd + '</td>';
                            tabel += `<td>
                                                        <input type="hidden" name="pengetahuan_id_kd" id="pengetahuan_id_kd" class="form-control form-control-sm" value="${kd.kode_kd}">
                                                        <input type="hidden" name="pengetahuan_nilai_totoal_kd" id="pengetahuan_nilai_totoal_kd" class="form-control form-control-sm pengetahuan_nilai_totoal_kd${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                        <input type="text" name="pengetahuan_nilai_kd" id="pengetahuan_nilai_kd" class="form-control form-control-sm pengetahuan_nilai_kd${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                </td>`;
                            tabel += `<td>
                                                        <input type="hidden" name="pengetahuan_nilai_totoal_pts" id="pengetahuan_nilai_totoal_pts" class="form-control form-control-sm pengetahuan_nilai_totoal_pts${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                        <input type="text" name="pengetahuan_nilai_pts" id="pengetahuan_nilai_pts" class="form-control form-control-sm pengetahuan_nilai_pts${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                </td>`;
                            tabel += `<td>
                                                        <input type="hidden" name="pengetahuan_nilai_totoal_pas" id="pengetahuan_nilai_totoal_pas" class="form-control form-control-sm pengetahuan_nilai_totoal_pas${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                        <input type="text" name="pengetahuan_nilai_pas" id="pengetahuan_nilai_pas" class="form-control form-control-sm pengetahuan_nilai_pas${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                </td>`;
                            tabel += '</tr>';
                        }
                    });
                    tabel += '<td></td>';
                    tabel += '<td></td>';
                    tabel +=
                        `<td><input type="text" name="as_pengetahuan_nilai_totoal_kd" id="as_pengetahuan_nilai_totoal_kd" class="form-control form-control-sm as_pengetahuan_nilai_totoal_kd${value.kode_mt}" placeholder="Total Nilai" required readonly></td>`;
                    tabel +=
                        `<td><input type="text" name="as_pengetahuan_nilai_totoal_pts" id="as_pengetahuan_nilai_totoal_pts" class="form-control form-control-sm as_pengetahuan_nilai_totoal_pts${value.kode_mt}" placeholder="Total Nilai" required readonly></td>`;
                    tabel +=
                        `<td><input type="text" name="as_pengetahuan_nilai_totoal_pas" id="as_pengetahuan_nilai_totoal_pas" class="form-control form-control-sm as_pengetahuan_nilai_totoal_pas${value.kode_mt}" placeholder="Total Nilai" required readonly></td>`;

                    tabel += '</tr>';

                    // nilai pengethaun kd
                    $(document).on("change", ".pengetahuan_nilai_kd" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.pengetahuan_nilai_kd' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".pengetahuan_nilai_kd" + value.kode_mt).each(function() {
                                sum += +$(this).val();
                            });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.as_pengetahuan_nilai_totoal_kd' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai pengatuan pts
                    $(document).on("change", ".pengetahuan_nilai_pts" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.pengetahuan_nilai_pts' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".pengetahuan_nilai_pts" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.as_pengetahuan_nilai_totoal_pts' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai pengatuan pas
                    $(document).on("change", ".pengetahuan_nilai_pas" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.pengetahuan_nilai_pas' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".pengetahuan_nilai_pas" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.as_pengetahuan_nilai_totoal_pas' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai pengethaun kd
                    $(document).on("change", ".pengetahuan_nilai_kd" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.pengetahuan_nilai_kd' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".pengetahuan_nilai_kd" + value.kode_mt).each(function() {
                                sum += +$(this).val();
                            });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.pengetahuan_nilai_totoal_kd' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai pengatuan pts
                    $(document).on("change", ".pengetahuan_nilai_pts" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.pengetahuan_nilai_pts' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".pengetahuan_nilai_pts" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.pengetahuan_nilai_totoal_pts' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai pengatuan pas
                    $(document).on("change", ".pengetahuan_nilai_pas" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.pengetahuan_nilai_pas' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".pengetahuan_nilai_pas" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.pengetahuan_nilai_totoal_pas' + value.kode_mt).val(
                                nilai_total);
                        });

                });

                tabel += `
                            </tbody>
                        </table>
                    `;
                $('#tabel-pengetahuan').html(tabel);
            }
        });
    });

    $(document).on('click', '#btn-2013-keterampilan', function() {

        var kode_kelas = $('#kelas').val();
        var siswa_nisn = $('#sw-nisn').val();

        $('#default-2013').css('display', 'block');
        $('#penilaian-sikap-2013').css('display', 'none');
        $('#penilaian-pengetahuan-2013').css('display', 'none');
        $('#penilaian-lain-lain-2013').css('display', 'none');
        $('#penilaian-keterampilan-2013').css('display', 'block');

        $.ajax({
            url: "{{ url('penilaian/ajax-get-pn-keterampilan') }}",
            method: "GET",
            data: {
                siswa_nisn: siswa_nisn,
                kode_kelas: kode_kelas,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(resp) {
                console.log(resp);
                var tabel = '';
                tabel += `
                        <table class="table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>No.KD</th>
                                    <th style="width:50%">Kompetensi Dasar</th>
                                    <th>Nilai Harian</th>
                                    <th>Nilai PTS</th>
                                    <th>Nilai PAS</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                $(resp.list_mapel).each(function(key, value) {
                    tabel += '<tr>';
                    tabel += '<td rowspan="' + (resp.count[value.kode_mt] + 2) + '">' +
                        value.nama_mt + '</td>';
                    $(resp.list_kd[value.kode_mt]).each(function(key_kd, kd) {
                        if (kd['keterampilan'].length > 0) {
                            tabel += '<tr>';
                            tabel += '<td>' + kd.no_kd + '</td>';
                            tabel += '<td>' + kd.nama_kd + '</td>';
                            $(kd['keterampilan']).each(function(
                                key_type_keterampilan, type_keterampilan) {
                                if (type_keterampilan
                                    .type_nilai_keterampilan == 'nilai_kd'
                                ) {
                                    tabel += `<td>
                                                            <input type="hidden" name="keterampilan_id_kd" id="keterampilan_id_kd" class="form-control form-control-sm" value="${kd.kode_kd}">
                                                            <input value="${type_keterampilan.nilai_total ?? ''}" type="hidden" name="keterampilan_nilai_totoal_kd" id="keterampilan_nilai_totoal_kd" class="form-control form-control-sm keterampilan_nilai_totoal_kd${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                            <input value="${type_keterampilan.nilai_keterampilan}" type="text" name="keterampilan_nilai_kd" id="keterampilan_nilai_kd" class="form-control form-control-sm keterampilan_nilai_kd${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                        </td>`;
                                } else if (type_keterampilan
                                    .type_nilai_keterampilan == 'nilai_pts'
                                ) {
                                    tabel += `<td>
                                                            <input value="${type_keterampilan.nilai_total ?? ''}" type="hidden" name="keterampilan_nilai_totoal_pts" id="keterampilan_nilai_totoal_pts" class="form-control form-control-sm keterampilan_nilai_totoal_pts${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                            <input value="${type_keterampilan.nilai_keterampilan}" type="text" name="keterampilan_nilai_pts" id="keterampilan_nilai_pts" class="form-control form-control-sm keterampilan_nilai_pts${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                        </td>`;
                                } else if (type_keterampilan
                                    .type_nilai_keterampilan == 'nilai_pas'
                                ) {
                                    tabel += `<td>
                                                            <input value="${type_keterampilan.nilai_total ?? ''}" type="hidden" name="keterampilan_nilai_totoal_pas" id="keterampilan_nilai_totoal_pas" class="form-control form-control-sm keterampilan_nilai_totoal_pas${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                            <input value="${type_keterampilan.nilai_keterampilan}" type="text" name="keterampilan_nilai_pas" id="keterampilan_nilai_pas" class="form-control form-control-sm keterampilan_nilai_pas${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                        </td>`;
                                }
                            });
                            tabel += '</tr>';
                        } else {
                            tabel += '<tr>';
                            tabel += '<td>' + kd.no_kd + '</td>';
                            tabel += '<td>' + kd.nama_kd + '</td>';
                            tabel += `<td>
                                                        <input type="hidden" name="keterampilan_id_kd" id="keterampilan_id_kd" class="form-control form-control-sm" value="${kd.kode_kd}">
                                                        <input type="hidden" name="keterampilan_nilai_totoal_kd" id="keterampilan_nilai_totoal_kd" class="form-control form-control-sm keterampilan_nilai_totoal_kd${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                        <input type="text" name="keterampilan_nilai_kd" id="keterampilan_nilai_kd" class="form-control form-control-sm keterampilan_nilai_kd${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                </td>`;
                            tabel += `<td>
                                                        <input type="hidden" name="keterampilan_nilai_totoal_pts" id="keterampilan_nilai_totoal_pts" class="form-control form-control-sm keterampilan_nilai_totoal_pts${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                        <input type="text" name="keterampilan_nilai_pts" id="keterampilan_nilai_pts" class="form-control form-control-sm keterampilan_nilai_pts${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                </td>`;
                            tabel += `<td>
                                                        <input type="hidden" name="keterampilan_nilai_totoal_pas" id="keterampilan_nilai_totoal_pas" class="form-control form-control-sm keterampilan_nilai_totoal_pas${value.kode_mt}" placeholder="Total Nilai" required readonly>
                                                        <input type="text" name="keterampilan_nilai_pas" id="keterampilan_nilai_pas" class="form-control form-control-sm keterampilan_nilai_pas${value.kode_mt}" placeholder="Nilai" value="0" required>
                                                </td>`;
                            tabel += '</tr>';
                        }
                    });
                    tabel += '<td></td>';
                    tabel += '<td></td>';
                    tabel +=
                        `<td><input type="text" name="as_keterampilan_nilai_totoal_kd" id="as_keterampilan_nilai_totoal_kd" class="form-control form-control-sm as_keterampilan_nilai_totoal_kd${value.kode_mt}" placeholder="Total Nilai" required readonly></td>`;
                    tabel +=
                        `<td><input type="text" name="as_keterampilan_nilai_totoal_pts" id="as_keterampilan_nilai_totoal_pts" class="form-control form-control-sm as_keterampilan_nilai_totoal_pts${value.kode_mt}" placeholder="Total Nilai" required readonly></td>`;
                    tabel +=
                        `<td><input type="text" name="as_keterampilan_nilai_totoal_pas" id="as_keterampilan_nilai_totoal_pas" class="form-control form-control-sm as_keterampilan_nilai_totoal_pas${value.kode_mt}" placeholder="Total Nilai" required readonly></td>`;

                    tabel += '</tr>';

                    // nilai keterampilan kd
                    $(document).on("change", ".keterampilan_nilai_kd" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.keterampilan_nilai_kd' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".keterampilan_nilai_kd" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.as_keterampilan_nilai_totoal_kd' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai keterampilan pts
                    $(document).on("change", ".keterampilan_nilai_pts" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.keterampilan_nilai_pts' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".keterampilan_nilai_pts" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.as_keterampilan_nilai_totoal_pts' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai keterampilan pas
                    $(document).on("change", ".keterampilan_nilai_pas" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.keterampilan_nilai_pas' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".keterampilan_nilai_pas" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.as_keterampilan_nilai_totoal_pas' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai pengethaun kd
                    $(document).on("change", ".keterampilan_nilai_kd" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.keterampilan_nilai_kd' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".keterampilan_nilai_kd" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.keterampilan_nilai_totoal_kd' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai keterampilan pts
                    $(document).on("change", ".keterampilan_nilai_pts" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.keterampilan_nilai_pts' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".keterampilan_nilai_pts" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.keterampilan_nilai_totoal_pts' + value.kode_mt).val(
                                nilai_total);
                        });

                    // nilai keterampilan pas
                    $(document).on("change", ".keterampilan_nilai_pas" + value.kode_mt,
                        function() {
                            var count_not_empty = $('.keterampilan_nilai_pas' + value
                                .kode_mt).filter(function() {
                                return this.value.trim() != 0;
                            }).length;
                            var sum = 0;
                            $(".keterampilan_nilai_pas" + value.kode_mt).each(
                                function() {
                                    sum += +$(this).val();
                                });
                            var nilai_total = parseInt(sum) / parseInt(count_not_empty);
                            $('.keterampilan_nilai_totoal_pas' + value.kode_mt).val(
                                nilai_total);
                        });

                });

                tabel += `
                            </tbody>
                        </table>
                    `;
                $('#tabel-keterampilan').html(tabel);
            }
        });
    });

    $(document).on('click', '#btn-2013-lain-lain', function() {
        $('#default-2013').css('display', 'block');
        $('#penilaian-sikap-2013').css('display', 'none');
        $('#penilaian-pengetahuan-2013').css('display', 'none');
        $('#penilaian-keterampilan-2013').css('display', 'none');
        $('#penilaian-lain-lain-2013').css('display', 'block');

        var kode_kelas = $('#kelas').val();
        var siswa_nisn = $('#sw-nisn').val();

        $('#add-tabel').empty();
        $('#add-tabel-prestasi').empty();

        // get ekskul
        $.ajax({
            url: "{{ url('penilaian/ajax-get-ekstrakulikuler') }}",
            method: "GET",
            data: {
                kode_kelas: kode_kelas,
                siswa_nisn: siswa_nisn,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(resp) {
                var tabel = '';
                tabel += `<table class="table table-bordered mb-0">
                              <tbody>`;
                $(resp).each(function(key, value) {
                    if (value.pnekskul != null) {
                        tabel += `
                                <tr>
                                    <th>
                                        <input type="hidden" name="kode_ekskul" id="kode_ekskul" class="kode_ekskul" value="${value.kode_ekskul}"/>
                                        <p>${value.nama_ekskul}</p>
                                    </th>
                                    <td>
                                        <input type="hidden" name="id_pn_ekskul" id="id_pn_ekskul" class="id_pn_ekskul" value="${value.pnekskul.id_pn_ekskul}"/>
                                        <textarea name="ket-ekskul" id="ket-ekskul" type="text" class="form-control form-control-sm ket-ekskul" rows="3" placeholder="Keterangan">${value.pnekskul.keterangan ?? ""}</textarea>
                                    </td>
                                </tr>
                            `;
                    } else {
                        tabel += `
                                <tr>
                                    <th>
                                        <input type="hidden" name="kode_ekskul" id="kode_ekskul" class="kode_ekskul" value="${value.kode_ekskul}"/>
                                        <p>${value.nama_ekskul}</p>
                                    </th>
                                    <td>
                                        <textarea name="ket-ekskul" id="ket-ekskul" type="text" class="form-control form-control-sm ket-ekskul" rows="3" placeholder="Keterangan"></textarea>
                                    </td>
                                </tr>
                            `;
                    }
                });
                tabel += `</tbody>
                              </table>`;
                $('#tabel-ekskul').html(tabel);
            }
        });

        // get saran
        $.ajax({
            url: "{{ url('penilaian/ajax-get-saran-saran') }}",
            method: "GET",
            data: {
                kode_kelas: kode_kelas,
                siswa_nisn: siswa_nisn,
                _token: '{{ csrf_token() }}'
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(req) {
                if (req.length > 0) {
                    $(req).each(function(key, value) {
                        $('input[id=id_saran_saran]').val(value.id_pn_saran);
                        $('textarea[id=saran-saran]').val(value.saran);
                    })
                } else {
                    $('input[id=id_saran_saran]').val("");
                    $('textarea[id=saran-saran]').val("");
                }
            }
        });

        // get berat dan tinggi badan
        $.ajax({
            url: "{{ url('penilaian/ajax-get-berat-tinggi-badan') }}",
            method: "GET",
            data: {
                kode_kelas: kode_kelas,
                siswa_nisn: siswa_nisn,
                _token: '{{ csrf_token() }}'
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(req) {
                if (req.length > 0) {
                    $(req).each(function(key, value) {
                        $('input[id=id_tinggi_dan_berat_badan]').val(value.id_pn_bb);
                        $('input[id=tinggi-badan]').val(value.tinggi_badan);
                        $('input[id=berat-badan]').val(value.berat_badan);
                    })
                } else {
                    $('input[id=id_tinggi_dan_berat_badan]').val("");
                    $('input[id=tinggi-badan]').val("");
                    $('input[id=berat-badan]').val("");
                }
            }
        });

        // get kondisi keshatan
        $.ajax({
            url: "{{ url('penilaian/ajax-get-kondisi-kesehatan') }}",
            method: "GET",
            data: {
                kode_kelas: kode_kelas,
                siswa_nisn: siswa_nisn,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(req) {
                var tabel = '';
                if (req.length > 0) {
                    $(req).each(function(key, value) {
                        tabel += `
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <input type="hidden" name="id_kondisi" id="id_kondisi" class="form-control form-control-sm" placeholder="Kondisi" required value="${value.id_pn_kondisi_kesehatan}">
                                        <tr id="${value.id_pn_kondisi_kesehatan}">
                                            <th style="width: 30%">
                                                <input type="text" name="kondisi" id="kondisi" class="form-control form-control-sm" placeholder="Kondisi" required value="${value.kondisi}">
                                            </th>
                                            <td>   
                                                <textarea type="text" name="ket-kondisi" id="ket-kondisi" class="form-control form-control-sm" rows="3" placeholder="Keterangan" required>${value.ket_kondisi}</textarea>
                                            </td>
                                            <td style="width: 10%">
                                                <button class="btn btn-sm btn-danger mb-2" name="btn-remove-kesehatan" id="btn-remove-kesehatan${value.id_pn_kondisi_kesehatan}">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            `;
                        // btn remove kesehatan
                        $(document).on('click', '#btn-remove-kesehatan' + value
                            .id_pn_kondisi_kesehatan,
                            function() {
                                $(this).closest('#' + value.id_pn_kondisi_kesehatan)
                                    .remove();
                            });
                    })
                } else {
                    tabel += `
                            <table class="table table-bordered mb-0" id="tabel-kondi-kesahatan">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%">
                                            <input type="text" name="kondisi" id="kondisi" class="form-control form-control-sm" placeholder="Kondisi" required>
                                        </th>
                                        <td>   
                                            <textarea type="text" name="ket-kondisi" id="ket-kondisi" class="form-control form-control-sm" rows="3" placeholder="Keterangan" required></textarea>
                                        </td>
                                        <td style="width: 10%">
                                            <button class="btn btn-sm btn-danger mb-2" name="btn-remove-kesehatan" id="btn-remove-kesehatan">Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        `;
                }
                $('#tabel-kondi-kesahatan').html(tabel);
            }
        });

        // get prestasi
        $.ajax({
            url: "{{ url('penilaian/ajax-get-prestasi') }}",
            method: "GET",
            data: {
                kode_kelas: kode_kelas,
                siswa_nisn: siswa_nisn,
                _token: '{{ csrf_token() }}'
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(req) {
                var tabel = '';
                if (req.length > 0) {
                    $(req).each(function(key, value) {
                        console.log(value);
                        tabel += `
                                <table class="table table-bordered mb-0" id="tabel-prestasi">
                                    <tbody>
                                        <input type="hidden" name="id_prestasi" id="id_prestasi" class="form-control form-control-sm" placeholder="Kondisi" required value="${value.id_pn_prestasi}">
                                        <tr id="${value.id_pn_prestasi}">
                                            <th style="width: 30%">
                                                <input type="text" name="prestasi" id="prestasi" class="form-control form-control-sm" placeholder="Prestasi" required value="${value.prestasi}">
                                            </th>
                                            <td>   
                                                <textarea type="text" name="ket-prestasi" id="ket-prestasi" class="form-control form-control-sm" rows="3" placeholder="Keterangan" required>${value.ket_prestasi}</textarea>
                                            </td>
                                            <td style="width: 10%">
                                                <button class="btn btn-sm btn-danger mb-2" name="btn-remove-prestasi" id="btn-remove-prestasi${value.id_pn_prestasi}">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            `;
                        $(document).on('click', '#btn-remove-prestasi' + value
                            .id_pn_prestasi,
                            function() {
                                $(this).closest('#' + value.id_pn_prestasi).remove();
                            });
                    })
                } else {
                    tabel += `
                            <table class="table table-bordered mb-0" id="tabel-prestasi">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%">
                                            <input type="text" name="prestasi" id="prestasi" class="form-control form-control-sm" placeholder="Prestasi" required>
                                        </th>
                                        <td>   
                                            <textarea type="text" name="ket-prestasi" id="ket-prestasi" class="form-control form-control-sm" rows="3" placeholder="Keterangan" required></textarea>
                                        </td>
                                        <td style="width: 10%">
                                            <button class="btn btn-sm btn-danger mb-2" name="btn-remove-prestasi" id="btn-remove-prestasi">Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        `;
                }
                $('#tabel-prestasi').html(tabel);
            }
        });

    });

    // save btn lain-lain
    $(document).on('click', '#btn-save-lain-lain', function() {

        var siswa_nisn = $('#sw-nisn').val();
        var kode_kelas = $('#kelas').val();

        var kode_ekskul = $('input[id=kode_ekskul]').map(function() {
            return this.value;
        }).get();

        var ket_ekskul = $('textarea[id=ket-ekskul]').map(function() {
            return this.value;
        }).get();

        var saran_saran = $('textarea[id=saran-saran]').val();
        var tinggi_badan = $('input[id=tinggi-badan]').val();
        var berat_badan = $('input[id=berat-badan]').val();
        var konisi = $('input[id=kondisi]').map(function() {
            return this.value;
        }).get();
        var ket_konisi = $('textarea[id=ket-kondisi]').map(function() {
            return this.value;
        }).get();
        var prestasi = $('input[id=prestasi]').map(function() {
            return this.value;
        }).get();
        var ket_prestasi = $('textarea[id=ket-prestasi]').map(function() {
            return this.value;
        }).get();

        // get by id ekskul
        var id_pn_ekskul = $('input[id=id_pn_ekskul]').map(function() {
            return this.value;
        }).get();

        // get id saran
        var id_saran = $('input[id=id_saran_saran]').val();

        // get id tinggi dan berat badan
        var id_tinggi_dan_berat_badan = $('input[id=id_tinggi_dan_berat_badan]').val();

        // get id kondisi kesehatan
        var id_pn_kondisi_kesehatan = $('input[id=id_kondisi]').map(function() {
            return this.value;
        }).get();

        // get id prestasi
        var id_pn_prestasi = $('input[id=id_prestasi]').map(function() {
            return this.value;
        }).get();

        $.ajax({
            url: "{{ url('/penilaian/ajax-save-pn-lain-lain') }}",
            method: "POST",
            data: {
                siswa_nisn: siswa_nisn,
                kode_kelas: kode_kelas,
                kode_ekskul: kode_ekskul,
                ket_ekskul: ket_ekskul,
                saran_saran: saran_saran,
                tinggi_badan: tinggi_badan,
                berat_badan: berat_badan,
                konisi: konisi,
                ket_konisi: ket_konisi,
                prestasi: prestasi,
                ket_prestasi: ket_prestasi,

                // id pn
                id_pn_ekskul: id_pn_ekskul,
                id_saran: id_saran,
                id_tinggi_dan_berat_badan: id_tinggi_dan_berat_badan,
                id_pn_kondisi_kesehatan: id_pn_kondisi_kesehatan,
                id_pn_prestasi: id_pn_prestasi,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            error: function(xhr, ajaxOptions, thrownError) {
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
            },
            success: function(resp) {
                console.log(resp);
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
                $('#penilaian-lain-lain-2013').css('display', 'none');
            }
        });

    })
    // end

    // save penilaian sikap
    $(document).on('click', '#btn_save_sikap', function() {
        var n1_beribadah = $('input[name="beribadah_formRadios"]:checked').val() == undefined ? null : $(
            'input[name="beribadah_formRadios"]:checked').val();
        var n2_syukur = $('input[name="syukur_formRadios"]:checked').val() == undefined ? null : $(
            'input[name="syukur_formRadios"]:checked').val();
        var n3_berdoa = $('input[name="berdoa_formRadios"]:checked').val() == undefined ? null : $(
            'input[name="berdoa_formRadios"]:checked').val();
        var n4_toleransi = $('input[name="toleransi_formRadios"]:checked').val() == undefined ? null : $(
            'input[name="toleransi_formRadios"]:checked').val();
        var siswa_nisn = $('#sw-nisn').val();
        var kelas = $('#kelas').val();
        var id_pn_sikap = $('#id_pn_sikap').val();

        $.ajax({
            url: "{{ url('/penilaian/ajax-save-pn-sikap') }}",
            method: "GET",
            data: {
                siswa_nisn: siswa_nisn,
                kelas: kelas,
                n1_beribadah: n1_beribadah,
                n2_syukur: n2_syukur,
                n3_berdoa: n3_berdoa,
                n4_toleransi: n4_toleransi,
                id_pn_sikap: id_pn_sikap,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(resp) {
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp);
                $('#penilaian-sikap-2013').css('display', 'none');
            }
        });
    })
    // end

    // save penilaian pengetahuan
    $(document).on('click', '#btn_save_pengetahuan', function() {
        var kode_kelas = $('#kelas').val();
        var siswa_nisn = $('#sw-nisn').val();
        var id_kd = $('input[name=pengetahuan_id_kd]').map(function() {
            return this.value;
        }).get();
        var nilai_kd = $('input[id=pengetahuan_nilai_kd]').map(function() {
            return this.value;
        }).get();
        var nilai_pts = $('input[id=pengetahuan_nilai_pts]').map(function() {
            return this.value;
        }).get();
        var nilai_pas = $('input[id=pengetahuan_nilai_pas]').map(function() {
            return this.value;
        }).get();
        var pengetahuan_nilai_totoal_kd = $('input[id=pengetahuan_nilai_totoal_kd]').map(function() {
            return this.value;
        }).get();
        var pengetahuan_nilai_totoal_pts = $('input[id=pengetahuan_nilai_totoal_pts]').map(function() {
            return this.value;
        }).get();
        var pengetahuan_nilai_totoal_pas = $('input[id=pengetahuan_nilai_totoal_pas]').map(function() {
            return this.value;
        }).get();
        $.ajax({
            url: "{{ url('/penilaian/ajax-save-pn-pengetahuan') }}",
            method: "POST",
            data: {
                siswa_nisn: siswa_nisn,
                kode_kelas: kode_kelas,
                id_kd: id_kd,
                nilai_kd: nilai_kd,
                nilai_pts: nilai_pts,
                nilai_pas: nilai_pas,
                pengetahuan_nilai_totoal_kd: pengetahuan_nilai_totoal_kd,
                pengetahuan_nilai_totoal_pts: pengetahuan_nilai_totoal_pts,
                pengetahuan_nilai_totoal_pas: pengetahuan_nilai_totoal_pas,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(resp) {
                console.log(resp);
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
                $('#penilaian-pengetahuan-2013').css('display', 'none');
            }
        });
    })
    // end

    // save penilaian keterampilan
    $(document).on('click', '#btn_save_keterampilan', function() {
        console.log('ook');
        var kode_kelas = $('#kelas').val();
        var siswa_nisn = $('#sw-nisn').val();
        var id_kd = $('input[name=keterampilan_id_kd]').map(function() {
            return this.value;
        }).get();
        var nilai_kd = $('input[id=keterampilan_nilai_kd]').map(function() {
            return this.value;
        }).get();
        var nilai_pts = $('input[id=keterampilan_nilai_pts]').map(function() {
            return this.value;
        }).get();
        var nilai_pas = $('input[id=keterampilan_nilai_pas]').map(function() {
            return this.value;
        }).get();
        var keterampilan_nilai_totoal_kd = $('input[id=keterampilan_nilai_totoal_kd]').map(function() {
            return this.value;
        }).get();
        var keterampilan_nilai_totoal_pts = $('input[id=keterampilan_nilai_totoal_pts]').map(function() {
            return this.value;
        }).get();
        var keterampilan_nilai_totoal_pas = $('input[id=keterampilan_nilai_totoal_pas]').map(function() {
            return this.value;
        }).get();
        $.ajax({
            url: "{{ url('/penilaian/ajax-save-pn-keterampilan') }}",
            method: "POST",
            data: {
                siswa_nisn: siswa_nisn,
                kode_kelas: kode_kelas,
                id_kd: id_kd,
                nilai_kd: nilai_kd,
                nilai_pts: nilai_pts,
                nilai_pas: nilai_pas,
                keterampilan_nilai_totoal_kd: keterampilan_nilai_totoal_kd,
                keterampilan_nilai_totoal_pts: keterampilan_nilai_totoal_pts,
                keterampilan_nilai_totoal_pas: keterampilan_nilai_totoal_pas,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(resp) {
                console.log(resp);
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
                $('#penilaian-keterampilan-2013').css('display', 'none');
            }
        });
    })
    // end

    // btn add kesehatan
    $('#btn-add-kesehatan').on('click', function() {
        var tabel = '';
        tabel += `
                <table class="table table-bordered mb-0" id="input-form-row">
                    <tbody>
                        <tr>
                            <th style="width: 30%">
                                <input type="text" name="kondisi" id="kondisi" class="form-control form-control-sm" placeholder="Kondisi" required>
                            </th>
                            <td>   
                                <textarea type="text" name="ket-kondisi" id="ket-kondisi" class="form-control form-control-sm" rows="3" placeholder="Keterangan" required></textarea>
                            </td>
                            <td style="width: 10%">
                                <button class="btn btn-sm btn-danger mb-2" name="btn-remove-kesehatan" id="btn-remove-kesehatan">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            `;
        $('#add-tabel').append(tabel);
    });

    // btn remove kesehatan
    $(document).on('click', '#btn-remove-kesehatan', function() {
        $(this).closest('#input-form-row').remove();
    });

    // btn add prestasi
    $('#btn-add-prestasi').on('click', function() {
        var tabel = '';
        tabel = `
                <table class="table table-bordered mb-0" id="input-form-row-prestasi">
                    <tbody>
                        <tr>
                            <th style="width: 30%">
                                <input type="text" name="prstasi" id="prestasi" class="form-control form-control-sm" placeholder="Prestasi" required>
                            </th>
                            <td>   
                                <textarea type="text" name="ket-prestasi" id="ket-prestasi" class="form-control form-control-sm" rows="3" placeholder="Keterangan" required></textarea>
                            </td>
                            <td style="width: 10%">
                                <button class="btn btn-sm btn-danger mb-2" name="btn-remove-prestasi" id="btn-remove-prestasi">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            `;
        $('#add-tabel-prestasi').append(tabel);
    });

    // btn remove prestasi
    $(document).on('click', '#btn-remove-prestasi', function() {
        $(this).closest('#input-form-row-prestasi').remove();
    });
</script>

{{-- script penilaian k2022 --}}
<script>
    $(document).on('click', '#btn-pilih-siswa', function() {
        $('#form-pn-2022').css('display', 'flex');
        $('#penilaian-for-sum-2022').css('display', 'none');
        $('#penilaian-ekskul-2022').css('display', 'none');
    });

    $(document).on('click', '#btn-penilaian-for-sum', function() {
        let siswa = $('#nisn').val();
        var kode_kelas = $('#kelas').val();
        $('#penilaian-for-sum-2022').css('display', 'block');
        $('#penilaian-ekskul-2022').css('display', 'none');
        $.ajax({
            url: "{{ url('/penilaian/ajax-get-pn-for-sum') }}",
            method: "GET",
            data: {
                nisn: siswa,
                kelas_siswa: kode_kelas,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(resp) {
                var tabel = '';
                tabel += `
                        <table class="table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th style="width:20%">Mata Pelajaran</th>
                                    <th style="width:20%">Materi Pembelajaran</th>
                                    <th style="width:30%">Tujuan Pembelajaran</th>
                                    <th style="width:10%">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                $(resp.mata_pelajaran).each(function(key, value) {
                    var obj_formatif = {};
                    var obj_sumatif = {};
                    var obj_akhir_sumatif = {};
                    tabel += '<tr>';
                    tabel += '<td rowspan="' + (resp.count_mata_tj[value.kode_mt] + 4) +
                        '">' + value.nama_mt + '</td>';
                    $(value.materi_pembelajaran).each(function(a, b) {
                        $(b.tujuan_pembelajaran).each(function(c, d) {
                            var nilai_tp = (d.pn_fm_sm != null) ? d.pn_fm_sm
                                .nilai_tp : null;
                            var id_fm_sm = (d.pn_fm_sm != null) ? d.pn_fm_sm
                                .id_penilaian_fm_sm : null;
                            obj_formatif[value.kode_mt] = (d.pn_fm_sm !=
                                null) ? d.pn_fm_sm.nilai_formatif : null;
                            obj_sumatif[value.kode_mt] = (d.pn_fm_sm !=
                                null) ? d.pn_fm_sm.nilai_sumatif : null;
                            obj_akhir_sumatif[value.kode_mt] = (d
                                    .pn_fm_sm != null) ? d.pn_fm_sm
                                .nilai_akhir_sumatif : null;
                            tabel += '<tr>';
                            tabel += '<td>' + b.materi_pembelajaran +
                                '</td>';
                            tabel += '<td>' + d.nama_tujuan + '</td>';
                            tabel +=
                                `<td><input value="${nilai_tp}" type="number" name="nilai_fm_sm" id="nilai_fm_sm" class="form-control form-control-sm nilai_fm_sm_${value.kode_mt} nilai_fm_sm_${b.kode_materi}" placeholder="Nilai" required>`;
                            tabel +=
                                `<input value="${d.kode_tujuan}" type="hidden" name="kode_tujuan" id="kode_tujuan" class="form-control form-control-sm kode_tujuan_${d.kode_tujuan}" required>`;
                            tabel +=
                                `<input value="${id_fm_sm}" type="hidden" name="id_pn_fm_sm" id="id_fm_sm" class="form-control form-control-sm id_fm_sm_${d.kode_tujuan}" required></td>`;
                            tabel += '</tr>';

                            $(document).on('change', '.nilai_fm_sm_' + value
                                .kode_mt,
                                function() {
                                    var count_nilai_formatif = $(
                                        '.nilai_fm_sm_' + value
                                        .kode_mt).filter(
                                        function() {
                                            return this.value
                                                .trim() != 0;
                                        }).length;

                                    // formatif
                                    var sum_d = 0;
                                    $('.nilai_fm_sm_' + value.kode_mt)
                                        .each(function() {
                                            sum_d += +$(this).val();
                                        });
                                    var sum_formatif = parseInt(sum_d) /
                                        parseInt(count_nilai_formatif);
                                    $('.nilai_formatif' + value.kode_mt)
                                        .val(sum_formatif);
                                });
                        })

                        tabel +=
                            `<input type="hidden" name="nilai_sm" id="nilai_sm" class="form-control form-control-sm nilai_total_sm_${value.kode_mt} nilai_sm_${b.kode_materi}" placeholder="Nilai" required>`;

                        $(document).on('change', '.nilai_fm_sm_' + value.kode_mt,
                            function() {
                                var count_nilai = $('.nilai_fm_sm_' + b
                                    .kode_materi).filter(function() {
                                    return this.value.trim() != 0;
                                }).length;

                                // sumatif
                                var sum = 0;
                                $('.nilai_fm_sm_' + b.kode_materi).each(
                                    function() {
                                        sum += +$(this).val();
                                    });
                                var nilai_sumatif = parseInt(sum) / parseInt(
                                    count_nilai);
                                $('.nilai_sm_' + b.kode_materi).val(
                                    nilai_sumatif);
                                var sum_a = 0;
                                $('.nilai_total_sm_' + value.kode_mt).each(
                                    function() {
                                        sum_a += +$(this).val();
                                    });
                                var sum_nilai_sumatif = parseInt(sum_a) / value
                                    .materi_pembelajaran.length;
                                $('.nilai_sumatif' + value.kode_mt).val(
                                    sum_nilai_sumatif);
                            });
                    })
                    tabel += '</tr>';

                    var nilai_formatif = (obj_formatif != null || obj_formatif != '') ?
                        obj_formatif[value.kode_mt] : null;
                    var nilai_sumatif = (obj_sumatif != null || obj_sumatif != '') ?
                        obj_sumatif[value.kode_mt] : null;
                    var nilai_akhir_sumatif = (obj_akhir_sumatif != null ||
                            obj_akhir_sumatif != '') ? obj_akhir_sumatif[value.kode_mt] :
                        null;

                    if (value.materi_pembelajaran.length > 0) {
                        tabel += '<tr>';
                        tabel += '<td colspan="2">Nilai Formatif</td>';
                        tabel +=
                            `<td><input value="${nilai_formatif}" type="number" name="nilai_formatif" id="nilai_formatif_${value.kode_mt}" class="form-control form-control-sm nilai_formatif${value.kode_mt}" placeholder="Nilai Formatif" required readonly></td>`;
                        tabel += '</tr>';
                        tabel += '<tr>';
                        tabel += '<td colspan="2">Nilai Sumatif</td>';
                        tabel +=
                            `<td><input value="${nilai_sumatif}" type="number" name="nilai_sumatif" id="nilai_sumatif" class="form-control form-control-sm nilai_sumatif${value.kode_mt}" placeholder="Nilai Sumatif" required readonly></td>`;
                        tabel += '</tr>';
                        tabel += '<tr>';
                        tabel += '<td colspan="2">Nilai Akhir Sumatif</td>';
                        tabel +=
                            `<td><input value="${nilai_akhir_sumatif}" type="number" name="nilai_akhir_sumatif" id="nilai_akhir_sumatif" class="form-control form-control-sm nilai_akhir_sumatif${value.kode_mt}" placeholder="Nilai Akhir Sumatif" required></td>`;
                        tabel += '</tr>';
                        tabel +=
                            `<input value="${value.kode_mt}" type="hidden" name="kode_mt" id="kode_mt" class="form-control form-control-sm kode_mt${value.kode_mt}" placeholder="Kode Mata Pelajaran" required readonly>`;
                    }
                })

                tabel += `
                            </tbody>
                        </table>
                    `;
                $('#tabel-for-sum').html(tabel);
                console.log(resp);
            }
        });
    });

    $('#btn_save_for_sum').on('click', function() {
        var nisn = $('#nisn').val();
        var kode_kelas = $('#kelas').val();
        var kode_tujuan = $('input[name=kode_tujuan').map(function() {
            return this.value
        }).get();
        var nilai_fm_sm = $('input[name=nilai_fm_sm').map(function() {
            return this.value
        }).get();
        var nilai_formatif = $('input[name=nilai_formatif').map(function() {
            return this.value
        }).get();
        var nilai_sumatif = $('input[name=nilai_sumatif').map(function() {
            return this.value
        }).get();
        var nilai_akhir_sumatif = $('input[name=nilai_akhir_sumatif').map(function() {
            return this.value
        }).get();
        var kode_mt = $('input[name=kode_mt]').map(function() {
            return this.value
        }).get();
        var id_pn_fm_sm = $('input[name=id_pn_fm_sm]').map(function() {
            return this.value
        }).get();

        $.ajax({
            url: "{{ url('/penilaian/ajax-save-pn-fm-sm') }}",
            method: "POST",
            data: {
                nisn: nisn,
                kode_kelas: kode_kelas,
                kode_tujuan: kode_tujuan,
                nilai_fm_sm: nilai_fm_sm,
                nilai_formatif: nilai_formatif,
                nilai_sumatif: nilai_sumatif,
                nilai_akhir_sumatif: nilai_akhir_sumatif,
                kode_mt: kode_mt,
                id_pn_fm_sm: id_pn_fm_sm,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            error: function(xhr, ajaxOptions, thrownError) {
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
            },
            success: function(resp) {
                console.log(resp);
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
                $('#penilaian-for-sum-2022').css('display', 'none');
            }
        })
    });

    // penilaian ekskul
    $(document).on('click', '#btn-penilaian-ekskul-2022', function() {
        $('#penilaian-for-sum-2022').css('display', 'none');
        $('#penilaian-ekskul-2022').css('display', 'block');
        var kode_kelas = $('#kelas').val();
        var siswa_nisn = $('#sw-nisn').val();
        // get ekskul
        $.ajax({
            url: "{{ url('penilaian/ajax-get-ekstrakulikuler') }}",
            method: "GET",
            data: {
                kode_kelas: kode_kelas,
                siswa_nisn: siswa_nisn,
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            success: function(resp) {
                var tabel = '';
                tabel += `<table class="table table-bordered mb-0">
                              <tbody>`;
                $(resp).each(function(key, value) {
                    if (value.pnekskul != null) {
                        tabel += `
                                <tr>
                                    <th>
                                        <input type="hidden" name="kode_ekskul-2022" id="kode_ekskul-2022" class="kode_ekskul-2022" value="${value.kode_ekskul}"/>
                                        <p>${value.nama_ekskul}</p>
                                    </th>
                                    <td>
                                        <input type="hidden" name="id_pn_ekskul-2022" id="id_pn_ekskul-2022" class="id_pn_ekskul-2022" value="${value.pnekskul.id_pn_ekskul}"/>
                                        <textarea name="ket-ekskul-2022" id="ket-ekskul-2022" type="text" class="form-control form-control-sm ket-ekskul-2022" rows="3" placeholder="Keterangan">${value.pnekskul.keterangan ?? ""}</textarea>
                                    </td>
                                </tr>
                            `;
                    } else {
                        tabel += `
                                <tr>
                                    <th>
                                        <input type="hidden" name="kode_ekskul-2022" id="kode_ekskul-2022" class="kode_ekskul-2022" value="${value.kode_ekskul}"/>
                                        <p>${value.nama_ekskul}</p>
                                    </th>
                                    <td>
                                        <textarea name="ket-ekskul-2022" id="ket-ekskul-2022" type="text" class="form-control form-control-sm ket-ekskul-2022" rows="3" placeholder="Keterangan"></textarea>
                                    </td>
                                </tr>
                            `;
                    }
                });
                tabel += `</tbody>
                    </table>`;
                $('#tabel-ekskul-2022').html(tabel);
            }
        });
    });

    $(document).on('click', '#btn-save-ekskul-2022', function() {
        var kode_kelas = $('#kelas').val();
        var siswa_nisn = $('#sw-nisn').val();
        var kode_ekskul_2022 = $('input[id=kode_ekskul-2022]').map(function() {
            return this.value;
        }).get();
        var ket_ekskul_2022 = $('textarea[id=ket-ekskul-2022]').map(function() {
            return this.value;
        }).get();
        var id_pn_ekskul_2022 = $('input[id=id_pn_ekskul-2022]').map(function() {
            return this.value;
        }).get();
        $.ajax({
            url: "{{ url('/penilaian/ajax-save-ekskul-2022') }}",
            method: "POST",
            data: {
                siswa_nisn: siswa_nisn,
                kode_kelas: kode_kelas,
                kode_ekskul_2022: kode_ekskul_2022,
                ket_ekskul_2022: ket_ekskul_2022,
                id_pn_ekskul_2022: id_pn_ekskul_2022,
                _token: "{{ csrf_token() }}"
            },
            cache: false,
            dataType: "json",
            error: function(xhr, ajaxOptions, thrownError) {
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
            },
            success: function(resp) {
                console.log(resp);
                $('.succ').css('display', 'block');
                $('.scc-text').text(resp.response);
                $('#penilaian-ekskul-2022').css('display', 'none');
            }
        })
    })
</script>

</html>
