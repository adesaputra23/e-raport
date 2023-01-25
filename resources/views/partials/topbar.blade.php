@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
    
@endphp

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src={{ asset('assets/images/logo-sm.png') }} alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src={{ asset('assets/images/logo-dark.png') }} alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img class="logo-1" src={{ asset('assets/images/logo-sm.png') }} alt="logo-sm-light"
                            height="22">
                    </span>
                    <span class="logo-lg">
                        <img class="logo-2" src={{ asset('assets/images/logo-light.png') }} alt="logo-light"
                            height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    @if (RoleUser::CheckRole()->user_role === RoleUser::Admin)
                        <span class="d-none d-xl-inline-block ms-1">{{ 'ADMIN' }}</span>
                    @endif

                    @if (in_array(RoleUser::CheckRole()->user_role, [RoleUser::WaliKelas, RoleUser::KP, RoleUser::Operator]))
                        <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->PegawaiGuru->nama }}</span>
                    @endif

                    @if (RoleUser::CheckRole()->user_role === RoleUser::WaliMurid)
                        <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->Siswa->nama }}</span>
                    @endif

                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                            class="ri-settings-3-line align-middle me-1"></i>
                        Ubah Password</button>
                    @if (Controller::isAdminPage())
                        <a class="dropdown-item text-danger" href={{ route('logout.admin') }}><i
                                class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                    @else
                        <a class="dropdown-item text-danger" href={{ route('logout') }}><i
                                class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
