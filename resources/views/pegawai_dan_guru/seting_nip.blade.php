@php
    use App\RoleUser;
    use App\PegawaiDanGuru;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Seting NIP Kepala Sekolah'])
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
                    'title' => 'Seting NIP Kepala Sekolah',
                ])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    <div>
                        <table
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th>Status NIP</th>
                                    <th>NIP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kepala Sekolah</td>
                                    <td>{{ $list_data->nik }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" disabled>Seting Nip</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Guru</td>
                                    <td>{{ empty($list_data->nip_2) ? 'NIP belum diseting!' : $list_data->nip_2 }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#firstmodal" data-id="{{ $list_data->id }}"
                                            data-nip="{{ $list_data->nip_2 }}" type="button" id="btn-ubah">Seting
                                            Nip</button>
                                    </td>
                                </tr>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah NIP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('guru.pegawai.save.nip') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- id --}}
                    <input type="hidden" name="id" id="id">

                    {{-- nip 2 --}}
                    <div class="row mb-3">
                        <label for="example-date-input" class="col-sm-2 col-form-label">NIP*</label>
                        <div class="col-sm-10">
                            <input name="nip" class="form-control" type="number" placeholder="NIP" id="nip"
                                required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <!-- Toogle to second dialog -->
                    <button class="btn btn-danger" data-bs-target="#secondmodal" data-bs-toggle="modal"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </form>

        </div>
    </div>
</div>
{{-- end modal --}}

@include('partials/right-sidebar')

@include('partials/vendor-scripts')

<script src={{ asset('assets/js/app.js') }}></script>
<script>
    $(document).ready(function() {
        $('#btn-ubah').on('click', function() {
            var nip = $(this).data('nip');
            var id = $(this).data('id');
            $('#nip').val(nip);
            $('#id').val(id);
        })
    })
</script>
</body>

</html>
