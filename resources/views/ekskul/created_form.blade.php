@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;

    if ($get_ekskul != null) {
        $title = 'Ubah Data';
    } else {
        $title = 'Tambah Data';
    }
    

@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => $title." Kompetensi Dasar"])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" =>  $title." Kompetensi Dasar"])

                        {{-- isi conten --}}

                        <form method="POST" action="{{route('ekskul.simpan.data.admin')}}">
                        @csrf
                            <!-- Right Sidebar Data Siswa -->
                            <div>
                                <div class="card">
                                    <div class="card-body">

                                        <div style="margin-left: 20px;">

                                            {{-- id --}}
                                            @if ($get_ekskul != null)
                                                <input type="hidden" name="id" value="{{$get_ekskul->kode_ekskul}}">
                                            @endif
                                            
                                            {{-- tahun ajaran --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kode *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kode_ekskul"
                                                    value="{{ $get_ekskul != null ? $get_ekskul->kode_ekskul : old('kode_ekskul') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Kode Ekskul" 
                                                    id="kode_ekskul"  
    
                                                    @if ($get_ekskul != null)
                                                        readonly
                                                    @endif
    
                                                    required>
                                                    @error('kode_ekskul')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- nama  --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Ekskul *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                        type="text" 
                                                        name="nama_ekskul" 
                                                        class="form-control" 
                                                        value="{{ $get_ekskul != null ? $get_ekskul->nama_ekskul : old('nama_ekskul') }}" placeholder="Ekskul"
                                                        required
                                                    >
                                                </div>
                                            </div>

                                            {{-- keterangan  --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea placeholder="Keterangan" name="desc_ekskul" class="form-control" rows="3">{{ $get_ekskul != null ? $get_ekskul->desc_ekskul : old('desc_ekskul') }}</textarea>
                                                </div>
                                            </div>


                                        </div>
                                </div>
                            </div>

                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end">
                                            @if ($get_ekskul == null)
                                                <button type="submit" name="action" value="tambah" class="btn btn-success waves-effect waves-light">
                                                    <i class="ri-check-line align-middle me-2"></i> Simpan
                                                </button>
                                                <button type="reset" class="btn btn-danger waves-effect waves-light">
                                                    <i class="ri-close-line align-middle me-2"></i> Batal
                                                </button>
                                            @else
                                                <button type="submit" name="action" value="ubah" class="btn btn-success waves-effect waves-light">
                                                    <i class="ri-check-line align-middle me-2"></i> Ubah
                                                </button>
                                                <a href={{URL::previous()}} class="btn btn-danger waves-effect waves-light">
                                                    <i class="ri-close-line align-middle me-2"></i> Batal
                                                </a>
                                            @endif
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
