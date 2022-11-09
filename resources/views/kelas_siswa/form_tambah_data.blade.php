@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Tambah Data Siswa Kelas'])

    <link href={{ asset('assets/libs/select2/css/select2.min.css') }} rel="stylesheet" type="text/css">

    @include('partials/head-css')
    <style>
        .bs-example {
            /* font-family: sans-serif; */
            position: relative;
            margin: 100px;
        }

        .typeahead,
        .tt-query,
        .tt-hint {
            border: 1px solid #CCCCCC;
            border-radius: 4px;
            font-size: 15px;
            /* Set input font size */
            height: 40px;
            line-height: 30px;
            outline: medium none;
            padding: 8px 12px;
            width: 910px;
        }

        .typeahead {
            background-color: #FFFFFF;
        }

        .tt-query {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        }

        .tt-hint {
            color: #999999;
        }

        .tt-menu {
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            padding: 8px 0;
            width: 422px;
        }

        .tt-suggestion {
            font-size: 15px;
            /* Set suggestion dropdown font size */
            padding: 3px 20px;
        }

        .tt-suggestion:hover {
            cursor: pointer;
            background-color: #0097CF;
            color: #FFFFFF;
        }

        .tt-suggestion p {
            margin: 0;
        }

        #scrollable-dropdown-menu .tt-dropdown-menu {
            max-height: 150px;
            overflow-y: auto;
        }
    </style>
</head>

@include('partials/body')
<!-- Begin page -->
<div id="layout-wrapper">
    @include('partials/menu')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('partials/page-title', [
                    'pagetitle' => 'Dashboard',
                    'title' => 'Tambah Data Siswa Kelas',
                ])

                {{-- isi conten --}}

                <form method="POST" action="{{ route('kelas.siswa.simpan.data.admin') }}">
                    @csrf
                    <!-- Right Sidebar Data Siswa -->
                    <div>
                        <div class="card">
                            <div class="card-body">

                                <div style="margin-left: 20px;">

                                    {{-- id --}}
                                    @if ($data_siswa_kelas != null)
                                        <input type="hidden" name="id"
                                            value="{{ $data_siswa_kelas->id_siswa_kelas }}">
                                    @endif

                                    {{-- kode kelas --}}
                                    <div class="row mb-3" id="the-basics">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">NISN/NIS/NAMA
                                            *</label>
                                        <div class="col-sm-10">
                                            {{-- value="{{ $data_siswa_kelas != null ? $data_siswa_kelas->nisn : old('nisn') }}" --}}
                                            {{-- <input 
                                                    name="nisn"
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="NISN" 
                                                    id="nisn"      
                                                    required> --}}
                                            <input class="typeahead" type="text" placeholder="NISN/NIS/NAMA"
                                                name="nisn"
                                                @if ($data_siswa_kelas != null) value="{{ $data_siswa_kelas->nisn . '/' . $data_siswa_kelas->siswa->nis . '-' . $data_siswa_kelas->siswa->nama }}" @endif>
                                            @error('nisn')
                                                <small class="text-danger">
                                                    <i class="fa fa-warning"></i>
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- kelas --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kelas *</label>
                                        <div class="col-lg-10">
                                            <select class="form-control select2" name="kelas">
                                                <option value="" selected disabled>Pilih Kelas</option>
                                                @foreach ($list_kelas as $keys => $kelas)
                                                    <option value="{{ $kelas->kode_kelas }}"
                                                        {{ $data_siswa_kelas != null && $kelas->kode_kelas == $data_siswa_kelas->kode_kelas ? 'selected' : '' }}>
                                                        {{ $kelas->kode_kelas . '-' . $kelas->kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>


                                    {{-- Tahun Ajaran --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Tahun Ajaran
                                            *</label>
                                        <div class="col-sm-10">
                                            <input name="tahun_ajaran"
                                                value="{{ $tahun_ajaran != null ? $tahun_ajaran->tahun_ajaran : '' }}"
                                                class="form-control" type="text" placeholder="Tahun Ajaran"
                                                id="tahun_ajaran" readonly required>
                                            @error('kelas')
                                                <small class="text-danger">
                                                    <i class="fa fa-warning"></i>
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        @if ($data_siswa_kelas == null)
                                            <button type="submit" name="action" value="tambah"
                                                class="btn btn-success waves-effect waves-light">
                                                <i class="ri-check-line align-middle me-2"></i> Simpan
                                            </button>
                                        @else
                                            <button type="submit" name="action" value="ubah"
                                                class="btn btn-success waves-effect waves-light">
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

        @include('partials/footer')

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@include('partials/right-sidebar')

@include('partials/vendor-scripts')

<script src={{ asset('assets/libs/select2/js/select2.min.js') }}></script>
<script src={{ asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}></script>
<script src={{ asset('assets/js/pages/form-advanced.init.js') }}></script>
<script src={{ asset('assets/js/typeahead.bundle.js') }}></script>
<script src={{ asset('assets/js/app.js') }}></script>
<script>
    // typehead
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    var nisn = $('#nisn').val();
    var route = "{{ route('siswa.api') }}";
    var get_data = $.ajax({
        url: route,
        method: "GET",
        data: {
            nisn: nisn
        },
        success: function(resp) {
            $('#the-basics .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'resp',
                source: substringMatcher(resp)
            });
            console.log(resp);
        }
    });
</script>
</body>

</html>
