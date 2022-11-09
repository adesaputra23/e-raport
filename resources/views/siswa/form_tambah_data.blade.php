@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include("partials/main")
    <head>
        @include("partials/title-meta", ["title" => "Tambah Data Siswa"])
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
                        @include("partials/page-title", ["pagetitle" => "Dashboard", "title" => "Tambah Data Siswa"])

                        {{-- isi conten --}}

                        <form method="POST" action="{{route('siswa.simpan.data.admin')}}" enctype="multipart/form-data">
                        @csrf
                            <!-- Left sidebar data siswa -->
                                <div class="email-leftbar card">
                                    <!-- User details -->
                                    <div class="user-profile text-center mt-3">
                                        <div class="">
                                            @if ($data_siswa == null)
                                                <img src={{asset("assets/images/users/default_profileXz.png")}} alt="" class="avatar-xl">
                                            @else
                                                @if ($data_siswa->foto == null)
                                                    <img src={{asset("assets/images/users/default_profileXz.png")}} alt="" class="avatar-xl">
                                                @else
                                                    <img src={{asset("assets/images/users/").'/'.$data_siswa->foto}} alt="" class="avatar-xl">
                                                @endif
                                            @endif
                                        </div>
                                        @if ($data_siswa != null)
                                            <div class="mt-3">
                                                <h4 class="font-size-16 mb-1">{{$data_siswa->nama}}</h4>
                                                <p class="user-code">{{$data_siswa->nik}}</p>
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <h4 class="card-title">Upload Foto Siswa</h4>
                                            <div class="input-group">
                                                <input 
                                                value="{{ old('foto') }}"
                                                type="file" class="form-control form-control-sm" id="customFile" name="foto">
                                            </div>
                                            @error('foto')
                                                <small class="text-danger">
                                                    <i class="fa fa-warning"></i>
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            <!-- Right Sidebar Data Siswa -->
                            <div class="email-rightbar mb-3">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-2 float-end">
                                            <small class="text-danger">
                                                Node : Harap isi inputan yang bertanda *
                                            </small>
                                        </div>

                                        <h4>Data Siswa</h4>
                                        <hr>

                                        <div style="margin-left: 20px;">
                                            
                                            {{-- nisn --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">NISN *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nisn"
                                                    value="{{ $data_siswa != null ? $data_siswa->nisn : old('nisn') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="NISN" 
                                                    id="nisn"  
    
                                                    @if ($data_siswa != null)
                                                        readonly
                                                    @endif
    
                                                    required>
                                                    @error('nisn')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- nis --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">NIS</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nis"
                                                    value="{{ $data_siswa != null ? $data_siswa->nis : old('nis') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="NIS" 
                                                    id="nis"  
    
                                                    {{-- @if ($data_siswa != null)
                                                        readonly
                                                    @endif
    
                                                    required --}}
                                                    >
                                                    @error('nis')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
    
                                            {{-- email --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Email *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="email"
                                                    value="{{ $data_siswa != null ? $data_siswa->User->email : old('email') }}"
                                                    class="form-control" type="email" placeholder="Email" id="email" required>
                                                    @error('email')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
    
                                            {{-- Nama --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Nama *</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nama"
                                                    value="{{ $data_siswa != null ? $data_siswa->nama : old('nama') }}"
                                                    class="form-control" type="text" placeholder="Nama" id="nama" required>
                                                </div>
                                            </div>
    
                                            {{-- jenis kelmain --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Jenis Kelamin *</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('jenis_kelamin') }}"
                                                    name="jenis_kelamin"
                                                    class="form-select" aria-label="Default select example" required>
                                                        <option selected="" disabled>Pilih Jenis Kelamin</option>
                                                        @if ($data_siswa != null)
                                                            <option value="1" {{$data_siswa->jenis_kelamin == 1 ? 'selected' : ''}} >Laki-Laki</option>
                                                            <option value="2" {{$data_siswa->jenis_kelamin == 2 ? 'selected' : ''}}>Perempuan</option>
                                                        @else
                                                            <option value="1" {{old('jenis_kelamin') == 1 ? 'selected' : ''}} >Laki-Laki</option>
                                                            <option value="2" {{old('jenis_kelamin') == 2 ? 'selected' : ''}}>Perempuan</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- tempat lahir --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Tempat Lahir</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="tempat_lahir"
                                                    value="{{ $data_siswa != null ? $data_siswa->tempat_lahir : old('tempat_lahir') }}"
                                                    class="form-control" type="text" placeholder="Tempat Lahir" id="tempat_lahir">
                                                </div>
                                            </div>
    
                                            {{-- tanggal lahir --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="tanggal_lahir"
                                                    value="{{ $data_siswa != null ? $data_siswa->tanggal_lahir : old('tanggal_lahir') }}"
                                                    class="form-control" type="date" placeholder="Tanggal Lahir" id="example-date-input">
                                                </div>
                                            </div>
    
                                            {{-- Agama --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Agama</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    name="agama"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Agama</option>
                                                        @foreach ($list_agama as $items=>$agama)
                                                            <option value="{{$items}}" {{ $data_siswa != null && $data_siswa->agama == $items ? 'selected' : '' }}>{{$agama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Alamat --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-10">
                                                    <textarea 
                                                    name="alamat"
                                                    class="form-control" placeholder="Alamat" id="alamat" rows="3">{{ $data_siswa != null ? $data_siswa->alamat : old('alamat') }}</textarea>
                                                </div>
                                            </div>

                                            {{-- Status Anak --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Status Anak</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="status_anak"
                                                    value="{{ $data_siswa != null ? $data_siswa->status_anak : old('status_anak') }}"
                                                    class="form-control" type="text" placeholder="Status Anak" id="status_anak">
                                                </div>
                                            </div>

                                            {{-- kontak --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">Kontak</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kontak"
                                                    value="{{ $data_siswa != null ? $data_siswa->kontak : old('kontak') }}"
                                                    class="form-control" type="numerik" placeholder="Kontak" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- Negara --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">Negara</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="negara"
                                                    value="{{ $data_siswa != null ? $data_siswa->negara : old('negara') }}"
                                                    class="form-control" type="text" placeholder="Negara" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- Provinsi --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">Provinsi</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="provinsi"
                                                    value="{{ $data_siswa != null ? $data_siswa->provinsi : old('provinsi') }}"
                                                    class="form-control" type="text" placeholder="Provinsi" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- Kota --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">Kota</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kota"
                                                    value="{{ $data_siswa != null ? $data_siswa->kota : old('kota') }}"
                                                    class="form-control" type="text" placeholder="Kota" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- Kode Pos --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">Kode Pos</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="kode_pos"
                                                    value="{{ $data_siswa != null ? $data_siswa->kode_pos : old('kode_pos') }}"
                                                    class="form-control" type="number" placeholder="Kode Pos" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- No Tlp Rumah --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">No Telpon Rumah</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="no_tlp_rumah"
                                                    value="{{ $data_siswa != null ? $data_siswa->no_tlp_rumah : old('no_tlp_rumah') }}"
                                                    class="form-control" type="text" placeholder="No Telpon Rumah" id="example-date-input">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Right Sidebar Data Wali dan Orangtua-->
                            <!-- Right Sidebar  Data Ayah-->
                            <div class="email-rightbar mb-3">
                                <div class="card">
                                    <div class="card-body">

                                        <h4>Data Ayah</h4>
                                        <hr>

                                        <div style="margin-left: 20px;">
                                            
                                            {{-- nik_ayah --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">NIK</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nik_ayah"
                                                    value="{{ $data_siswa != null ? $data_siswa->nik_ayah : old('nik_ayah') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="NIK" 
                                                    id="example-text-input">
                                                    @error('nik_ayah')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
    
                                            {{-- Nama Ayah --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nama_ayah"
                                                    value="{{ $data_siswa != null ? $data_siswa->nama_ayah : old('nama_ayah') }}"
                                                    class="form-control" type="text" placeholder="Nama" id="example-text-input">
                                                </div>
                                            </div>
    
                                            {{-- pekerjaan ayah --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Pekerjaan</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('pekerjaan_ayah') }}"
                                                    name="pekerjaan_ayah"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Jenis Pekerjaan</option>
                                                        @foreach ($list_pekerjaan as $p_ayah_keys=>$pekerjaan_ayah)
                                                            <option value="{{$p_ayah_keys}}" >{{$pekerjaan_ayah}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- no telpon ayah --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">No Telpon</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="n_hp_ayah"
                                                    value="{{ $data_siswa != null ? $data_siswa->no_hp_ayah : old('n_hp_ayah') }}"
                                                    class="form-control" type="number" placeholder="No Telpon" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- email ayah --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="email_ayah"
                                                    value="{{ $data_siswa != null ? $data_siswa->email_ayah : old('email_ayah') }}"
                                                    class="form-control" type="email" placeholder="Email" id="example-text-input">
                                                    @error('email_ayah')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- pendidikan ayah --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Pendidikan</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('pendidikan_ayah') }}"
                                                    name="pendidikan_ayah"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Jenis Pendidikan</option>
                                                        @foreach ($list_pendidikan as $pn_ayah_keys=>$pendidikan_ayah)
                                                            <option value="{{$pn_ayah_keys}}" >{{$pendidikan_ayah}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Right Sidebar  Data ibu-->
                            <div class="email-rightbar mb-3">
                                <div class="card">
                                    <div class="card-body">

                                        <h4>Data Ibu</h4>
                                        <hr>

                                        <div style="margin-left: 20px;">
                                            
                                            {{-- nik_ibu --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">NIK</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nik_ibu"
                                                    value="{{ $data_siswa != null ? $data_siswa->nik_ibu : old('nik_ibu') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="NIK" 
                                                    id="example-text-input">
                                                    @error('nik_ibu')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
    
                                            {{-- Nama Ibu --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nama_ibu"
                                                    value="{{ $data_siswa != null ? $data_siswa->nama_ibu : old('nama_ibu') }}"
                                                    class="form-control" type="text" placeholder="Nama" id="example-text-input">
                                                </div>
                                            </div>
    
                                            {{-- pekerjaan ibu --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Pekerjaan</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('pekerjaan_ibu') }}"
                                                    name="pekerjaan_ibu"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Jenis Pekerjaan</option>
                                                        @foreach ($list_pekerjaan as $p_ibu_keys=>$pekerjaan_ibu)
                                                            <option value="{{$p_ibu_keys}}" >{{$pekerjaan_ibu}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- no telpon ibu --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">No Telpon</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="n_hp_ibu"
                                                    value="{{ $data_siswa != null ? $data_siswa->no_hp_ibu : old('n_hp_ibu') }}"
                                                    class="form-control" type="number" placeholder="No Telpon" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- email ibu --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="email_ibu"
                                                    value="{{ $data_siswa != null ? $data_siswa->email_ibu : old('email_ibu') }}"
                                                    class="form-control" type="email" placeholder="Email" id="example-text-input">
                                                    @error('email_ibu')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- pendidikan ibu --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Pendidikan</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('pendidikan_ibu') }}"
                                                    name="pendidikan_ibu"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Jenis Pendidikan</option>
                                                        @foreach ($list_pendidikan as $pn_ibu_keys=>$pendidikan_ibu)
                                                            <option value="{{$pn_ibu_keys}}" >{{$pendidikan_ibu}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Right Sidebar  Data Wali-->
                            <div class="email-rightbar mb-3">
                                <div class="card">
                                    <div class="card-body">

                                        <h4>Data Wali</h4>
                                        <hr>

                                        <div style="margin-left: 20px;">
                                            
                                            {{-- nik_wali --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">NIK</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nik_wali"
                                                    value="{{ $data_siswa != null ? $data_siswa->nik_wali : old('nik_wali') }}"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="NIK" 
                                                    id="example-text-input">
                                                    @error('nik_wali')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
    
                                            {{-- Nama wali --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="nama_wali"
                                                    value="{{ $data_siswa != null ? $data_siswa->nama_wali : old('nama_wali') }}"
                                                    class="form-control" type="text" placeholder="Nama" id="example-text-input">
                                                </div>
                                            </div>
    
                                            {{-- pekerjaan wali --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Pekerjaan</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('pekerjaan_wali') }}"
                                                    name="pekerjaan_wali"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Jenis Pekerjaan</option>
                                                        @foreach ($list_pekerjaan as $p_wali_keys=>$pekerjaan_wali)
                                                            <option value="{{$p_wali_keys}}" >{{$pekerjaan_wali}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- no telpon wali --}}
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-sm-2 col-form-label">No Telpon</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="n_hp_wali"
                                                    value="{{ $data_siswa != null ? $data_siswa->no_hp_wali : old('n_hp_wali') }}"
                                                    class="form-control" type="number" placeholder="No Telpon" id="example-date-input">
                                                </div>
                                            </div>

                                            {{-- email wali --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input 
                                                    name="email_wali"
                                                    value="{{ $data_siswa != null ? $data_siswa->email_wali : old('email_wali') }}"
                                                    class="form-control" type="email" placeholder="Email" id="example-text-input">
                                                    @error('email_wali')
                                                        <small class="text-danger">
                                                            <i class="fa fa-warning"></i>
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- pendidikan wali --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">Pendidikan</label>
                                                <div class="col-sm-10">
                                                    <select 
                                                    value="{{ old('pendidikan_wali') }}"
                                                    name="pendidikan_wali"
                                                    class="form-select" aria-label="Default select example">
                                                        <option selected="" disabled>Pilih Jenis Pendidikan</option>
                                                        @foreach ($list_pendidikan as $pn_wali_keys=>$pendidikan_wali)
                                                            <option value="{{$pn_wali_keys}}" >{{$pendidikan_wali}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="email-rightbar mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end">
                                            @if ($data_siswa == null)
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
