@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
    use App\Kurikulum;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Tambah Data Mata Pelajaran'])
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
                    'title' => 'Tambah Data Mata Pelajaran',
                ])

                {{-- isi conten --}}

                <form method="POST" action="{{ route('mata.pelajaran.simpan.data.admin') }}">
                    @csrf
                    <!-- Right Sidebar Data Siswa -->
                    <div>
                        <div class="card">
                            <div class="card-body">

                                <div style="margin-left: 20px;">

                                    {{-- id --}}
                                    @if ($get_mata_pelajaran != null)
                                        <input type="hidden" name="id" value="{{ $get_mata_pelajaran->id }}">
                                    @endif

                                    {{-- tahun ajaran --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Kode Mata
                                            Pelajaran *</label>
                                        <div class="col-sm-10">
                                            <input name="kode_mt"
                                                value="{{ $get_mata_pelajaran != null ? $get_mata_pelajaran->kode_mt : old('kode_mt') }}"
                                                class="form-control" type="text" placeholder="Kode Mata Pelajran"
                                                id="kode_mt" @if ($get_mata_pelajaran != null) readonly @endif
                                                required>
                                            @error('kode_mt')
                                                <small class="text-danger">
                                                    <i class="fa fa-warning"></i>
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- nama  --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Mata Pelajaran
                                            *</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nama_mt" class="form-control"
                                                value="{{ $get_mata_pelajaran != null ? $get_mata_pelajaran->nama_mt : old('nama_mt') }}"
                                                placeholder="Mata Pelajaran" required>
                                        </div>
                                    </div>

                                    {{-- keterangan  --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input"
                                            class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                            <textarea name="desc_mt" class="form-control" rows="3">{{ $get_mata_pelajaran != null ? $get_mata_pelajaran->desc_mt : old('desc_mt') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- guru --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Guru *</label>
                                        <div class="col-sm-10">
                                            <select value="{{ old('guru') }}" name="guru" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="" disabled>Pilih Guru</option>
                                                @foreach ($list_guru as $keys => $guru)
                                                    <option value="{{ $guru->nik }}"
                                                        {{ $get_mata_pelajaran != null && $guru->nik === $get_mata_pelajaran->nik ? 'selected' : '' }}>
                                                        {{ '(' . $guru->nik . ') - ' . $guru->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- kelas --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kelas *</label>
                                        <div class="col-sm-10">
                                            <select value="{{ old('kelas') }}" name="kelas" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected="" disabled>Pilih Kelas</option>
                                                @foreach ($list_kelas as $keys => $kelas)
                                                    <option value="{{ $kelas->kode_kelas }}"
                                                        {{ $get_mata_pelajaran != null && $kelas->kode_kelas === $get_mata_pelajaran->kode_kelas ? 'selected' : '' }}>
                                                        {{ '(' . $kelas->kode_kelas . ') - ' . $kelas->ket_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- kurikulum --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kurikulum *</label>
                                        <div class="col-sm-10">
                                            <select value="{{ old('kurikulum') }}" name="kurikulum" id="kurikulum" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected="" disabled>Pilih Kurikulum</option>
                                                @foreach ($list_kurikulum as $keys => $kurikulum)
                                                    <option value="{{ $kurikulum->kode_kurikulum }}"
                                                        {{ $get_mata_pelajaran != null && $kurikulum->kode_kurikulum === $get_mata_pelajaran->kode_kurikulum ? 'selected' : '' }}>
                                                        {{ '(' . $kurikulum->kode_kurikulum . ') - ' . $kurikulum->desc_kurikulum }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- KKM  --}}
                                    <div class="nilai_kkm"
                                        @if (!empty($get_mata_pelajaran) && $get_mata_pelajaran->kode_kurikulum == Kurikulum::K13)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif
                                    >
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Nilai KKM *</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="nilai_kkm" id="nilai_kkm" class="form-control"
                                                    value="{{ $get_mata_pelajaran != null ? $get_mata_pelajaran->nilai_kkm : old('nilai_kkm') }}"
                                                    placeholder="Nilai KKM" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- semester --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Semester *</label>
                                        <div class="col-sm-10">
                                            <select value="{{ old('semester') }}" name="semester" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected="" disabled>Pilih Semester</option>
                                                @foreach ($list_semester as $keys => $semester)
                                                    <option value="{{ $semester->id }}"
                                                        {{ $get_mata_pelajaran != null && $semester->id === $get_mata_pelajaran->id_semester ? 'selected' : '' }}>
                                                        {{ $semester->nama_smester }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- tahun ajaran --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Tahun Ajaran *</label>
                                        <div class="col-sm-10">
                                            <select value="{{ old('tahun_ajaran') }}" name="tahun_ajaran"
                                                class="form-select" aria-label="Default select example" required>
                                                <option selected="" disabled>Pilih Tahun Ajaran</option>
                                                @foreach ($list_tahun_ajaran as $keys => $tahun_ajaran)
                                                    <option value="{{ $tahun_ajaran->id_tahun_ajaran }}"
                                                        {{ $get_mata_pelajaran != null && $tahun_ajaran->id_tahun_ajaran === $get_mata_pelajaran->id_tahun_ajaran ? 'selected' : '' }}>
                                                        {{ $tahun_ajaran->tahun_ajaran }}
                                                    </option>
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
                                        @if ($get_mata_pelajaran == null)
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
    $('#kurikulum').on('change', function(e){
        var val = $(this).val();
        if (val == 'KR13') {
            $('.nilai_kkm').css('display', 'block');
            $('#nilai_kkm').attr('required', true);
        }else{
            $('.nilai_kkm').css('display', 'none');
            $('#nilai_kkm').attr('required', false);
        }
    });
</script>
</body>

</html>
