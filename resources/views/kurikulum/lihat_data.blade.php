@php
    use App\User;
    use App\TahunAjaran;
    use App\Kurikulum;
    $title = 'Kurikulum'
@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => "Data ".$title])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => "Data ".$title])
                        @include("partials/alert_mesage")
                        {{-- isi conten --}}
                        <div class="card card-body">
                            {{-- <div>
                                <a href="{{URL(Session::get('prefix').'/kurikulum/form-tambah-data', ['kode_kurikulum' => 0])}}" class="btn btn-sm btn-primary waves-effect waves-light">Tambah Data</a>
                            </div> --}}
                            <hr>
                            <div>
                                <table 
                                    id="datatable" 
                                    class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" 
                                    style="border-collapse: collapse; border-spacing: 0px; width: 100%;"
                                >
                                    <thead>
                                    <tr>
                                        <th>Kode Kurikulum</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Tanggal Buat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                        @foreach ($list_kurikulum as $item=>$kurikulum)
                                            @php
                                                $color = $kurikulum->status_kurikulum == 1 ? 'success' : 'danger';
                                            @endphp
                                            <tr>
                                                <td>{{$kurikulum->kode_kurikulum}}</td>
                                                <td>{{$kurikulum->desc_kurikulum}}</td>
                                                <td>
                                                    <span class="badge bg-{{$color}}">
                                                        {{Kurikulum::Status_Map[$kurikulum->status_kurikulum]}}
                                                    </span>
                                                </td>
                                                <td>{{$kurikulum->created_at}}</td>
                                                <td>
                                                    <div class="btn-group float-center" role="group" aria-label="Basic example">
                                                        <a href="{{ URL(Session::get('prefix').'/kurikulum/form-tambah-data', ['kode_kurikulum'=>$kurikulum->kode_kurikulum]) }}" class="btn btn-warning btn-sm">Ubah</a>
                                                        {{-- <button 
                                                            data-bs-toggle="modal" 
                                                            id="id-btn-hapus" 
                                                            data-id="{{$kurikulum->kode_kurikulum}}"  
                                                            data-bs-target="#firstmodal" 
                                                            type="button" 
                                                            class="btn btn-danger btn-sm">
                                                            Hapus
                                                        </button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
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
            // let status_aktif = $(this).data('status');
            // if (status_aktif === 2) {
                let url = "{{ URL(Session::get('prefix').'/kurikulum/hapus-data/') }}"+"/"+id;
                $("#btn-hapus").attr('href', url);
                $("#notif").text('Anda yakin ingin menghapus data ini?');
                $("#btn-hapus").show();
            // }else{
            //     let url = "#";
            //     $("#btn-hapus").attr('href', url);
            //     $("#notif").text('Data ini tidak dapat di hapus, karena terintegrasi dengan data yang lain!.');
            //     $("#btn-hapus").hide();
            // }
        });
    </script>
</html>
