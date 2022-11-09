@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
    use App\PegawaiDanGuru;
    use App\User;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Detail Data Siswa'])
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
                    'title' => 'Detail Data Siswa',
                ])

                {{-- isi conten --}}
                <!-- Left sidebar -->
                <div class="email-leftbar card">
                    <!-- User details -->
                    <div class="user-profile text-center mt-3">
                        @if (RoleUser::CheckRole()->user_role === RoleUser::Admin)
                            <a href="{{ URL(Session::get('prefix') . '/siswa/form-tambah-data', ['nisn' => $siswa->nisn]) }}"
                                class="btn btn-sm btn-warning w-100 mb-2" style="margin-top: -25px;">Edit
                                Data</a>
                        @endif
                        <div class="">
                            @if ($siswa == null)
                                <img src={{ asset('assets/images/users/default_profileXz.png') }} alt=""
                                    class="avatar-xl">
                            @else
                                @if ($siswa->foto == null)
                                    <img src={{ asset('assets/images/users/default_profileXz.png') }} alt=""
                                        class="avatar-xl">
                                @else
                                    <img src={{ asset('assets/images/users/') . '/' . $siswa->foto }} alt=""
                                        class="avatar-xl">
                                @endif
                            @endif
                        </div>
                        @if ($siswa != null)
                            <div class="mt-3">
                                <h4 class="font-size-16 mb-1">{{ $siswa->nama }}</h4>
                                <p class="user-code">{{ $siswa->nisn }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="email-rightbar mb-3">
                    <div class="card">
                        {{-- data siswa --}}
                        <div class="card-body">
                            <p><b>Data Siswa</b></p>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm m-0" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <td scope="row" style="width: 30%">Nama Siswa</td>
                                            <td>: {{ $siswa->nama }} </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Nisn</td>
                                            <td>: {{ $siswa->nisn ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Nis</td>
                                            <td>: {{ $siswa->nis ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Jenis Kelamin</td>
                                            <td>: {{ $siswa->jenis_kelamin == 1 ? 'Laki-Laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Tempat, Tanggal Lahir</td>
                                            <td>:
                                                {{ $siswa->tempat_lahir ?? '-' }} {{ ',' }}
                                                {{ $siswa->tanggal_lahir ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Agama</td>
                                            <td>: {{ User::MAP_AGAMA[$siswa->agama] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Alamat</td>
                                            <td>: {{ $siswa->alamat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Status Anak</td>
                                            <td>: {{ $siswa->status_anak ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Kontak</td>
                                            <td>: {{ $siswa->kontak ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Negara</td>
                                            <td>: {{ $siswa->negara ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Provinsi</td>
                                            <td>: {{ $siswa->provinsi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Kota</td>
                                            <td>: {{ $siswa->kota ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Kode Pos</td>
                                            <td>: {{ $siswa->kode_pos ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">No Telpon Rumah</td>
                                            <td>: {{ $siswa->no_tlp_rumah ?? '-' }}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                        <div class="card-body">
                            <p><b>Data Orang Tua</b></p>
                            <hr>
                            <div class="table-responsive">
                                <p style="font-size: 12px"><b>Data Ayah</b></p>
                                <table class="table table-sm m-0" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <td scope="row" style="width: 30%">NIK</td>
                                            <td>: {{ $siswa->nik_ayah ?? '-' }} </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Nama Ayah</td>
                                            <td>: {{ $siswa->nama_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Pekerjaan</td>
                                            <td>: {{ $siswa->pekerjaan_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">No Telpon</td>
                                            <td>: {{ $siswa->telpon_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Pendidikan</td>
                                            <td>: {{ $siswa->pendidikan_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Email</td>
                                            <td>: {{ $siswa->email_ayah ?? '-' }}</td>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="mb-4"></div>
                                <p style="font-size: 12px"><b>Data Ibu</b></p>
                                <hr>
                                <table class="table table-sm m-0" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <td scope="row" style="width: 30%">NIK</td>
                                            <td>: {{ $siswa->nik_ibu ?? '-' }} </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Nama Ibu</td>
                                            <td>: {{ $siswa->nama_ibu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Pekerjaan</td>
                                            <td>: {{ $siswa->pekerjaan_ibu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">No Telpon</td>
                                            <td>: {{ $siswa->telpon_ibu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Pendidikan</td>
                                            <td>: {{ $siswa->pendidikan_ibu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Email</td>
                                            <td>: {{ $siswa->email_ibu ?? '-' }}</td>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="mb-4"></div>
                                <p style="font-size: 12px"><b>Data Wali</b></p>
                                <hr>
                                <table class="table table-sm m-0" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <td scope="row" style="width: 30%">NIK</td>
                                            <td>: {{ $siswa->nik_wali ?? '-' }} </td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Nama Wali</td>
                                            <td>: {{ $siswa->nama_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Pekerjaan</td>
                                            <td>: {{ $siswa->pekerjaan_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">No Telpon</td>
                                            <td>: {{ $siswa->telpon_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Pendidikan</td>
                                            <td>: {{ $siswa->pendidikan_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Email</td>
                                            <td>: {{ $siswa->email_wali ?? '-' }}</td>
                                        </tr>
                                    </thead>
                                </table>
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

@include('partials/right-sidebar')

@include('partials/vendor-scripts')

<script src={{ asset('assets/js/app.js') }}></script>
</body>

</html>
