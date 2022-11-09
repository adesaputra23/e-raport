@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
    $title = 'Kurikulum';
@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => "Tambah Data ".$title])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => "Tambah Data ".$title])

                        {{-- isi conten --}}

                        <form method="POST" action="{{route('kurikulum.simpan.data.admin')}}">
                        @csrf
                            <!-- Right Sidebar Data Kurikulum -->
                            <div>
                                <div class="card">
                                    <div class="card-body">

                                        <div style="margin-left: 20px;">

                                            {{-- id --}}
                                            @if ($data_kurikulum != null)
                                                <input type="hidden" name="id" value="{{$data_kurikulum->kode_kurikulum}}">
                                            @endif
                                            
                                            {{-- kode kurikulum --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kode Kurikulum *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kode_kurikulum"
                                                    value="{{ $data_kurikulum != null ? $data_kurikulum->kode_kurikulum : old('kode_kurikulum') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Kode Kurikulum" 
                                                    id="kode_kurikulum"      
                                                    required
                                                    
                                                    @if ($data_kurikulum != null)
                                                        readonly
                                                    @endif
                                                    
                                                    >
                                                    @error('kode_kurikulum')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                             {{-- nama kurikulum --}}
                                             <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Nama Kurikulum *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nama_kurikulum"
                                                    value="{{ $data_kurikulum != null ? $data_kurikulum->nama_kurikulum : old('nama_kurikulum') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Nama Kurikulum" 
                                                    id="nama_kurikulum"      
                                                    required
                                                    
                                                    @if ($data_kurikulum != null)
                                                        readonly
                                                    @endif
                                                    
                                                    >
                                                    @error('nama_kurikulum')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- ket kurikulum  --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea placeholder="Keterangan" name="desc_kurikulum" class="form-control" rows="3">{{ $data_kurikulum != null ? $data_kurikulum->desc_kurikulum : old('desc_kurikulum') }}</textarea>
                                                </div>
                                            </div>

                                            {{-- Status Kurikulum --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Status Aktif *</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('status_kurikulum') }}"
                                                    name="status_kurikulum"
                                                    class="form-select" aria-label="Default select example" required>
                                                        <option selected="" disabled>Pilih Status</option>
                                                        @if ($data_kurikulum != null)
                                                            <option value="1" {{$data_kurikulum->status_kurikulum == 1 ? 'selected' : ''}} >Aktif</option>
                                                            <option value="2" {{$data_kurikulum->status_kurikulum == 2 ? 'selected' : ''}}>Tidak Aktif</option>
                                                        @else
                                                            <option value="1" {{old('status_kurikulum') == 1 ? 'selected' : ''}} >Aktif</option>
                                                            <option value="2" {{old('status_kurikulum') == 2 ? 'selected' : ''}}>Tidak Aktif</option>
                                                        @endif
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
                                            @if ($data_kurikulum == null)
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
