@php
    use App\User;
    use App\RoleUser;
    use App\Http\Controllers\Controller;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Siswa'])
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
                @include('partials/page-title', ['pagetitle' => 'Dashboard', 'title' => 'Data Siswa'])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    @if (Controller::isAdminPage() || RoleUser::CheckRole()->user_role === RoleUser::Operator)
                        <div>
                            <a href="{{ URL(Session::get('prefix') . '/siswa/form-tambah-data', ['nisn' => 0]) }}"
                                class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                        </div>
                        <hr>
                    @endif
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>NISN/NIS</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Agama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($list_siswa as $keys => $siswa)
                                    <tr>
                                        <td>{{ $siswa->nisn . '/' . $siswa->nis }}</td>
                                        <td>{{ $siswa->nama }}</td>
                                        <td>{{ User::MAP_JENIS_KELAMIN[$siswa->jenis_kelamin] }}</td>
                                        <td>{{ User::MAP_AGAMA[$siswa->agama] ?? '-' }}</td>
                                        <td>{{ $siswa->tanggal_lahir ?? '-' }}</td>
                                        <td>{{ $siswa->alamat ?? '-' }}</td>
                                        <td style="width: 10%">
                                            <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                @if (Controller::isAdminPage() || RoleUser::CheckRole()->user_role === RoleUser::Operator)
                                                    <a href="{{ URL(Session::get('prefix') . '/siswa/form-tambah-data', ['nisn' => $siswa->nisn]) }}"
                                                        class="btn btn-warning btn-sm">Ubah</a>
                                                    <button data-bs-toggle="modal" id="id-btn-hapus"
                                                        data-nisn="{{ $siswa->nisn }}"
                                                        data-siswa-kelas="{{ $siswa->SisiwaKelas }}"
                                                        data-bs-target="#firstmodal" type="button"
                                                        class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                @endif
                                                <a href="{{ URL(Session::get('prefix') . '/siswa/detail-data', ['nisn' => $siswa->nisn]) }}"
                                                    class="btn btn-primary btn-sm">Detail</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
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
<!-- First modal dialog -->
<div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-conten"></div>
            </div>
            <div class="modal-footer">
                <!-- Toogle to second dialog -->
                <button class="btn btn-danger batal" data-bs-target="#secondmodal" data-bs-toggle="modal"
                    data-bs-dismiss="modal">Batal</button>
                <a href="" id="btn-hapus" class="btn btn-success">Hapus</a>
                {{-- {{ URL(Session::get('prefix').'/pegawai-guru/hapus-data', ['nik'=>$pegawai->nik]) }} --}}
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}

@include('partials/right-sidebar')

@include('partials/vendor-scripts')

<script src={{ asset('assets/js/app.js') }}></script>
</body>
<script>
    $(document).on('click', '#id-btn-hapus', function() {
        let siswaKelas = $(this).data('siswa-kelas');
        let nisn = $(this).data('nisn');
        let url = "{{ URL(Session::get('prefix') . '/siswa/hapus-data/') }}" + "/" + nisn;
        $("#btn-hapus").attr('href', url);
        if (siswaKelas) {
            $('.modal .modal-title').text('Warnig!');
            $('.modal .text-conten').html(
                `<div class="d-flex justify-content-center" style="font-size:90px;"><i class="dripicons-warning"></i></div>` +
                `<p class="text-center" style="margin-top: -20px;">Siswa dengan Nisn <b>${siswaKelas.nisn}</b> tidak bisa di hapus karena terkait dengan data lain.</p>` +
                `<p class="text-center" style="margin-top: -13px;">Harap hapus data di Menu Maping Siswa terlebih dahulu!</p>`
            );
            $('.modal #btn-hapus').css('display', 'none');
            $('.modal .batal').text('Keluar');
        } else {
            $('.modal .modal-title').text('Hapus Data');
            $('.modal .text-conten').html(
                `<p class="text-center">Anda yakin ingin menghapus data ini?</p>`
            );
            $('.modal #btn-hapus').css('display', 'block');
            $('.modal .batal').text('Batal');
        }
    });
</script>

</html>
