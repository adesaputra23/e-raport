@php
use App\User;
use App\TahunAjaran;
use App\Kurikulum;
use App\RoleUser;
use App\Http\Controllers\Controller;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => $title])
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
                @include('partials/page-title', ['pagetitle' => 'Dashboard', 'title' => $title])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    @if (Controller::isAdminPage())
                        <div>
                            <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran/form-tambah-data', ['id' => 0]) }}"
                                class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                        </div>
                        <hr>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Kurikulum 2013</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Kurikulum Protipe/2022</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <h4 class="card-title">Kurikulum 2013</h4>
                                <p class="card-title-desc">Data Mata Pelajaran Kurikulum 2013</p>
                                <div class="table-responsive">
                                    <table id="tabel-k13"
                                        class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">Kode Mata Pelajaran</th>
                                                <th>Mata Pelajaran</th>
                                                <th>NIK/Guru</th>
                                                <th>Kode/Kelas</th>
                                                {{-- <th>Kurikulum</th> --}}
                                                @if (Controller::isAdminPage())
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($list_data as $keys => $data)
                                                {{-- {{$data->kode_kurikulum}} --}}
                                                @if ($data->kode_kurikulum === Kurikulum::K13)
                                                    <tr>
                                                        <td>{{ $data->kode_mt }}</td>
                                                        <td>{{ $data->nama_mt }}</td>
                                                        <td>{{ $data->nik . ' - ' . $data->guru->nama }}</td>
                                                        <td>{{ $data->kode_kelas . ' - ' . $data->kelas->ket_kelas }}</td>
                                                        {{-- <td>{{$data->kurikulum->nama_kurikulum}}</td> --}}
                                                        @if (Controller::isAdminPage())
                                                            <td style="width: 10%">
                                                                <div class="btn-group float-end" role="group"
                                                                    aria-label="Basic example">
                                                                    <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran/form-tambah-data', ['id' => $data->id]) }}"
                                                                        class="btn btn-warning btn-sm">Ubah</a>
                                                                    <button data-bs-toggle="modal" id="id-btn-hapus"
                                                                        data-id="{{ $data->id }}"
                                                                        data-bs-target="#firstmodal" type="button"
                                                                        class="btn btn-danger btn-sm">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="profile1" role="tabpanel">
                                <h4 class="card-title">Kurikulum Prototipe/2020</h4>
                                <p class="card-title-desc">Data Mata Pelajaran Prototipe/2020</p>
                                <div class="table-responsive">
                                    <table id="tabel-k20"
                                        class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Mata Pelajaran</th>
                                                <th>NIK/Guru</th>
                                                <th>Kode/Kelas</th>
                                                {{-- <th>Kurikulum</th> --}}
                                                @if (Controller::isAdminPage())
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($list_data as $keys => $data)
                                                @if ($data->kode_kurikulum === Kurikulum::Prototype)
                                                    <tr>
                                                        <td style="width: 15%;">{{ $data->kode_mt }}</td>
                                                        <td>{{ $data->nama_mt }}</td>
                                                        <td>{{ $data->nik . ' - ' . $data->guru->nama }}</td>
                                                        <td>{{ $data->kode_kelas . ' - ' . $data->kelas->ket_kelas }}</td>
                                                        {{-- <td>{{$data->kurikulum->nama_kurikulum}}</td> --}}
                                                        @if (Controller::isAdminPage())
                                                            <td style="width: 10%">
                                                                <div class="btn-group float-end" role="group"
                                                                    aria-label="Basic example">
                                                                    <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran/form-tambah-data', ['id' => $data->id]) }}"
                                                                        class="btn btn-warning btn-sm">Ubah</a>
                                                                    <button data-bs-toggle="modal" id="id-btn-hapus"
                                                                        data-id="{{ $data->id }}"
                                                                        data-bs-target="#firstmodal" type="button"
                                                                        class="btn btn-danger btn-sm">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas)
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            {{-- @if (Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::K13) --}}
                            <div
                                class="tab-pane {{ Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::K13 ? 'active' : '' }}">
                                <h4 class="card-title">Kurikulum 2013</h4>
                                <p class="card-title-desc">Data Mata Pelajaran Kurikulum 2013</p>
                                <div class="table-responsive">
                                    <table id="tabel-k13"
                                        class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">Kode Mata Pelajaran</th>
                                                <th>Mata Pelajaran</th>
                                                <th>NIK/Guru</th>
                                                <th>Kode/Kelas</th>
                                                {{-- <th>Kurikulum</th> --}}
                                                @if (Controller::isAdminPage())
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($list_data as $keys => $data)
                                                {{-- {{$data->kode_kurikulum}} --}}
                                                @if ($data->kode_kurikulum === Kurikulum::K13)
                                                    <tr>
                                                        <td>{{ $data->kode_mt }}</td>
                                                        <td>{{ $data->nama_mt }}</td>
                                                        <td>{{ $data->nik . ' - ' . $data->guru->nama }}</td>
                                                        <td>{{ $data->kode_kelas . ' - ' . $data->kelas->ket_kelas }}</td>
                                                        {{-- <td>{{$data->kurikulum->nama_kurikulum}}</td> --}}
                                                        @if (Controller::isAdminPage())
                                                            <td style="width: 10%">
                                                                <div class="btn-group float-end" role="group"
                                                                    aria-label="Basic example">
                                                                    <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran/form-tambah-data', ['id' => $data->id]) }}"
                                                                        class="btn btn-warning btn-sm">Ubah</a>
                                                                    <button data-bs-toggle="modal" id="id-btn-hapus"
                                                                        data-id="{{ $data->id }}"
                                                                        data-bs-target="#firstmodal" type="button"
                                                                        class="btn btn-danger btn-sm">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            {{-- @elseif(Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::Prototype) --}}
                            <div
                                class="tab-pane {{ Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::Prototype ? 'active' : '' }}">
                                <h4 class="card-title">Kurikulum Prototipe/2020</h4>
                                <p class="card-title-desc">Data Mata Pelajaran Prototipe/2020</p>
                                <div class="table-responsive">
                                    <table id="tabel-k20"
                                        class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline"
                                        style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Mata Pelajaran</th>
                                                <th>NIK/Guru</th>
                                                <th>Kode/Kelas</th>
                                                {{-- <th>Kurikulum</th> --}}
                                                @if (Controller::isAdminPage())
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($list_data as $keys => $data)
                                                @if ($data->kode_kurikulum === Kurikulum::Prototype)
                                                    <tr>
                                                        <td style="width: 15%;">{{ $data->kode_mt }}</td>
                                                        <td>{{ $data->nama_mt }}</td>
                                                        <td>{{ $data->nik . ' - ' . $data->guru->nama }}</td>
                                                        <td>{{ $data->kode_kelas . ' - ' . $data->kelas->ket_kelas }}</td>
                                                        {{-- <td>{{$data->kurikulum->nama_kurikulum}}</td> --}}
                                                        @if (Controller::isAdminPage())
                                                            <td style="width: 10%">
                                                                <div class="btn-group float-end" role="group"
                                                                    aria-label="Basic example">
                                                                    <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran/form-tambah-data', ['id' => $data->id]) }}"
                                                                        class="btn btn-warning btn-sm">Ubah</a>
                                                                    <button data-bs-toggle="modal" id="id-btn-hapus"
                                                                        data-id="{{ $data->id }}"
                                                                        data-bs-target="#firstmodal" type="button"
                                                                        class="btn btn-danger btn-sm">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}

                        </div>
                    @endif

                </div>

                @if (Controller::isAdminPage())
                    {{-- KKM --}}
                    <div class="card card-body">
                        <div class="card-title">
                            <h5>Nilai KKM</h5>
                        </div>
                        <div>
                            <table id="datatable"
                                class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nilai KKM</th>
                                        <th>Ketrangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($list_kkm as $keys => $kkm)
                                        <tr>
                                            <td>{{ $kkm->nilai_kkm }}</td>
                                            <td>{{ $kkm->desc_kkm }}</td>
                                            <td>
                                                <button data-bs-toggle="modal" id="id-btn-ubah-kkm"
                                                    data-getdata="{{ $kkm }}" data-bs-target="#ubah-kkm"
                                                    type="button" class="btn btn-success btn-sm">
                                                    Ubah
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                @endif


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

{{-- modal ubah kkm --}}
<!-- modal dialog -->
<div class="modal fade" id="ubah-kkm" aria-hidden="true" aria-labelledby="..." tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Nilai KKM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('mata.pelajaran.ubah.kkm.data.admin') }}">
                @csrf
                <div class="modal-body">

                    <input type="hidden" id="id" name="id" value="">

                    {{-- nilai kkm  --}}
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Nilai KKM *</label>
                        <div class="col-sm-8">
                            <input type="text" name="nilai_kkm" id="nilai-kkm" class="form-control"
                                value="" placeholder="Nilai KKM" required>
                        </div>
                    </div>

                    {{-- keterangan  --}}
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea name="desc_kkm" id="desc-kkm" class="form-control" rows="3" placeholder="Keterangan"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <!-- Toogle to second dialog -->
                    <button type="button" class="btn btn-danger" data-bs-target="#secondmodal"
                        data-bs-toggle="modal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn-ubah" class="btn btn-success">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal --}}

@include('partials/right-sidebar')

@include('partials/vendor-scripts')

<script src={{ asset('assets/js/app.js') }}></script>
</body>
<script>
    $('#tabel-k13').DataTable();
    $('#tabel-k20').DataTable();

    $(document).on('click', '#id-btn-hapus', function() {
        let id = $(this).data('id');
        let url = "{{ URL(Session::get('prefix') . '/mata-pelajaran/hapus-data/') }}" + "/" + id;
        $("#btn-hapus").attr('href', url);
        $("#btn-hapus").show();
    });

    $(document).on('click', '#id-btn-ubah-kkm', function() {
        let is_data = $(this).data('getdata');
        $('#id').val(is_data.id);
        $('#nilai-kkm').val(is_data.nilai_kkm);
        $('#desc-kkm').val(is_data.desc_kkm);
        console.log(is_data);
        // let url = "{{ URL(Session::get('prefix') . '/mata-pelajaran/hapus-data/') }}"+"/"+id;
        // $("#btn-hapus").attr('href', url);
    });
</script>

</html>
