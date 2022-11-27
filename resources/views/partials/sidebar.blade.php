@php
    use App\Http\Controllers\Controller;
    use App\RoleUser;
    use App\Kurikulum;
@endphp
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">

                @if (RoleUser::CheckRole()->user_role !== RoleUser::WaliMurid)
                    @if (Auth::user()->PegawaiGuru->foto == null)
                        <img src={{ asset('assets/images/users/default_profileXz.png') }} alt=""
                            class="avatar-md rounded-circle">
                    @else
                        <img src={{ asset('assets/images/users') . '/' . Auth::user()->PegawaiGuru->foto }}
                            alt="" class="avatar-md rounded-circle">
                    @endif
                @endif

                @if (RoleUser::CheckRole()->user_role === RoleUser::WaliMurid)
                    @if (Auth::user()->Siswa->foto == null)
                        <img src={{ asset('assets/images/users/default_profileXz.png') }} alt=""
                            class="avatar-md rounded-circle">
                    @else
                        <img src={{ asset('assets/images/users') . '/' . Auth::user()->Siswa->foto }} alt=""
                            class="avatar-md rounded-circle">
                    @endif
                @endif

            </div>
            <div class="mt-3">
                @if (RoleUser::CheckRole()->user_role !== RoleUser::WaliMurid)
                    <h4 class="font-size-16 mb-1">{{ Auth::user()->PegawaiGuru->nama }}</h4>
                @endif

                @if (RoleUser::CheckRole()->user_role === RoleUser::WaliMurid)
                    <h4 class="font-size-16 mb-1">{{ Auth::user()->Siswa->nama }}</h4>
                @endif

                <p class="user-code">{{ Auth::user()->user_code }}</p>
                <b><span class="text-muted">{{ RoleUser::MAP_ROLE[RoleUser::CheckRole()->user_role] }}</span></b>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu" class="side-1">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                @if (Controller::isAdminPage())
                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/home') }}" class="waves-effect">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-title">Data Master</li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/kurikulum/lihat-data') }}" class="waves-effect">
                            <i class="fas fa-equals"></i>
                            <span>Kurikulum</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/tahun-ajaran/lihat-data') }}" class="waves-effect">
                            <i class="far fa-calendar"></i>
                            <span>Tahun Ajaran</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/siswa/lihat-data') }}" class="waves-effect">
                            <i class="fas fa-user-graduate"></i>
                            <span>Siswa</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/kelas/lihat-data') }}" class="waves-effect">
                            <i class="fas fa-warehouse"></i>
                            <span>Kelas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran') }}" class="waves-effect">
                            <i class="fas fa-list-alt"></i>
                            <span>Mata Pelajaran</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/kompetensi-dasar') }}" class="waves-effect">
                            <i class="fas fa-align-justify "></i>
                            <span>Kompetensi Dasar (K13)</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-align-justify "></i>
                            <span>Assesment (K22)</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="{{ URL(Session::get('prefix') . '/assesment/materi') }}">Materi</a></li>
                            <li><a
                                    href="{{ URL(Session::get('prefix') . '/assesment/tujuan-pembelajaran') }}">Tujuan</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/ekskul') }}" class="waves-effect">
                            <i class="fas fa-futbol"></i>
                            <span>Ekskul</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/pegawai-guru/lihat-data') }}" class="waves-effect">
                            <i class="fas fa-user-tie"></i>
                            <span>Guru & Pegawai</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/kelas-siswa/lihat-data') }}" class="waves-effect">
                            <i class="fas fa-th-list"></i>
                            <span>Maping Siswa</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/pengumuman/index') }}" class="waves-effect">
                            <i class="fas fa-bullhorn"></i>
                            <span>Pengumuman</span>
                        </a>
                    </li>

                    <li class="menu-title">User Roles</li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-user-cog"></i>
                            <span>User</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ URL(Session::get('prefix') . '/user/lihat-data/?menu=pegawai') }}">Guru</a>
                            </li>
                            <li><a
                                    href="{{ URL(Session::get('prefix') . '/user/lihat-data/?menu=siswa / wali murid') }}">Siswa
                                    / Wali Murid</a></li>
                        </ul>
                    </li>
                @elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliKelas)
                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/home') }}" class="waves-effect">
                            <i class="ri-dashboard-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/siswa/lihat-data') }}" class="waves-effect">
                            <i class="fas fa-user-graduate"></i>
                            <span>Siswa</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran') }}" class="waves-effect">
                            <i class="fas fa-list-alt"></i>
                            <span>Mata Pelajaran</span>
                        </a>
                    </li>

                    @if (Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::K13)
                        <li>
                            <a href="{{ URL(Session::get('prefix') . '/kompetensi-dasar') }}" class="waves-effect">
                                <i class="fas fa-align-justify "></i>
                                <span>Kompetensi Dasar (K13)</span>
                            </a>
                        </li>
                    @elseif(Kurikulum::GetAktiveKurikulum()->kode_kurikulum == Kurikulum::Prototype)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-align-justify "></i>
                                <span>Assesment (K22)</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ URL(Session::get('prefix') . '/assesment/materi') }}">Materi</a></li>
                                <li><a
                                        href="{{ URL(Session::get('prefix') . '/assesment/tujuan-pembelajaran') }}">Tujuan</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/penilaian') }}" class="waves-effect">
                            <i class="fas fa-spell-check"></i>
                            <span>Penilaian Akademik</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/absensi') }}" class="waves-effect">
                            <i class="fas fa-address-book"></i>
                            <span>Absensi</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/nilai-raport') }}" class="waves-effect">
                            <i class="fas fa-file-alt"></i>
                            <span>Nilai Raport</span>
                        </a>
                    </li>
                @elseif(RoleUser::CheckRole()->user_role === RoleUser::WaliMurid)
                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/home') }}" class="waves-effect">
                            <i class="ri-dashboard-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/absensi/monitoring') }}" class="waves-effect">
                            <i class="fas fa-address-book"></i>
                            <span>Monitoring Absensi</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ URL(Session::get('prefix') . '/pemlajaran/monitoring-pembelajaran') }}"
                            class="waves-effect">
                            <i class="fas fa-user-graduate"></i>
                            <span>Monitoring Penilaian</span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/nilai-raport') }}" class="waves-effect">
                            <i class="fas fa-file-alt"></i>
                            <span>Nilai Raport</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/pengumuman/index') }}" class="waves-effect">
                            <i class="fas fa-bullhorn"></i>
                            <span>Pengumuman</span>
                        </a>
                    </li>
                @elseif(RoleUser::CheckRole()->user_role === RoleUser::KP)
                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/home') }}" class="waves-effect">
                            <i class="ri-dashboard-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran/jadwal-ngajar') }}"
                            class="waves-effect">
                            <i class="fas fa-calendar"></i>
                            <span>Jadwal Mengajar</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/absensi/monitoring') }}" class="waves-effect">
                            <i class="fas fa-address-book"></i>
                            <span>Monitoring Absensi</span>
                        </a>
                    </li>

                    {{-- <li>
                        <a href="{{ URL(Session::get('prefix') . '/pemlajaran/monitoring-pembelajaran') }}"
                            class="waves-effect">
                            <i class="fas fa-user-graduate"></i>
                            <span>Monitoring Penilaian</span>
                        </a>
                    </li> --}}

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/nilai-raport') }}" class="waves-effect">
                            <i class="fas fa-file-alt"></i>
                            <span>Nilai Raport</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL(Session::get('prefix') . '/guru-pegawai/set-nip') }}" class="waves-effect">
                            <i class="fas fa-cogs"></i>
                            <span>Seting NIP</span>
                        </a>
                    </li>

                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
