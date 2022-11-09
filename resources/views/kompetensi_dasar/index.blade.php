@php
    use App\User;
    use App\Semester;
    use App\TahunAjaran;
@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => $title])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => $title])
                        @include("partials/alert_mesage")
                        {{-- isi conten --}}
                        <div class="card card-body">
                            <div>
                                <a href="{{URL(Session::get('prefix').'/kompetensi-dasar/form-tambah-data', ['id' => 0])}}" class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                            </div>
                            <hr>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Pengetahuan</span> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Keterampilan</span> 
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <h4 class="card-title">Kompetensi Dasar Pengetahuan</h4>
                                    <p class="card-title-desc">Data Kompetensi Dasar Pengetahuan</p>
                                    <div class="table-responsive">
                                        <table 
                                            id="pengetahuan" 
                                            class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline" 
                                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;"
                                        >
                                            <thead>
                                            <tr>
                                                <th>No KD</th>
                                                <th>Kompetensi Dasar</th>
                                                <th>Kode/Mata Pelajaran</th>
                                                {{-- <th>Type</th> --}}
                                                <th>Kelas</th>
                                                <th>Semester</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
            
                                            <tbody>
                                                @foreach ($list_data as $keys=>$data)
                                                    @if ($data->type == 'Pengetahuan' && $data->smester->id == Semester::GetAktifSemester()->id)
                                                        <tr>
                                                            <td style="width: 6%">{{$data->no_kd}}</td>
                                                            <td style="width: 40%">{{$data->nama_kd}}</td>
                                                            <td>{{$data->kode_mt.' - '.$data->mt->nama_mt}}</td>
                                                            {{-- <td>{{$data->type}}</td> --}}
                                                            <td>{{$data->mt->kelas->kode_kelas.' - '.$data->mt->kelas->ket_kelas}}</td>
                                                            <td>{{$data->smester->nama_smester}} / {{$data->smester->nama_smester == 'Ganjil' ? '1 (Satu)' : '2 (Dua)'}}</td>
                                                            <td style="width: 10%">
                                                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                                    <a href="{{ URL(Session::get('prefix').'/kompetensi-dasar/form-tambah-data', ['id' => $data->kode_kd]) }}" class="btn btn-warning btn-sm">Ubah</a>
                                                                    <button 
                                                                        data-bs-toggle="modal" 
                                                                        id="id-btn-hapus" 
                                                                        data-id="{{$data->kode_kd}}" 
                                                                        data-bs-target="#firstmodal" 
                                                                        type="button" 
                                                                        class="btn btn-danger btn-sm">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <h4 class="card-title">Kompetensi Dasar Keterampilan</h4>
                                    <p class="card-title-desc">Data Kompetensi Dasar Keterampilan</p>
                                    <div class="table-responsive">
                                        <table 
                                            id="keterampilan" 
                                            class="table table-striped table-bordered dt-responsive dataTable no-footer dtr-inline" 
                                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;"
                                        >
                                            <thead>
                                            <tr>
                                                <th>No KD</th>
                                                <th>Kompetensi Dasar</th>
                                                <th>Kode/Mata Pelajaran</th>
                                                {{-- <th>Type</th> --}}
                                                <th>Kelas</th>
                                                <th>Semester</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
            
                                            <tbody>
                                                @foreach ($list_data as $keys=>$data)
                                                    @if ($data->type == 'Keterampilan' && $data->smester->id == Semester::GetAktifSemester()->id)
                                                        <tr>
                                                            <td style="width: 6%">{{$data->no_kd}}</td>
                                                            <td style="width: 40%">{{$data->nama_kd}}</td>
                                                            <td>{{$data->kode_mt.' - '.$data->mt->nama_mt}}</td>
                                                            {{-- <td>{{$data->type}}</td> --}}
                                                            <td>{{$data->mt->kelas->kode_kelas.' - '.$data->mt->kelas->ket_kelas}}</td>
                                                            <td>{{$data->smester->nama_smester}} / {{$data->smester->nama_smester == 'Ganjil' ? '1 (Satu)' : '2 (Dua)'}}</td>
                                                            <td style="width: 10%">
                                                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                                    <a href="{{ URL(Session::get('prefix').'/kompetensi-dasar/form-tambah-data', ['id' => $data->kode_kd]) }}" class="btn btn-warning btn-sm">Ubah</a>
                                                                    <button 
                                                                        data-bs-toggle="modal" 
                                                                        id="id-btn-hapus" 
                                                                        data-id="{{$data->kode_kd}}" 
                                                                        data-bs-target="#firstmodal" 
                                                                        type="button" 
                                                                        class="btn btn-danger btn-sm">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
        
                                        </table>
                                    </div>
                                </div>
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
                            <p class="text-center">Anda yakin ingin menghapus data ini?</p>
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
        $('#pengetahuan').DataTable();
        $('#keterampilan').DataTable();

        $(document).on('click', '#id-btn-hapus', function(){
            let id = $(this).data('id');
            let url = "{{ URL(Session::get('prefix').'/kompetensi-dasar/hapus-data/') }}"+"/"+id;
            $("#btn-hapus").attr('href', url);
            $("#btn-hapus").show();
        });
    </script>
</html>
