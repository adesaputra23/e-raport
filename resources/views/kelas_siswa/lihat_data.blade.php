@php
    use App\User;
    use App\TahunAjaran;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Siswa Kelas'])
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
                    'title' => 'Data Siswa Kelas',
                ])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="{{ URL(Session::get('prefix') . '/kelas-siswa/form-tambah-data', ['id' => 0]) }}"
                                class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <table id="datatable"
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>NIS/NISN</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kode Kelas</th>
                                    <th>Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($list_kelas_siswa as $keys => $kelas_siswa)
                                    <tr>
                                        <td>{{ $kelas_siswa->Siswa->nisn }}</td>
                                        <td>{{ $kelas_siswa->Siswa->nama }}</td>
                                        <td>{{ User::MAP_JENIS_KELAMIN[$kelas_siswa->Siswa->jenis_kelamin] }}</td>
                                        <td>{{ $kelas_siswa->Kelas->kode_kelas }}</td>
                                        <td>{{ $kelas_siswa->Kelas->kelas }}</td>
                                        <td>{{ $kelas_siswa->TahunAjaran->tahun_ajaran }}</td>
                                        <td style="width: 10%">
                                            <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                <a href="{{ URL(Session::get('prefix') . '/kelas-siswa/form-tambah-data', ['id' => $kelas_siswa->id_siswa_kelas]) }}"
                                                    class="btn btn-warning btn-sm">Ubah</a>
                                                <button data-bs-toggle="modal" id="id-btn-hapus"
                                                    data-id="{{ $kelas_siswa->id_siswa_kelas }}" data-status=""
                                                    data-bs-target="#firstmodal" type="button"
                                                    class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
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
                <p class="text-center" id="notif">Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <!-- Toogle to second dialog -->
                <button class="btn btn-danger" data-bs-target="#secondmodal" data-bs-toggle="modal"
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
        let id = $(this).data('id');
        let url = "{{ URL(Session::get('prefix') . '/kelas-siswa/hapus-data/') }}" + "/" + id;
        $("#btn-hapus").attr('href', url);
        $("#notif").text('Anda yakin ingin menghapus data ini?');
        $("#btn-hapus").show();
    });
</script>

</html>
