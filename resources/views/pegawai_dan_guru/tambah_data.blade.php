@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Tambah Data Pegawai dan Guru'])
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
                    'title' => 'Tambah Data Pegawai dan Guru',
                ])

                {{-- isi conten --}}

                <form method="POST" action={{ route('pegawai.simpan.data.admin') }} enctype="multipart/form-data">
                    @csrf
                    <!-- Left sidebar -->
                    <div class="email-leftbar card">
                        <!-- User details -->
                        <div class="user-profile text-center mt-3">
                            <div class="">
                                @if ($data_karyawan == null)
                                    <img src={{ asset('assets/images/users/default_profileXz.png') }} alt=""
                                        class="avatar-xl">
                                @else
                                    @if ($data_karyawan->foto == null)
                                        <img src={{ asset('assets/images/users/default_profileXz.png') }} alt=""
                                            class="avatar-xl">
                                    @else
                                        <img src={{ asset('assets/images/users/') . '/' . $data_karyawan->foto }}
                                            alt="" class="avatar-xl">
                                    @endif
                                @endif
                            </div>
                            @if ($data_karyawan != null)
                                <div class="mt-3">
                                    <h4 class="font-size-16 mb-1">{{ $data_karyawan->nama }}</h4>
                                    <p class="user-code">{{ $data_karyawan->nik }}</p>
                                </div>
                            @endif
                            <div class="mt-2">
                                <h4 class="card-title">Upload Foto</h4>
                                <div class="input-group">
                                    <input value="{{ old('foto') }}" type="file"
                                        class="form-control form-control-sm" id="customFile" name="foto">
                                </div>
                                @error('foto')
                                    <small class="text-danger">
                                        <i class="fa fa-warning"></i>
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="email-rightbar mb-3">
                        <div class="card">
                            <div class="card-body">

                                {{-- nik --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">NIP</label>
                                    <div class="col-sm-10">
                                        <input name="nik"
                                            value="{{ $data_karyawan != null ? $data_karyawan->nik : old('nik') }}"
                                            class="form-control" type="text" placeholder="NIP Pegawai/Guru"
                                            id="example-text-input" @if ($data_karyawan != null) readonly @endif
                                            required>
                                        @error('nik')
                                            <small class="text-danger">
                                                <i class="fa fa-warning"></i>
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- nik --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input name="email"
                                            value="{{ $data_karyawan != null ? $data_karyawan->User->email : old('email') }}"
                                            class="form-control" type="email" placeholder="Email Pegawai/Guru"
                                            id="example-text-input" required>
                                        @error('email')
                                            <small class="text-danger">
                                                <i class="fa fa-warning"></i>
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nama --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input name="nama"
                                            value="{{ $data_karyawan != null ? $data_karyawan->nama : old('nama') }}"
                                            class="form-control" type="text" placeholder="Nama Pegawai/Guru"
                                            id="example-text-input" required>
                                    </div>
                                </div>

                                {{-- jenis kelmain --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <select value="{{ old('nama') }}" name="jenis_kelamin" class="form-select"
                                            aria-label="Default select example" required>
                                            <option selected="" disabled>Pilih Jenis Kelamin</option>
                                            @if ($data_karyawan != null)
                                                <option value="1"
                                                    {{ $data_karyawan->jenis_kelamin == 1 ? 'selected' : '' }}>
                                                    Laki-Laki</option>
                                                <option value="2"
                                                    {{ $data_karyawan->jenis_kelamin == 2 ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            @else
                                                <option value="1"
                                                    {{ old('jenis_kelamin') == 1 ? 'selected' : '' }}>Laki-Laki
                                                </option>
                                                <option value="2"
                                                    {{ old('jenis_kelamin') == 2 ? 'selected' : '' }}>Perempuan
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- tanggal lahir --}}
                                <div class="row mb-3">
                                    <label for="example-date-input" class="col-sm-2 col-form-label">Tanggal
                                        Lahir</label>
                                    <div class="col-sm-10">
                                        <input name="tanggal_lahir"
                                            value="{{ $data_karyawan != null ? $data_karyawan->tanggal_lahir : old('tanggal_lahir') }}"
                                            class="form-control" type="date" value="Tanggal Lahir Pegawai/Guru"
                                            id="example-date-input" required>
                                    </div>
                                </div>

                                {{-- Jabatan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Jabatan</label>
                                    <div class="col-sm-10">
                                        <select name="jabatan" class="form-select" aria-label="Default select example"
                                            required>
                                            <option selected="" disabled>Pilih Jabatan</option>
                                            @if ($data_karyawan != null)
                                                <option value="1"
                                                    {{ $data_karyawan->jabatan == 1 ? 'selected' : '' }}>Kepala Sekolah
                                                </option>
                                                <option value="2"
                                                    {{ $data_karyawan->jabatan == 2 ? 'selected' : '' }}>Guru</option>
                                                <option value="4"
                                                    {{ $data_karyawan->jabatan == 4 ? 'selected' : '' }}>Petugas TU
                                                </option>
                                                <option value="3"
                                                    {{ $data_karyawan->jabatan == 3 ? 'selected' : '' }}>Lain-Lain
                                                </option>
                                            @else
                                                <option value="1" {{ old('jabatan') == 1 ? 'selected' : '' }}>
                                                    Kepala Sekolah</option>
                                                <option value="2" {{ old('jabatan') == 2 ? 'selected' : '' }}>Guru
                                                </option>
                                                <option value="4" {{ old('jabatan') == 4 ? 'selected' : '' }}>
                                                    Petugas TU</option>
                                                <option value="3" {{ old('jabatan') == 3 ? 'selected' : '' }}>
                                                    Lain-Lain</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- Jabatan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-select"
                                            aria-label="Default select example" required>
                                            <option selected="">Pilih Status</option>
                                            @foreach ($list_staus as $key => $status)
                                                <option value="{{ $key }}"
                                                    {{ $data_karyawan != null && $data_karyawan->status == $key ? 'selected' : old('status') }}>
                                                    {{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Nama --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Lulusan</label>
                                    <div class="col-sm-10">
                                        <input name="lulusan"
                                            value="{{ $data_karyawan != null ? $data_karyawan->lulusan : old('lulusan') }}"
                                            class="form-control" type="text"
                                            placeholder="Lulusan Terakhir Pegawai/Guru" id="example-text-input"
                                            required>
                                    </div>
                                </div>

                                <div class="float-end">
                                    @if ($data_karyawan == null)
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
</body>

</html>
