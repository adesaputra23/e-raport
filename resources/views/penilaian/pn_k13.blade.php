{{-- Penilaian Kurikulum K13 --}}

<div class="row" id="form-pn-2013" style="display: none">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Type Penilaian: </h4>
                <div>
                    <div class="mb-2 mt-2">
                        <button class="btn btn-warning w-100" id="btn-2013-sikap">Sikap</button>
                    </div>
                    <div class="mb-2 mt-2">
                        <button class="btn btn-primary w-100" id="btn-2013-pengetahuan">Pengetahuan</button>
                    </div>
                    <div class="mb-2 mt-2">
                        <button class="btn btn-info w-100" id="btn-2013-keterampilan">Keterampilan</button>
                    </div>
                    <div class="mb-2 mt-2">
                        <button class="btn btn-secondary w-100" id="btn-2013-lain-lain">Lain-Lain</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">

        {{-- card default --}}
        <div class="card" id="default-2013" style="display: block; margin-bottom: 10px;">
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

    <!-- card penilaian sikap -->
    <div id="penilaian-sikap-2013" style="display: block;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penilaian Sikap</h4>
                <div class="table-responsive">
                    <div class="mb-2">
                        <p>Keterangan : </p>
                        <ul style="margin-top: -15px;">
                            <li><small><b>SB</b> : Sangat Baik</small></li>
                            <li><small><b>PB</b> : Cukup Baik</small></li>
                        </ul>
                    </div>
                    <table class="table table-bordered mb-0" style="width: 100%;">
                        <thead>
                            <tr class="text-center">
                                <th colspan="2" style="width: 10%;">Beribadah</th>
                                <th colspan="2" style="width: 10%;">Syukur</th>
                                <th colspan="2" style="width: 10%;">Berdo'a</th>
                                <th colspan="2" style="width: 10%;">Toleransi</th>
                                {{-- <th rowspan="2" class="mt-4">Deskripsi</th> --}}
                            </tr>
                            <tr class="text-center">
                                {{-- Beribadah --}}
                                <th>SB</th>
                                <th>PB</th>
                                {{-- Syukur --}}
                                <th>SB</th>
                                <th>PB</th>
                                {{-- Berdoa --}}
                                <th>SB</th>
                                <th>PB</th>
                                {{-- Toleransi --}}
                                <th>SB</th>
                                <th>PB</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">

                                <input type="hidden" name="id_pn_sikap" id="id_pn_sikap" value="">

                                {{-- Beribadah --}}
                                <th>
                                    <input class="form-check-input" type="radio" name="beribadah_formRadios"
                                        id="beribadah_formRadios1" value="Baik dalam beribadah">
                                </th>
                                <th>
                                    <input class="form-check-input" type="radio" name="beribadah_formRadios"
                                        id="beribadah_formRadios2" value="Cukup baik dalam beribadah">
                                </th>
                                {{-- Syukur --}}
                                <th>
                                    <input class="form-check-input" type="radio" name="syukur_formRadios"
                                        id="syukur_formRadios1" value="Baik dalam bersyukur">
                                </th>
                                <th>
                                    <input class="form-check-input" type="radio" name="syukur_formRadios"
                                        id="syukur_formRadios2" value="Cukup baik dalam bersyukur">
                                </th>
                                {{-- Berdoa --}}
                                <th>
                                    <input class="form-check-input" type="radio" name="berdoa_formRadios"
                                        id="berdoa_formRadios1" value="Baik dalam berdoa">
                                </th>
                                <th>
                                    <input class="form-check-input" type="radio" name="berdoa_formRadios"
                                        id="berdoa_formRadios2" value="Cukup baik dalam berdoa">
                                </th>
                                {{-- Toleransi --}}
                                <th>
                                    <input class="form-check-input" type="radio" name="toleransi_formRadios"
                                        id="toleransi_formRadios1" value="Baik dalam toleransi">
                                </th>
                                <th>
                                    <input class="form-check-input" type="radio" name="toleransi_formRadios"
                                        id="toleransi_formRadios2" value="Cukup baik dalam toleransi">
                                </th>
                                {{-- <th>
                                    <textarea name="desc_sikap" id="desc_sikap" rows="3" placeholder="Deskripsi" style="width: 100%;"></textarea>
                                </th> --}}
                            </tr>
                        </tbody>
                    </table>
                    <div class="float-end mt-4">
                        <button id="btn_save_sikap" name="btn_save_sikap" class="btn btn-success">Simpan</button>
                        <button class="btn btn-danger">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card penilaian pengetahuan -->
    <div id="penilaian-pengetahuan-2013" style="display: none;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penilaian Pengetahuan</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="tabel-pengetahuan">
                        <tbody>
                            <tr>
                                <th class="text-center">
                                    <p id="text-pengetahuan">Sedang Mengambil Data Penilaian Pengetahuan...</p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="float-end mt-4">
                        <button class="btn btn-success" id="btn_save_pengetahuan">Simpan</button>
                        <button class="btn btn-danger">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card penilaian keterampilan -->
    <div id="penilaian-keterampilan-2013" style="display: none;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penilaian Keterampilan</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="tabel-keterampilan">
                        <tbody>
                            <tr>
                                <th class="text-center">
                                    <p id="text-keterampilan">Sedang Mengambil Data Penilaian Ketrampilan...</p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="float-end mt-4">
                        <button class="btn btn-success" id="btn_save_keterampilan">Simpan</button>
                        <button class="btn btn-danger">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card penilaian lain-lain -->
    <div id="penilaian-lain-lain-2013" style="display: block;">

        {{-- ekstrakulikuler --}}
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-body">
                <h4 class="card-title">Ekstrakulikuler</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="tabel-ekskul">
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

        {{-- saran --}}
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-body">
                <h4 class="card-title">Saran - Saran</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="hidden" id="id_saran_saran" name="id_saran_saran">
                                    <textarea type="text" id="saran-saran" name="saran-saran" class="form-control form-control-sm" rows="6"
                                        placeholder="Saran - Saran"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- tinggi dan berat badan --}}
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-body">
                <h4 class="card-title">Tinggi dan Berat Badan</h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <input type="hidden" name="id_tinggi_dan_berat_badan"
                                    id="id_tinggi_dan_berat_badan">
                                <th>
                                    <p>Tinggi Badan</p>
                                </th>
                                <td style="width: 20%">
                                    <input type="text" name="tinggi-badan" id="tinggi-badan"
                                        class="form-control form-control-sm" placeholder="Nilai" required>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p>Berat Badan</p>
                                </th>
                                <td style="width: 20%">
                                    <input type="text" name="berat-badan" id="berat-badan"
                                        class="form-control form-control-sm" placeholder="Nilai" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- kondisi kesehatan --}}
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-body">
                <h4 class="card-title">Kondisi Kesehatan</h4>
                <div class="table-responsive">
                    <button class="btn btn-sm btn-success mb-2" name="btn-add-kesehatan"
                        id="btn-add-kesehatan">Tambah</button>
                    <table class="table table-bordered mb-0" id="tabel-kondi-kesahatan">
                        <tbody>
                            <tr>
                                <th>
                                    <p>Mengambil data...</p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive" id="add-tabel">
                </div>
            </div>
        </div>

        {{-- Prestasi --}}
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-body">
                <h4 class="card-title">Prestasi</h4>
                <div class="table-responsive">
                    <button class="btn btn-sm btn-success mb-2" name="btn-add-prestasi"
                        id="btn-add-prestasi">Tambah</button>
                    <table class="table table-bordered mb-0" id="tabel-prestasi">
                        <tbody>
                            <tr>
                                <th style="width: 30%">
                                    <input type="text" name="prestasi" id="prestasi"
                                        class="form-control form-control-sm" placeholder="Prestasi" required>
                                </th>
                                <td>
                                    <textarea type="text" name="ket-prestasi" id="ket-prestasi" class="form-control form-control-sm" rows="3"
                                        placeholder="Keterangan" required></textarea>
                                </td>
                                <td style="width: 10%">
                                    <button class="btn btn-sm btn-danger mb-2" name="btn-remove-prestasi"
                                        id="btn-remove-prestasi">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive" id="add-tabel-prestasi">
                    </div>
                </div>
            </div>
        </div>

        {{-- btn save --}}
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-4">
                    <button class="btn btn-success" id="btn-save-lain-lain" name="btn-save-lain-lain">Simpan</button>
                    <button class="btn btn-danger">Batal</button>
                </div>
            </div>
        </div>

    </div>

</div>
