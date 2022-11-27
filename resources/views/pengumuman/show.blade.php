@php
    use App\User;
    use App\Http\Controllers\Controller;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data Pengumuman'])
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
                    'title' => 'Detail Data Pengumuman',
                ])
                @include('partials/alert_mesage')
                {{-- isi conten --}}
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">{{ $pengumuman->judul }}</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="float-end">
                                <h6><small
                                        class="text-muted">{{ date('d-m-Y H:i:s', strtotime($pengumuman->tanggal)) }}</small>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {!! $pengumuman->isi !!}
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

@include('partials/right-sidebar')
@include('partials/vendor-scripts')
<script src={{ asset('assets/js/app.js') }}></script>
</body>

</html>
