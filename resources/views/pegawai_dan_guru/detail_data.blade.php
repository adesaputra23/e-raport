@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
    use App\PegawaiDanGuru;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Detail Data Pegawai dan Guru'])
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
                    'title' => 'Detail Data Pegawai dan Guru',
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
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="email-rightbar mb-3">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width: 30%">NAMA PEGAWAI</th>
                                                <td>{{ $data_karyawan != null ? $data_karyawan->nama : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">NIP</th>
                                                <td>{{ $data_karyawan != null ? $data_karyawan->nik : '-' }}</td>
                                            </tr>

                                            @if ($data_karyawan->jabatan == PegawaiDanGuru::KEPALA_SEKOLAH)
                                                <tr>
                                                    <th scope="row">NIP Guru</th>
                                                    <td>{{ $data_karyawan != null ? $data_karyawan->nip_2 : '-' }}</td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <th scope="row">EMAIL</th>
                                                <td>{{ $data_karyawan != null ? $data_karyawan->User->email : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">JENIS KELAMIN</th>
                                                <td>{{ $data_karyawan->jenis_kelamin == 1 ? 'Laki-Laki' : 'Perempuan' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">TANGGAL LAHIR</th>
                                                <td>{{ $data_karyawan != null ? $data_karyawan->tanggal_lahir : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">JABATAN</th>
                                                <td>{{ $data_karyawan->jabatan == 1 ? 'Kepala Sekolah' : 'Guru' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">STATUS</th>
                                                <td>{{ PegawaiDanGuru::MAP_STATUS[$data_karyawan->status] }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">LULUSAN</th>
                                                <td>{{ $data_karyawan != null ? $data_karyawan->lulusan : '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
