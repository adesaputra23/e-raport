@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => "Tambah Data Kelas"])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => "Tambah Data Kelas"])

                        {{-- isi conten --}}

                        <form method="POST" action="{{route('kelas.simpan.data.admin')}}">
                        @csrf
                            <!-- Right Sidebar Data Siswa -->
                            <div>
                                <div class="card">
                                    <div class="card-body">

                                        <div style="margin-left: 20px;">

                                            {{-- id --}}
                                            @if ($data_kelas != null)
                                                <input type="hidden" name="id" value="{{$data_kelas->kode_kelas}}">
                                            @endif
                                            
                                            {{-- kode kelas --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kode Kelas *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kode_kelas"
                                                    value="{{ $data_kelas != null ? $data_kelas->kode_kelas : old('kode_kelas') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Kode Kelas" 
                                                    id="kode_kelas"      
                                                    required>
                                                    @error('kode_kelas')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- kelas --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kelas *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kelas"
                                                    value="{{ $data_kelas != null ? $data_kelas->kelas : old('kelas') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Kelas" 
                                                    id="kelas"  
    
                                                    required>
                                                    @error('kelas')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- ket kelas  --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea placeholder="Keterangan" name="ket_kelas" class="form-control" rows="3">{{ $data_kelas != null ? $data_kelas->ket_kelas : old('ket_kelas') }}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                </div>
                            </div>

                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end">
                                            @if ($data_kelas == null)
                                                <button type="submit" name="action" value="tambah" class="btn btn-success waves-effect waves-light">
                                                    <i class="ri-check-line align-middle me-2"></i> Simpan
                                                </button>
                                            @else
                                                <button type="submit" name="action" value="ubah" class="btn btn-success waves-effect waves-light">
                                                    <i class="ri-check-line align-middle me-2"></i> Ubah
                                                </button>
                                            @endif
                                            <button type="reset" class="btn btn-danger waves-effect waves-light">
                                                <i class="ri-close-line align-middle me-2"></i> Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </form>
                        {{-- end isi conten --}}

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                @include("partials/footer")
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        @include("partials/right-sidebar")

        @include("partials/vendor-scripts")

        <script src={{asset("assets/js/app.js")}}></script>
    </body>
</html>
