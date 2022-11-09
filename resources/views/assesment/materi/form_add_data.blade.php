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

                        <form method="POST" action="{{route('assesment.materi.save.admin')}}">
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
                                            
                                            {{-- kode kelas --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kode Materi *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kode_materi"
                                                    value="{{ $data_materi != null ? $data_materi->kode_materi : old('kode_materi') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Kode Materi" 
                                                    id="kode_materi"      
                                                    required>
                                                    @error('kode_materi')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- mapteri pembelajran --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Materi Pembelajaran *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="materi"
                                                    value="{{ $data_materi != null ? $data_materi->materi_pembelajaran : old('materi') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Materi Pembelajran" 
                                                    id="materi"  
    
                                                    required>
                                                    @error('kelas')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Mata pelajaran --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Mata Pelajaran *</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('kode_mt') }}"
                                                    name="kode_mt"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Mata Pelajaran</option>
                                                        @foreach ($list_mt as $keys=>$mt)
                                                            <option value="{{$mt->kode_mt}}" {{$data_materi != null && $mt->kode_mt === $data_materi->kode_mt ? 'selected' : ''}}>{{'('.$mt->kode_mt.') - '.$mt->nama_mt.' - ('.$mt->kelas->ket_kelas.')'}}</option>                                                            
                                                        @endforeach
                                                    </select>
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
