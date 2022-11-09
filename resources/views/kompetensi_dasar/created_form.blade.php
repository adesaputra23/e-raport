@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;

    if ($get_kd != null) {
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

                        <form method="POST" action="{{route('kompetensi.dasar.simpan.data.admin')}}">
                        @csrf
                            <!-- Right Sidebar Data Siswa -->
                            <div>
                                <div class="card">
                                    <div class="card-body">

                                        <div style="margin-left: 20px;">

                                            {{-- id --}}
                                            @if ($get_kd != null)
                                                <input type="hidden" name="id" value="{{$get_kd->kode_kd}}">
                                            @endif
                                            
                                            {{-- tahun ajaran --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">No KD *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="no_kd"
                                                    value="{{ $get_kd != null ? $get_kd->no_kd : old('no_kd') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="No Kompetensi Dasar" 
                                                    id="no_kd" 
    
                                                    required>
                                                    @error('no_kd')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- nama  --}}
                                            {{-- <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kompetensi Dasar *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                        type="text" 
                                                        name="nama_kd" 
                                                        class="form-control" 
                                                        value="{{ $get_kd != null ? $get_kd->nama_kd : old('nama_kd') }}" placeholder="Kompetensi Dasar"
                                                        required
                                                    >
                                                </div>
                                            </div> --}}

                                            {{-- keterangan  --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kompetensi Dasar *</label>
                                                <div class="col-sm-10">
                                                    <textarea placeholder="Kompetensi Dasar" name="nama_kd" class="form-control" rows="3">{{ $get_kd != null ? $get_kd->nama_kd : old('nama_kd') }}</textarea>
                                                </div>
                                            </div>

                                            {{-- guru --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Mata Pelajaran *</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('kode_mt') }}"
                                                    name="kode_mt"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Mata Pelajaran</option>
                                                        @foreach ($list_mt as $keys=>$mt)
                                                            <option value="{{$mt->kode_mt}}" {{$get_kd != null && $mt->kode_mt === $get_kd->kode_mt ? 'selected' : ''}}>{{'('.$mt->kode_mt.') - '.$mt->nama_mt.' - ('.$mt->kelas->ket_kelas.')'}}</option>                                                            
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
                                                            <option value="{{$data->id}}" {{$get_kd != null && $data->id === $get_kd->id_semester ? 'selected' : ''}}>{{$data->nama_smester}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- semester --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Type *</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('type') }}"
                                                    name="type"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih type</option>
                                                        <option value="Pengetahuan" {{$get_kd != null && $get_kd->type == 'Pengetahuan' ? 'selected' : ''}}>Pengetahuan</option>
                                                        <option value="Keterampilan" {{$get_kd != null && $get_kd->type == 'Keterampilan' ? 'selected' : ''}}>Keterampilan</option>
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
                                            @if ($get_kd == null)
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
