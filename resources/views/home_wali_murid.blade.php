<div class="col-md-12">
    <div class="card card-body">
        <div class="row">
            <div class="col-md-8">
                <h2 class="card-title">Pengumuman</h2>
            </div>
            <div class="col-md">
                <div class="float-end">
                    <a href="{{ URL(Session::get('prefix') . '/pengumuman/index') }}" class="blockquote-footer m-0"
                        style="cursor: pointer;">Lihat semua pengumuman</a>
                </div>
            </div>
        </div>
        <hr>
        {{-- conten --}}
        <div class="overflow-auto p-3" style="max-width: 100%; max-height: 260px;">
            <div class="row">
                @php
                    $nilai = 2;
                @endphp
                @if ($nilai < 1)
                    <p class="lead">
                        Belum ada pengumuman.!
                    </p>
                @endif
                @foreach ($pengumumans as $item => $data)
                    <div class="col-xl-4 col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-10 mb-2">
                                            {{ date('d M Y H:i:s', strtotime($data->tanggal)) }} WIB</p>
                                        <h5 class="mb-2">{{ substr($data->judul, 0, 20) . '...' }}</h5>
                                        <a href="{{ route('penggumuman.show', ['id' => $data->id_pengumuman]) }}"
                                            class="text-muted mb-0 font-size-12"><i
                                                class="ri-arrow-right-up-line me-1 align-middle"></i>Lihat Pengumuman
                                        </a>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class="fas fa-bullhorn font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                @endforeach
            </div>
        </div>

    </div>
</div>
