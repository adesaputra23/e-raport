@php
    use App\User;
    use App\TahunAjaran;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Absensi'])
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
                @include('partials/page-title', ['pagetitle' => 'Dashboard', 'title' => 'Absensi'])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">

                    {{-- button add siswa --}}
                    <div>
                        <button id="btn-tambah" onclick="show_data(0, 'tambah', null)"
                            class="btn btn-sm btn-primary waves-effect waves-light">Tambah
                            Siswa</button>
                    </div>
                    <hr>

                    {{-- filter absensi --}}
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="mb-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal_awal"
                                        name="tanggal_awal" value="{{ Request::get('tanggal_awal') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal_akhir"
                                        name="tanggal_akhir" value="{{ Request::get('tanggal_akhir') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Status Absensi</label>
                                    <select class="form-control form-control-sm" name="status_absensi"
                                        id="status_absesi">
                                        <option value="" selected>All Data</option>
                                        <option value="Alpa"
                                            {{ Request::get('status_absensi') == 'Alpa' ? 'selected' : '' }}>Alpa
                                        </option>
                                        <option value="Ijin"
                                            {{ Request::get('status_absensi') == 'Ijin' ? 'selected' : '' }}>Ijin
                                        </option>
                                        <option value="Sakit"
                                            {{ Request::get('status_absensi') == 'Sakit' ? 'selected' : '' }}>Sakit
                                        </option>
                                        <option value="Tanpa Keterangan"
                                            {{ Request::get('status_absensi') == 'Tanpa Keterangan' ? 'selected' : '' }}>
                                            Tanpa Keterangan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <button type="submit" style="margin-bottom: -20px;"
                                        class="btn btn-sm btn-success">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>

                    {{-- tabel content --}}
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>NISN/NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Status Absensi</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_absensi as $item => $absensi)
                                    <tr>
                                        <td>{{ $absensi->nisn }}</td>
                                        <td>{{ $absensi->nama_siswa }}</td>
                                        <td class="text-center">
                                            @php
                                                if ($absensi->status_absensi === 'Alpa' || $absensi->status_absensi === 'Tanpa Keterangan') {
                                                    $color = 'danger';
                                                } elseif ($absensi->status_absensi === 'Ijin') {
                                                    $color = 'info';
                                                } elseif ($absensi->status_absensi === 'Sakit') {
                                                    $color = 'warning';
                                                } else {
                                                    $color = '';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                {{ $absensi->status_absensi }}
                                            </span>
                                        </td>
                                        <td>{{ $absensi->keterangan_absensi }}</td>
                                        <td>{{ $absensi->tanggal_absensi }}</td>
                                        <td>{{ Carbon\Carbon::parse($absensi->jam_absensi)->format('H:i:s') }} WIB</td>
                                        <td>
                                            <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                <button onclick="show_data(1, 'ubah', {{ $absensi }})"
                                                    class="btn btn-warning btn-sm">Ubah</button>
                                                <button id="id-btn-hapus" data-id_absensi="{{ $absensi->id_absensi }}"
                                                    type="button" class="btn btn-danger btn-sm">
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
<div class="modal fade" id="add-data" aria-hidden="true" aria-labelledby="..." tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title_absensi">Tambah Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('absensi.simpan.data') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- tipe --}}
                    <input type="hidden" name="type" id="type" value="">

                    {{-- id --}}
                    <input type="hidden" name="id" id="id" value="">

                    {{-- nisn --}}
                    <div class="mb-3">
                        <label for="" class="form-label">Pilih Siswa</label>
                        <select name="nisn" id="nisn" class="form-control form-control-sm" required>
                            <option value="" selected disabled>Pilih Siswa</option>
                            @foreach ($list_siswa as $key => $siswa)
                                <option value="{{ $siswa->nisn }}">{{ $siswa->nisn }} - {{ $siswa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- tanggal --}}
                    <div class="mb-3">
                        <label for="" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_absen" id="tanggal_absen"
                            class="form-control form-control-sm" required />
                    </div>

                    {{-- jam --}}
                    <div class="mb-3">
                        <label for="" class="form-label">Jam</label>
                        <input type="time" name="jam_absen" id="jam_absen" class="form-control form-control-sm"
                            required />
                    </div>

                    {{-- status --}}
                    <div class="mb-3">
                        <label for="" class="form-label">Status Absensi</label>
                        <select class="form-control form-control-sm" name="status_absensi" id="status_absensi"
                            required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="Alpa">Alpa</option>
                            <option value="Ijin">Ijin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Tanpa Keterangan">Tanpa Keterangan</option>
                        </select>
                    </div>

                    {{-- keterangan --}}
                    <div class="mb-3">
                        <label for="" class="form-label">Keterangan Absensi</label>
                        <textarea type="time" name="ket_absen" id="ket_absen" class="form-control form-control-sm" rows="3"
                            placeholder="Keterangan.."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal hapus data --}}
<div class="modal fade" id="data-deleted" aria-hidden="true" aria-labelledby="..." tabindex="-1">
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
            </div>
        </div>
    </div>
</div>


{{-- end modal --}}

@include('partials/right-sidebar')
@include('partials/vendor-scripts')
<script src={{ asset('assets/js/app.js') }}></script>
</body>

{{-- js  --}}
<script>
    // function show data
    function show_data(id, action, data = null) {
        $('#add-data').modal('show');
        if (action == 'tambah') {
            $('#type').val('tambah');
            $('#id').attr('disabled', true);
            $('#nisn').attr('readonly', false);
            $('#nisn').val("");
            $('#tanggal_absen').val("");
            $('#jam_absen').val("");
            $('#status_absensi').val("");
            $('#ket_absen').val("");
            // modal title
            $('#modal_title_absensi').text('Tambah Siswa');
        } else {
            var jam = data.jam_absensi.substring(0, 5);
            $('#type').val('ubah');
            $('#id').attr('disabled', false);
            $('#id').val(data.id_absensi);
            $('#nisn').val(data.nisn);
            $('#nisn').attr('readonly', true);
            $('#tanggal_absen').val(data.tanggal_absensi);
            $('#jam_absen').val(jam);
            $('#status_absensi').val(data.status_absensi);
            $('#ket_absen').val(data.keterangan_absensi);
            // modal title
            $('#modal_title_absensi').text('Ubah Siswa');
        }
    }

    $(document).on('click', '#id-btn-hapus', function() {
        var id = $(this).data('id_absensi');
        var url = "{{ URL(Session::get('prefix') . '/absensi/hapus') }}" + "/" + id;
        $("#btn-hapus").attr('href', url);
        $('#data-deleted').modal('show');
    })
</script>

</html>
