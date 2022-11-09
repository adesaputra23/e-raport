@php
    use App\User;
    use App\Http\Controllers\Controller;
    use App\RoleUser;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Dashboard'])
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
                @include('partials/page-title', ['pagetitle' => 'E-Raport', 'title' => 'Dashboard'])

                <div class="col-lg-12">
                    <div class="card bg-info text-white-50">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="mb-4 text-white"><i
                                            class="mdi mdi-alert-circle-outline me-3"></i>Informasi</h5>
                                    <p class="card-text text-white">
                                    <ul class="text-white">
                                        <li>{{ $message_tahun_ajaran }}</li>
                                        <li>{{ $message_kurikulum }}</li>
                                        <li>{{ $message_semester }}</li>
                                    </ul>
                                    </p>
                                </div>
                                <div class="col-md"
                                    style="display: flex; align-items: center; justify-content: center;">
                                    <h5 class="mb-4 text-white text-center">
                                        <div>
                                            <blockquote class="blockquote font-size-16 mb-0">
                                                <p>Selamat datang di sistem penilaian siswa UPTD SPF SDN ARDISAENG 01
                                                    Bondowoso</p>
                                                <footer style="margin-top: -12px;" style="color: white;">
                                                    Anda Login Sebagai
                                                    <cite
                                                        title="Source Title">{{ RoleUser::MAP_ROLE[RoleUser::CheckRole()->user_role] }}</cite>
                                                </footer>
                                            </blockquote>
                                        </div>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- div count data master --}}
                @if (RoleUser::CheckRole()->user_role === RoleUser::Admin)
                    @include('home_admin')
                @elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas)
                    @include('home_wali_kelas')
                @endif

            </div>
            {{-- end count data master --}}

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
