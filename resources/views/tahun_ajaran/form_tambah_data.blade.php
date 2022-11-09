@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => "Tambah Data Tahun Ajaran"])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => "Tambah Data Tahun Ajaran"])

                        {{-- isi conten --}}

                        <form method="POST" action="{{route('tahun.ajaran.simpan.data.admin')}}">
                        @csrf
                            <!-- Right Sidebar Data Siswa -->
                            <div>
                                <div class="card">
                                    <div class="card-body">

                                        <div style="margin-left: 20px;">

                                            {{-- id --}}
                                            @if ($data_tahun_ajaran != null)
                                                <input type="hidden" name="id_tahun_ajaran" value="{{$data_tahun_ajaran->id_tahun_ajaran}}">
                                            @endif
                                            
                                            {{-- tahun ajaran --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Tahun Ajaran *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="tahun_ajaran"
                                                    value="{{ $data_tahun_ajaran != null ? $data_tahun_ajaran->tahun_ajaran : old('tahun_ajaran') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Tahun Ajaran" 
                                                    id="tahun_ajaran"  
    
                                                    @if ($data_tahun_ajaran != null)
                                                        readonly
                                                    @endif
    
                                                    required>
                                                    @error('tahun_ajaran')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- ket tahun ajaran  --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea name="ket_tahun_ajaran" class="form-control" rows="3">{{ $data_tahun_ajaran != null ? $data_tahun_ajaran->ket_tahun_ajaran : old('ket_tahun_ajaran') }}</textarea>
                                                </div>
                                            </div>

                                            {{-- status aktif --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Status Aktif</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('status_aktif') }}"
                                                    name="status_aktif"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Status</option>
                                                        @foreach ($list_status as $keys=>$status)
                                                            <option value="{{$keys}}" {{$data_tahun_ajaran != null && $data_tahun_ajaran->status_aktif === $keys ? 'selected' : ''}}>{{$status}}</option>                                                            
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
                                            @if ($data_tahun_ajaran == null)
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
