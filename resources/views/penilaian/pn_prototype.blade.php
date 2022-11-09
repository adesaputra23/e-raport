{{-- Penilaian Kurikulum Prototipe --}}

<div class="row" id="form-pn-2022" style="display: none;">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Type Penilaian: </h4>
                <p>Penilaian menggunakan format Kurikulum Prototype/2022.</p>
                <div>
                    <div class="mb-2 mt-2">
                        <button class="btn btn-warning w-100" id="btn-penilaian-for-sum">Sumatif & Formatif</button>
                    </div>
                    <div class="mb-2 mt-2">
                        <button class="btn btn-primary w-100" id="btn-penilaian-ekskul-2022">Ekskul</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        {{-- card default --}}
        <div class="card" id="default-2022" style="display: block; margin-bottom: 10px;">
            <div class="card-body">
                <h4 class="card-title">Data Siswa:</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <input type="hidden" name="sw-nisn" id="sw-nisn" value="">
                            <input type="hidden" name="kelas" id="kelas" value="">

                            <tr>
                                <th scope="row" style="width: 20%;">NISN/NIS</th>
                                <td id="nisn-siswa"></td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Siswa</th>
                                <td id="nama-siswa"></td>
                            </tr>
                            <tr>
                                <th scope="row">Kelas</th>
                                <td id="kelas-siswa"></td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis Kelamin</th>
                                <td id="jk-siswa"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- card penilaian pengetahuan -->
    <div id="penilaian-for-sum-2022" style="display: none;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penilaian Formatif & SUmatif</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="tabel-for-sum">
                        <tbody>
                            <tr>
                                <th class="text-center">
                                    <p id="text-for-sum">Sedang Mengambil Data Penilaian Formatif & Sumatif...</p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="float-end mt-4">
                        <button class="btn btn-success" id="btn_save_for_sum">Simpan</button>
                        <button class="btn btn-danger">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card penilaian lain-lain -->
    <div id="penilaian-ekskul-2022" style="display: block;">
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-body">
                <h4 class="card-title">Ekstrakulikuler</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="tabel-ekskul-2022">
                        <tbody>
                            <tr>
                                <th>
                                    <p>Mengambil data...</p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- btn save --}}
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-4">
                    <button class="btn btn-success" id="btn-save-ekskul-2022"
                        name="btn-save-ekskul-2022">Simpan</button>
                    <button class="btn btn-danger">Batal</button>
                </div>
            </div>
        </div>

    </div>


</div>
