@php
use App\User;
use App\TahunAjaran;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Kelas'])
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
                @include('partials/page-title', ['pagetitle' => 'Dashboard', 'title' => 'Data Kelas'])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    {{-- <div>
                                <a href="{{URL(Session::get('prefix').'/kelas/form-tambah-data', ['id' => 0])}}" class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                            </div> --}}
                    <hr>
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kode Kelas</th>
                                    <th>Kelas</th>
                                    <th>Keterangan Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th>Tanggal Buat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($list_kelas as $keys => $kelas)
                                    @php
                                        // button text ubah text wali kelas
                                        $text_btn = !$kelas->guru ? 'Set Wali Kelas' : 'Ubah wali kelas';
                                    @endphp

                                    <tr>
                                        <td>{{ $kelas->kode_kelas }}</td>
                                        <td class="text-center">{{ $kelas->kelas }}</td>
                                        <td class="text-center">{{ $kelas->ket_kelas }}</td>
                                        <td>
                                            @if ($kelas->guru)
                                                {{ '(' . $kelas->guru->nik . ') - ' . $kelas->guru->nama }}
                                            @else
                                                <p class="text-danger text-center">Belum ada wali kelas.!</p>
                                            @endif
                                        </td>
                                        <td>{{ $kelas->created_at }}</td>
                                        <td style="width: 10%">
                                            <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                <a href="{{ URL(Session::get('prefix') . '/kelas/form-tambah-data', ['id' => $kelas->kode_kelas]) }}"
                                                    class="btn btn-warning btn-sm">Ubah</a>
                                                <button data-bs-toggle="modal" data-bs-target="#set-wali-kelas"
                                                    type="button" data-id={{ $kelas->kode_kelas }}
                                                    data-nik={{ !$kelas->nik ? 0 : $kelas->nik }} id="btn-wali-kelas"
                                                    class="btn btn-info btn-sm">
                                                    {{ $text_btn }}
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

{{-- modal --}}
<!-- First modal dialog -->
<div class="modal fade" id="set-wali-kelas" aria-hidden="true" aria-labelledby="..." tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Wali Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('kelas.set.wali.kelas.admin') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="kode_kelas" id="kode_kelas">

                    <input type="hidden" name="old_nik" id="old_nik" value="">

                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <select name="nik" id="nik" class="form-select"
                                aria-label="Default select example" required>
                                <option selected="" disabled>Pilih Guru</option>
                                @foreach ($list_guru as $key => $guru)
                                    <option value="{{ $guru->nik }}">{{ '(' . $guru->nik . ') - ' . $guru->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Toogle to second dialog -->
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    {{-- {{ URL(Session::get('prefix').'/pegawai-guru/hapus-data', ['nik'=>$pegawai->nik]) }} --}}
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
    $(document).on('click', '#id-btn-hapus', function() {
        let id = $(this).data('id');
        let ck_siswa_kelas = $(this).data('ck_siswa_kelas');
        if (ck_siswa_kelas.length > 0) {
            let url = "";
            $("#btn-hapus").attr('href', url);
            $("#notif").text('Data terintegrasi dengan data yang lain.');
            $("#btn-hapus").hide();
        } else {
            let url = "{{ URL(Session::get('prefix') . '/kelas/hapus-data/') }}" + "/" + id;
            $("#btn-hapus").attr('href', url);
            $("#notif").text('Anda yakin ingin menghapus data ini?');
            $("#btn-hapus").show();
        }
    });

    $(document).on('click', '#btn-wali-kelas', function() {
        let kelas = $(this).data('id');
        let nik = $(this).data('nik');
        $('#kode_kelas').val(kelas);
        $('#old_nik').val(nik);
    });
</script>

</html>
