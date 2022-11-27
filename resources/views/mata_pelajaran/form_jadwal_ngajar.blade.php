@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => $title . ' Data Jadwal Mengajar'])
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
                    'title' => $title . ' Data Jadwal Mengajar',
                ])

                {{-- isi conten --}}

                <form method="POST" action="{{ route('mata.pelajaran.save.jadwal.ngajar') }}">
                    @csrf
                    <!-- Right Sidebar Data Siswa -->
                    <div>
                        <div class="card">
                            <div class="card-body">

                                <div style="margin-left: 20px;">

                                    {{-- id --}}
                                    <input type="hidden" name="id"
                                        value="{{ !empty($jadwal_ngajar) ? $jadwal_ngajar->id_jadwal_ngajar : '' }}">

                                    {{-- kurikulum --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kurikulum *</label>
                                        <div class="col-sm-10">
                                            <select name="kurikulum" id="kurikulum" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="" disabled>Pilih Kurikulum</option>
                                                @foreach ($list_kurikulum as $keys => $kurikulum)
                                                    <option value="{{ $kurikulum->kode_kurikulum }}"
                                                        {{ (!empty($jadwal_ngajar) ? $jadwal_ngajar->kode_kurikulum == $kurikulum->kode_kurikulum : '') ? 'selected' : '' }}>
                                                        {{ $kurikulum->kode_kurikulum . ' - ' . $kurikulum->nama_kurikulum }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Kelas --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kelas *</label>
                                        <div class="col-sm-10">
                                            <select name="kelas" id="kelas" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="" disabled>Pilih Kelas</option>
                                                @foreach ($list_kelas as $item => $kelas)
                                                    <option value="{{ $kelas->kode_kelas }}"
                                                        {{ (!empty($jadwal_ngajar) ? $jadwal_ngajar->kode_kelas == $kelas->kode_kelas : '') ? 'selected' : '' }}>
                                                        {{ $kelas->kode_kelas . ' - ' . $kelas->ket_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Mapel --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Mata Pelajaran *</label>
                                        <div class="col-sm-10">
                                            <select name="mata_pelajaran" id="mata_pelajaran" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="" disabled>Pilih Mata Pelajaran</option>
                                                {{-- @foreach ($list_guru as $keys => $guru) --}}
                                                {{-- @endforeach --}}
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Jan Ngajar --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Jam *</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="time" id="jam" name="jam"
                                                value="{{ !empty($jadwal_ngajar) ? $jadwal_ngajar->jam_ngajar : '' }}"
                                                placeholder="Jam Mengajar" required>
                                        </div>
                                    </div>

                                    {{-- Semester --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Semester *</label>
                                        <div class="col-sm-10">
                                            <select name="semester" id="semester" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="" disabled>Pilih Semester</option>
                                                @foreach ($list_semester as $sm => $semester)
                                                    <option value="{{ $semester->id }}"
                                                        {{ (!empty($jadwal_ngajar) ? $jadwal_ngajar->id_semester == $semester->id : '') ? 'selected' : '' }}>
                                                        {{ $semester->nama_smester }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Mapel --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Tahun Ajaran *</label>
                                        <div class="col-sm-10">
                                            <select name="tahun_ajaran" id="tahun_ajaran" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="" disabled>Pilih Tahun Ajaran</option>
                                                @foreach ($list_tahun_ajaran as $ta => $tahun_ajaran)
                                                    <option value="{{ $tahun_ajaran->id_tahun_ajaran }}"
                                                        {{ (!empty($jadwal_ngajar) ? $jadwal_ngajar->id_tahun_ajaran == $tahun_ajaran->id_tahun_ajaran : '') ? 'selected' : '' }}>
                                                        {{ $tahun_ajaran->tahun_ajaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        @if ($jadwal_ngajar == null)
                                            <button type="submit" name="action" value="tambah"
                                                class="btn btn-success waves-effect waves-light">
                                                <i class="ri-check-line align-middle me-2"></i> Simpan
                                            </button>
                                        @else
                                            <button type="submit" name="action" value="ubah"
                                                class="btn btn-success waves-effect waves-light">
                                                <i class="ri-check-line align-middle me-2"></i> Ubah
                                            </button>
                                        @endif
                                        <button type="reset" class="btn btn-danger waves-effect waves-light">
                                            <i class="ri-close-line align-middle me-2"></i> Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
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

<script src={{ asset('assets/js/app.js') }}></script>
<script>
    $(document).ready(function() {
        var kurikulum = "{!! !empty($jadwal_ngajar) ? $jadwal_ngajar->kode_kurikulum : '' !!}";
        var kelas = "{!! !empty($jadwal_ngajar) ? $jadwal_ngajar->kode_kelas : '' !!}";
        var kode_mt = "{!! !empty($jadwal_ngajar) ? $jadwal_ngajar->kode_mt : '' !!}";

        console.log(kelas)
        $('#kelas').on('change', function() {
            var kurikulum = $('#kurikulum').val();
            var kelas = $(this).val();
            getKelas(kelas, kurikulum, kode_mt);
        })

        $('#kurikulum').on('change', function() {
            var kelas = $('#kelas').val();
            var kurikulum = $(this).val();
            getKelas(kelas, kurikulum, kode_mt);
        })

        getKelas(kelas, kurikulum, kode_mt);
    })

    function getKelas(kelas, kurikulum, kode_mt) {
        var html = '';
        if (kelas == null || kurikulum == null) {
            html += `
                <option>pilih kelas dan kurikulum terlebih dahulu</option>;
            `;
            $('#mata_pelajaran').html(html);
        } else {
            $.ajax({
                type: "POST",
                url: "{{ url('/mata-pelajaran/ajax-get-mapel') }}",
                data: {
                    kelas: kelas,
                    kurikulum: kurikulum,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response) {
                    console.log(kode_mt);
                    if (response.length < 1) {
                        html += `
                            <option>data tidak ditemukan!</option>;
                        `;
                    } else {
                        $.each(response, function(index, value) {
                            html += `
                                <option value="${value.kode_mt}" ${kode_mt == value.kode_mt ? 'selected' : ''} >${value.kode_mt} - ${value.nama_mt} </option>;
                            `;
                        });
                    }
                    $('#mata_pelajaran').html(html);
                }
            });
        }

    }
</script>
</body>

</html>
