@php
    use App\User;
    use App\TahunAjaran;
    use App\Siswa;
    use App\Kelas;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Monitoring Absensi'])
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
                    'title' => 'Monitoring Absensi',
                ])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">

                    {{-- tabel content --}}
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>NISN / NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kode / Kelas</th>
                                    <th>Tanpa Keterangan</th>
                                    <th>Sakit</th>
                                    <th>Ijin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $nisn => $data)
                                    <tr>
                                        <td>{{ Siswa::GetSiswaByNisn($nisn)->nisn ?? '-' }} -
                                            {{ Siswa::GetSiswaByNisn($nisn)->nis ?? '-' }}</td>
                                        <td>{{ Siswa::GetSiswaByNisn($nisn)->nama ?? '-' }}</td>
                                        <td>{{ Kelas::getbyId($data['kelas'])->kode_kelas . ' - ' . Kelas::getbyId($data['kelas'])->ket_kelas ?? '-' }}
                                        </td>
                                        <td class="text-center">{{ $data['Tanpa Keterangan'] . ' hari' }}</td>
                                        <td class="text-center">{{ $data['Sakit'] . ' hari' }}</td>
                                        <td class="text-center">{{ $data['Ijin'] . ' hari' }}</td>
                                        <td>
                                            <button id="btn-detail"
                                                onclick="show_detail('{{ $nisn }}', '{{ $data['kelas'] }}')"
                                                class="btn btn-info btn-sm">Detail</button>
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

{{-- info detail data --}}
<div class="modal fade bs-example-modal-xl" id="data-detail" aria-hidden="true" aria-labelledby="..." tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table
                        class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                        id="my_tabels">
                        <thead>
                            <tr>
                                <th>NISN/NIS</th>
                                <th>Nama Siswa</th>
                                <th>Status Absensi</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Toogle to second dialog -->
                <button class="btn btn-danger" data-bs-target="#secondmodal" data-bs-toggle="modal"
                    data-bs-dismiss="modal">Keluar</button>
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
    function show_detail(nisn, data) {
        console.log(nisn, data);
        $('#data-detail').modal('show');
        $('#my_tabels').DataTable({
            paging: true,
            searching: true,
            "processing": true,
            "serverSide": true,
            "destroy": true,
            ajax: {
                url: "{{ url('/absensi/ajax-get-siswa') }}",
                method: "GET",
                data: {
                    siswa_nisn: nisn,
                    kode_kelas: data,
                    _token: '{{ csrf_token() }}'
                },
                dataSrc: "data",
                dataType: 'json',
            },
            columns: [{
                    data: 'nisn',
                    orderable: false
                },
                {
                    data: 'nama_siswa',
                    orderable: false
                },
                {
                    data: 'status_absensi',
                    orderable: false
                },
                {
                    data: 'keterangan_absensi',
                    orderable: false
                },
                {
                    data: 'tanggal_absensi',
                    orderable: false
                },
                {
                    data: 'jam_absensi',
                    orderable: false
                },
            ],
        });
    }
</script>

</html>
