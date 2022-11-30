<div class="row" style="margin-top: -14px;">
    <div class="col-xl-3 col-md-4">
        <a href="{{ URL(Session::get('prefix') . '/siswa/lihat-data') }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-body border border-primary">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="color: black">Siswa</p>
                                <h4 class="mb-2">{{ $count_siswa }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-user-graduate font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a>
    </div>
    <div class="col-xl-3 col-md-4">
        <a href="{{ URL(Session::get('prefix') . '/kelas/lihat-data') }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-body border border-primary">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="color: black">Kelas</p>
                                <h4 class="mb-2">{{ $count_kelas }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-warehouse font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a>
    </div>
    <div class="col-xl-3 col-md-4">
        <a href="{{ URL(Session::get('prefix') . '/tahun-ajaran/lihat-data') }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-body border border-primary">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="color: black;">Tahun Ajaran</p>
                                <h4 class="mb-2">{{ $count_tahun_ajaran }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="far fa-calendar font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a>
    </div>
    <div class="col-xl-3 col-md-4">
        <a href="{{ URL(Session::get('prefix') . '/ekskul') }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-body border border-primary">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="color: black;">Ekskul</p>
                                <h4 class="mb-2">{{ $count_ekskul }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-futbol font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a>
    </div>
    <div class="col-xl-6 col-md-4">
        <a href="{{ URL(Session::get('prefix') . '/mata-pelajaran') }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-body border border-primary">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="color: black;">Mata Pelajaran</p>
                                <h6 class="mb-2">Kurikulum K13 : {{ $count_mp_k13 }}</h6>
                                <h6 class="mb-2">Kurikulum Prototype : {{ $count_mp_22 }}</h6>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-list-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a>
    </div>
    <div class="col-xl-3 col-md-4">
        <a href="{{ URL(Session::get('prefix') . '/user/lihat-data/?menu=pegawai') }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-body border border-primary">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="color: black;">User</p>
                                <h4 class="mb-2">{{ $count_user }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-user-cog font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a>
    </div>
    <div class="col-xl-3 col-md-4">
        <a href="{{ URL(Session::get('prefix') . '/pegawai-guru/lihat-data') }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-body border border-primary">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="color: black;">Pegawai</p>
                                <h4 class="mb-2">{{ $count_guru_pegawai }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-user-tie font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a>
    </div>
</div>
