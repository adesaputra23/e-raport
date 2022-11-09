@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;

    $title = 'Tambah';
    if ($data_materi != null) {
        $title = 'Ubah';
    }

@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => $title." Data Assesment Materi"])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => $title." Assesment Materi"])

                        {{-- isi conten --}}

                        <form method="POST" action="{{route('assesment.tujuan.pembelajaran.save.admin')}}">
                        @csrf
                            <!-- Right Sidebar Data Siswa -->
                            <div>
                                <div class="card">
                                    <div class="card-body">

                                        <div style="margin-left: 20px;">

                                            {{-- id --}}
                                            @if ($data_materi != null)
                                                <input type="hidden" name="id" value="{{$data_materi->kode_materi}}">
                                            @endif
                                            
                                            {{-- kode tujuan --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kode Tujuan *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kode_tujuan"
                                                    value="{{ $data_materi != null ? $data_materi->kode_tujuan : old('kode_tujuan') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Kode Tujuan Pembelajaran" 
                                                    id="kode_tujuan"  

                                                    @if ($data_materi != null )
                                                        readonly
                                                    @endif
                                                    
                                                    required>
                                                    @error('kode_tujuan')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- materi pembelajran --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Materi Pelajaran *</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('kode_materi') }}"
                                                    name="kode_materi"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Materi Pelajaran</option>
                                                        @foreach ($list_materi as $keys => $materi)
                                                            @if ($materi->mt != null)
                                                                <option value="{{$materi->kode_materi}}" {{$data_materi != null && $materi->kode_materi === $data_materi->kode_materi ? 'selected' : ''}}>{{'('.$materi->kode_materi.') - '.$materi->materi_pembelajaran}}</option>                                                            
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- tujuan pembelajaran --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Tujuan Pembelajaran *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="tujuan"
                                                    value="{{ $data_materi != null ? $data_materi->nama_tujuan : old('tujuan') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Tujuan Pembelajaran" 
                                                    id="tujuan"      
                                                    required>
                                                    @error('tujuan')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- semester --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Semester *</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('smester') }}"
                                                    name="smester"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Semester</option>
                                                        @foreach ($list_semester as $keys=>$data)
                                                            <option value="{{$data->id}}" {{$data_materi != null && $data->id === $data_materi->id_semester ? 'selected' : ''}}>{{$data->nama_smester}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                </div>
                            </div>

                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end">
                                            @if ($data_materi == null)
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
