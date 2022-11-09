@php
    use App\User;
    use App\TahunAjaran;
    use App\Siswa;
    use App\RoleUser;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Monitoring Penilaian'])
    <link href={{ asset('assets/libs/select2/css/select2.min.css') }} rel="stylesheet" type="text/css">
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
                    'title' => 'Monitoring Penilaian',
                ])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">

                    @if (RoleUser::CheckRole()->user_role === RoleUser::KP)
                        <label for="">Pilih Siswa</label>
                        <select name="siwa" id="siswa" class="form-control select2">
                            <option value="">Pilih Siswa</option>
                            @foreach ($list_siswa as $item => $value)
                                <option value="{{ $value->nisn }}">{{ $value->nisn }}/{{ $value->nis }} -
                                    {{ $value->nama }}
                                </option>
                            @endforeach
                        </select>
                    @elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid)
                        <label for="">Pilih Siswa</label>
                        <select name="siwa" id="siswa" class="form-control select2">
                            <option value="" selected disabled>Select Siswa</option>
                            <option value="{{ $list_siswa->nisn }}">{{ $list_siswa->nisn }}/{{ $list_siswa->nis }} -
                                {{ $list_siswa->nama }}
                            </option>
                        </select>
                    @endif

                    <div id="data"></div>
                </div>

                {{-- end isi conten --}}

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('partials/footer')

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

{{-- modal --}}

{{-- end modal --}}

@include('partials/right-sidebar')
@include('partials/vendor-scripts')
<script src={{ asset('assets/libs/select2/js/select2.min.js') }}></script>
<script src={{ asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}></script>
<script src={{ asset('assets/js/pages/form-advanced.init.js') }}></script>
<script src={{ asset('assets/libs/parsleyjs/parsley.min.js') }}></script>
<script src={{ asset('assets/js/pages/form-validation.init.js') }}></script>
<script src={{ asset('assets/libs/node-waves/waves.min.js') }}></script>
<script src={{ asset('assets/js/app.js') }}></script>
</body>

<script>
    $('#siswa').on('change', function() {
        var nisn = $(this).val();
        $.ajax({
            url: "{{ url('penilaian/ajax-get-list-penilaian') }}",
            method: "POST",
            data: {
                nisn: nisn,
                _token: '{{ csrf_token() }}'
            },
            cache: true,
            dataType: 'json',
            success: function(resp) {
                var html = '';
                var li = '';
                if (resp.length != 0) {
                    $.each(resp, function(index, value) {
                        var getName = index.replace(/ /g, '');
                        html += `
                        <div id="accordion" class="custom-accordion">
                            <div class="card shadow-none mt-3 mb-1" style="margin-bottom: -8px;">
                                <a href="#${getName}" class="text-dark collapsed" data-bs-toggle="collapse"
                                    aria-expanded="false" aria-controls="${getName}">
                                    <div class="card-header" id="headingTwo">
                                        <h6 class="m-0">
                                            ${index}
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="${getName}" class="collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <ul>`;
                        $.each(value, function(indexInArray, valueOfElement) {
                            var smseter = valueOfElement.id_semester ??
                                valueOfElement
                                .id_smester;
                            var url_detail_nilai =
                                "{{ url('/pemlajaran/detail-penilaian') }}/" +
                                nisn + '/' + valueOfElement.kode_kelas + '/' +
                                smseter;
                            html +=
                                `<li> <a href="${url_detail_nilai}"> Semester ${valueOfElement.id_semester ?? valueOfElement.id_smester} </a></li>`;
                        });
                        html += `</ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        $('#data').html(html);
                    });
                } else {
                    html += `
                        <div class="mt-3">Belum ada penilaian</div>
                    `;
                    $('#data').html(html);
                }
            }
        })
    });
</script>

</html>
