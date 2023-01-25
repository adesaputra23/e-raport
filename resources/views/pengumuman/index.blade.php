@php
    use App\User;
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Pengumuman'])
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
                @include('partials/page-title', ['pagetitle' => 'Dashboard', 'title' => 'Data Pengumuman'])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    @if (RoleUser::CheckRole()->user_role === RoleUser::Admin || RoleUser::CheckRole()->user_role === RoleUser::Operator)
                        <div>
                            <a href="{{ URL(Session::get('prefix') . '/pengumuman/form-data', ['id' => 0]) }}"
                                class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                        </div>
                    @endif
                    <hr>
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $item => $data)
                                    <tr>
                                        <td>{{ $data->judul }}</td>
                                        <td>{!! $data->isi == null ? '-' : substr($data->isi, 0, 50) . '...' !!}</td>
                                        <td>{{ $data->tanggal }}</td>
                                        <td>
                                            <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                @if (RoleUser::CheckRole()->user_role === RoleUser::Admin || RoleUser::CheckRole()->user_role === RoleUser::Operator)
                                                    <a href="{{ URL(Session::get('prefix') . '/pengumuman/form-data', ['id' => $data->id_pengumuman]) }}"
                                                        class="btn btn-warning btn-sm">Ubah</a>
                                                    <button data-bs-toggle="modal" id="id-btn-hapus"
                                                        data-id="{{ $data->id_pengumuman }}"
                                                        data-bs-target="#firstmodal" type="button"
                                                        class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                @endif
                                                <a href="{{ URL(Session::get('prefix') . '/pengumuman/show', ['id' => $data->id_pengumuman]) }}"
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
                <p class="text-center">Anda yakin ingin menghapus data ini?</p>
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
        let url = "{{ URL(Session::get('prefix') . '/pengumuman/delete/') }}" + "/" + id;
        $("#btn-hapus").attr('href', url);
    });
</script>

</html>
