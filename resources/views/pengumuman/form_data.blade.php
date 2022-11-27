@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => $title . ' Data Pengumuman'])
    @include('partials/head-css')
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
                    'title' => $title . ' Data Pengumuman',
                ])

                {{-- isi conten --}}

                <form method="POST" action="{{ route('penggumuman.save') }}">
                    @csrf
                    <!-- Right Sidebar Data Siswa -->
                    <div>
                        <div class="card">
                            <div class="card-body">

                                <div style="margin-left: 20px;">

                                    {{-- id --}}
                                    {{-- @if ($data_kelas != null)
                                        @endif --}}
                                    <input type="hidden" name="id"
                                        value="{{ !empty($pengumuman) ? $pengumuman->id_pengumuman : 0 }}">

                                    {{-- judul --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Judul
                                            *</label>
                                        <div class="col-sm-10">
                                            <input name="judul"
                                                value="{{ !empty($pengumuman) ? $pengumuman->judul : '' }}"
                                                class="form-control" type="text" placeholder="Judul Pengumuman"
                                                id="judul" required>
                                        </div>
                                    </div>

                                    {{-- isi pengumuman --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Isi*</label>
                                        <div class="col-sm-10">
                                            <textarea id="elm1" name="area" placeholder="Isi Pengumuman">{{ !empty($pengumuman) ? $pengumuman->isi : '' }}</textarea>
                                        </div>
                                    </div>

                                    {{-- tanggal --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal
                                            *</label>
                                        <div class="col-sm-10">
                                            <input name="tanggal"
                                                value="{{ !empty($pengumuman) ? date('Y-m-d', strtotime($pengumuman->tanggal)) : '' }}"
                                                class="form-control" type="date" placeholder="Tanggal" id="tanggal"
                                                required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        @if (empty($pengumuman))
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
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<!--tinymce js-->
<!-- init js -->
<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
<script src={{ asset('assets/js/app.js') }}></script>
</body>

</html>
