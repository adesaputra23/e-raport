@php
    use App\User;
    use App\TahunAjaran;
    use App\Semester;
@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => "Data Tahun Ajaran"])
        @include("partials/head-css")
    </head>

    @include("partials/body")
        <!-- Begin page -->
        <div id="layout-wrapper">
            @include("partials/menu")
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => "Data Tahun Ajaran"])
                        @include("partials/alert_mesage")

                        {{-- isi conten --}}
                        <div class="card card-body">
                            <div>
                                <a href="{{URL(Session::get('prefix').'/tahun-ajaran/form-tambah-data', ['id' => 0])}}" class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                            </div>
                            <hr>
                            <div>
                                <table 
                                    id="datatable" 
                                    class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" 
                                    style="border-collapse: collapse; border-spacing: 0px; width: 100%;"
                                >
                                    <thead>
                                    <tr>
                                        <th>Tahun Ajaran</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Tanggal Buat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
    
                                    <tbody>
                                        @foreach ($list_tahun_ajaran as $keys=>$tahun_ajaran)
                                            <tr>
                                                <td>{{$tahun_ajaran->tahun_ajaran}}</td>
                                                <td>{{$tahun_ajaran->ket_tahun_ajaran}}</td>
                                                <td>
                                                    <span class="badge {{$tahun_ajaran->status_aktif === 1 ? 'bg-success' : 'bg-danger'}} ">
                                                        {{TahunAjaran::MAP_STATUS[$tahun_ajaran->status_aktif]}}</td>
                                                    </span>
                                                <td>{{$tahun_ajaran->created_at}}</td>
                                                <td style="width: 10%">
                                                    <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                        <a href="{{ URL(Session::get('prefix').'/tahun-ajaran/form-tambah-data', ['id'=>$tahun_ajaran->id_tahun_ajaran]) }}" class="btn btn-warning btn-sm">Ubah</a>
                                                        <button 
                                                            data-bs-toggle="modal" 
                                                            id="id-btn-hapus" 
                                                            data-id="{{$tahun_ajaran->id_tahun_ajaran}}" 
                                                            data-status="{{$tahun_ajaran->status_aktif}}" 
                                                            data-bs-target="#firstmodal" 
                                                            type="button" 
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

                        {{-- semester --}}
                        <div class="card card-body">
                            <div class="card-title">
                                <h5>Semester</h5>
                            </div>
                            <div>
                                <table 
                                    id="datatable" 
                                    class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" 
                                    style="border-collapse: collapse; border-spacing: 0px; width: 100%;"
                                >
                                    <thead>
                                    <tr>
                                        <th>Semster</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
    
                                    <tbody>
                                        @foreach ($list_semster as $keys => $semster)
                                            @php
                                                $color = $semster->status_semester == 1 ? 'success' : 'danger';
                                            @endphp
                                            <tr>
                                                <td>{{$semster->nama_smester}}</td>
                                                <td>
                                                    <span class="badge bg-{{$color}} ">
                                                        {{Semester::MAP_STATUS[$semster->status_semester]}}</td>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="form-check mb-3">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="radio" 
                                                            name="formRadios"
                                                            id="formRadios"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#firstmodal"
                                                            data-id={{$semster->id}} 
                                                            data-nama={{$semster->nama_smester}} 
                                                            @if ($semster->status_semester == 1)
                                                                checked
                                                            @endif
                                                        >
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
                
                @include("partials/footer")
                
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
                            <button class="btn btn-danger" data-bs-target="#secondmodal" data-bs-toggle="modal" data-bs-dismiss="modal">Batal</button>
                            <a href="" id="btn-hapus" class="btn btn-success">Hapus</a>
                            {{-- {{ URL(Session::get('prefix').'/pegawai-guru/hapus-data', ['nik'=>$pegawai->nik]) }} --}}
                        </div>
                    </div>
                </div>
            </div>
        {{-- end modal --}}

        @include("partials/right-sidebar")

        @include("partials/vendor-scripts")

        <script src={{asset("assets/js/app.js")}}></script>
    </body>
    <script>
        $(document).on('click', '#id-btn-hapus', function(){
            let id = $(this).data('id');
            let status_aktif = $(this).data('status');
            $('.modal-title').text('Hapus Data');
            if (status_aktif === 2) {
                let url = "{{ URL(Session::get('prefix').'/tahun-ajaran/hapus-data/') }}"+"/"+id;
                $("#btn-hapus").attr('href', url);
                $("#notif").text('Anda yakin ingin menghapus data ini?');
                $("#btn-hapus").show();
                $("#btn-hapus").text('Hapus');
            }else{
                let url = "#";
                $("#btn-hapus").attr('href', url);
                $("#notif").text('Data ini tidak dapat di hapus, karena status masih aktif.');
                $("#btn-hapus").hide();
            }
        });

        $(document).on('change', '#formRadios', function() {
            const id  = $(this).data('id');
            const nama = $(this).data('nama');
            const url = "{{ URL(Session::get('prefix').'/tahun-ajaran/semester/') }}"+"/"+id;
            $('.modal-title').text('Semester');
            $("#btn-hapus").attr('href', url);
            $("#notif").text('Aktifkan Semester '+nama+' ?');
            $("#btn-hapus").show();
            $("#btn-hapus").text('Simpan');
            $('#firstmodal').modal('show');
        })

    </script>
</html>
