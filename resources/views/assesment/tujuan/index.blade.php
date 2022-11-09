@php
    use App\User;
    use App\TahunAjaran;
    use App\Semester;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Assasment Tujuan Pembelajran'])
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
                    'title' => 'Data Assasment Tujuan Pembelajran',
                ])
                @include('partials/alert_mesage')

                {{-- semester --}}
                <div class="card card-body">

                    <div>
                        <a href="{{ URL(Session::get('prefix') . '/assesment/tujuan-pembelajaran/add-data', ['id' => 0]) }}"
                            class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kode Tujuan</th>
                                    <th>Kode/Materi</th>
                                    <th style="width: 50%">Tujuan Pelajaran</th>
                                    <th>Semester</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $keys => $data)
                                    <tr>
                                        <td>{{ $data->kode_tujuan }}</td>
                                        <td>{{ $data->kode_materi }} -
                                            {{ $data->MateriPembelajaran->materi_pembelajaran }}</td>
                                        <td>{{ $data->nama_tujuan }}</td>
                                        <th>{{ $data->Semester->nama_smester }}</th>
                                        <td style="width: 10%">
                                            <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                <a href="{{ URL(Session::get('prefix') . '/assesment/tujuan-pembelajaran/add-data', ['id' => $data->kode_tujuan]) }}"
                                                    class="btn btn-warning btn-sm">Ubah</a>
                                                <button data-bs-toggle="modal" data-bs-target="#firstmodal"
                                                    type="button" data-id={{ $data->kode_tujuan }} id="id-btn-hapus"
                                                    class="btn btn-info btn-sm">
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
        console.log(id);
        let url = "{{ URL(Session::get('prefix') . '/assesment/tujuan-pembelajaran/hapus-data/') }}" + "/" + id;
        $("#btn-hapus").attr('href', url);
        $("#btn-hapus").show();
    });
</script>

</html>
