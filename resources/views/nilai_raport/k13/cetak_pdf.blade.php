<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Raport</title>
</head>

<style>
    img.logo-tutwury-tengah {
        /* display: block; */
        margin-left: auto;
        margin-right: auto;
        width: 45%;
    }

    .center {
        margin-left: auto;
        margin-right: auto;
    }

    .new-page {
        display: block;
        clear: both;
        page-break-after: always;
    }

    table.border,
    th.border,
    td.border {
        border: 1px solid black;
        padding: 6px;
    }

    .text-center {
        text-align: center;
    }
</style>

@php
    use App\Http\Controllers\RaportController;
    $date = date('d M Y');
@endphp

<body>
    <div>
        <center>
            <p><b>RAPORT SISWA</b></p>
            <p style="margin-top: -15px;"><b>SDN ARDISAENG 01 BONDOWOSO</b></p>

            <br><br><br><br><br><br><br><br><br><br>
            <img class="logo-tutwury-tengah" src="{{ storage_path('app/public/tutwury.jpeg') }}" alt="">
        </center>
    </div>
    <br><br><br><br><br><br><br>
    <div>
        <p style="text-align: center">Nama Peserta Didik:</p>
        <table class="center" style="border: 1px solid black; padding: 4px; width: 40%; margin-top: -10px;">
            <tr>
                <td style="text-align: center;">
                    {{ $data_siswa->Siswa->nama }}
                </td>
            </tr>
        </table>
        <p style="text-align: center">NISN/NIS:</p>
        <table class="center" style="border: 1px solid black; padding: 4px; width: 40%; margin-top: -10px;">
            <tr>
                <td style="text-align: center;">
                    {{ $data_siswa->Siswa->nisn ?? '-' }} /
                    {{ $data_siswa->siswa->nis ?? '-' }}
                </td>
            </tr>
        </table>
    </div>

    {{-- is new page --}}
    <div class="new-page"></div>
    <p style="text-align: center;"><b>RAPOR PESERTA DIDIK DAN PROFIL PESERTA DIDIK</b></p>
    <br>
    <table style="border: 0px solid black; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <td style="width: 20%">Nama Peserta Didik</td>
            <td style="width: 50%">: {{ $data_siswa->nama_siswa }}</td>
            <td style="width: 20%;">Kelas</td>
            <td>: {{ $data_siswa->kelas->kelas }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Nisn/nis</td>
            <td>: {{ $data_siswa->Siswa->nisn ?? '-' }} /
                {{ $data_siswa->siswa->nis ?? '-' }}</td>
            <td style="width: 20%;">Semester</td>
            <td>: {{ $data_siswa->Semester->nama_smester }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Sekolah</td>
            <td>: SDN Ardisaeng 01 Bondowoso</td>
            <td style="width: 20%;">Tahun Pelajaran</td>
            <td>: {{ $data_siswa->TahunAjaran->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Alamat</td>
            <td>: Bondowoso</td>
        </tr>
    </table>
    <p><b>A. Nilai Sikap</b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;" colspan="2">Deskripsi</th>
        </tr>
        @php
            $no = 1;
        @endphp
        <tr>
            <th class="border" style="text-align: left; width: 30%">Sikap Spiritual</th>
            <td class="border">{{ $data_pn_sikap->desc_pn }}</td>
        </tr>
        <tr>
            <th class="border" style="text-align: left; width: 30%">Sikap Sosial</th>
            <td class="border">
                {{ 'Ananda ' . $data_siswa->nama_siswa . ' sangat jujur, percaya diri dan sudah mampu meningkatkan sikap disiplin.' }}
            </td>
        </tr>
    </table>
    <p><b>B. Pengetahuan dan Keterampilan <br> KKM Satuan Pendidikan : 70 </b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border text-center" rowspan="2">No</th>
            <th class="border text-center" rowspan="2">Muatan Pelajaran</th>
            <th class="border text-center" colspan="3">Pengetahuan</th>
            <th class="border text-center" colspan="3">Keterampilan</th>
        </tr>
        <tr>
            <th class="border">Nilai</th>
            <th class="border">Predikat</th>
            <th class="border text-center">Deskripsi</th>
            <th class="border">Nilai</th>
            <th class="border">Predikat</th>
            <th class="border text-center">Deskripsi</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data_nilai[0] as $items => $value)
            @php
                $converter_nilai_pengetahuan = RaportController::GenerateNilai(Str::substr($data_nilai[2][$items] ?? '-', 0, 2));
                $converter_nilai_keterampilan = RaportController::GenerateNilai(Str::substr($value, 0, 2));
            @endphp
            <tr>
                <td class="border">{{ $no++ }}</td>
                <td class="border">{{ RaportController::GetNameMapel($items)->nama_mt }}</td>
                <td class="border text-center">
                    {{ Str::substr($data_nilai[2][$items] ?? '-', 0, 2) ?? '-' }}
                </td>
                <td class="border text-center">
                    {{ $converter_nilai_pengetahuan }}
                </td>
                <td class="border" style="width: 20%;">
                    @php
                        $conversi_a = Str::substr($data_nilai[2][$items] ?? '-', 0, 2);
                        $retVal_a = RaportController::GeneratePredikat($converter_nilai_pengetahuan);
                    @endphp
                    @foreach ($data_nilai[3][$items] as $it)
                        @if ($conversi_a != 0)
                            {{ 'Ananda ' . $data_siswa->Siswa->nama . ' ' . $retVal_a . ', ' . implode(',', $it) }}
                        @else
                            -
                        @endif
                        @php
                            break;
                        @endphp
                    @endforeach
                </td>
                <td class="border text-center">{{ Str::substr($value, 0, 2) }}</td>
                <td class="border text-center">{{ $converter_nilai_keterampilan }}
                </td>
                <td class="border" style="width: 20%;">
                    @php
                        $conversi = Str::substr($value, 0, 2);
                        $retVal = RaportController::GeneratePredikat($converter_nilai_keterampilan);
                    @endphp
                    @foreach ($data_nilai[1][$items] as $item)
                        @if ($conversi != 0)
                            {{ 'Ananda ' . $data_siswa->Siswa->nama . ' ' . $retVal . ', ' . implode(',', $item) }}
                        @else
                            -
                        @endif
                        @php
                            break;
                        @endphp
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>
    <p><b>C. Ekstrakurikuler</b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;">No</th>
            <th class="border text-center">Kegiatan Ekstrakurikuler</th>
            <th class="border text-center">Keterangan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data_ekskul as $item => $ekskul)
            <tr>
                <td class="border text-center">{{ $item + 1 }}</td>
                <td class="border">{{ $ekskul->Ekskul->nama_ekskul }}</td>
                <td class="border">{{ $ekskul->keterangan }}</td>
            </tr>
        @endforeach
    </table>
    <p><b>D. Saran - Saran</b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <td class="border" style="padding: 15px;">{{ $data_saran->saran }}</td>
        </tr>
    </table>
    <div class="new-page"></div>
    <p><b>E. Tinggi Dan Berat Badan</b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;" rowspan="2">No</th>
            <th class="border text-center" rowspan="2">Aspek yang di nilai</th>
            <th class="border" colspan="2">Semester</th>
        </tr>
        <tr>
            <th class="border text-center">1</th>
            <th class="border text-center">2</th>
        </tr>
        @php
            $no = 1;
        @endphp
        <tr>
            <td class="border text-center">1</td>
            <td class="border">Tinggi Badan</td>
            @if ($data_TBdanBB['smt_1'] != null)
                <td class="border text-center">{{ $data_TBdanBB['smt_1']->tinggi_badan . ' cm' }}</td>
            @else
                <td class="border text-center">{{ '-' }}</td>
            @endif
            @if ($data_TBdanBB['smt_2'] != null)
                <td class="border text-center">{{ $data_TBdanBB['smt_2']->tinggi_badan . ' cm' }}</td>
            @else
                <td class="border text-center">{{ '-' }}</td>
            @endif
        </tr>
        <tr>
            <td class="border text-center">2</td>
            <td class="border">Berat Badan</td>
            @if ($data_TBdanBB['smt_1'] != null)
                <td class="border text-center">{{ $data_TBdanBB['smt_1']->berat_badan . ' cm' }}</td>
            @else
                <td class="border text-center">{{ '-' }}</td>
            @endif
            @if ($data_TBdanBB['smt_2'] != null)
                <td class="border text-center">{{ $data_TBdanBB['smt_2']->berat_badan . ' cm' }}</td>
            @else
                <td class="border text-center">{{ '-' }}</td>
            @endif
        </tr>
    </table>
    <p><b>F. Kondisi Kesehatan</b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;">No</th>
            <th class="border text-center">Aspek Fisik</th>
            <th class="border text-center">Keterangan</th>
        </tr>
        @php
            $no_ks = 1;
        @endphp
        @foreach ($data_kodisi_kesehatan as $item => $kondisi_kesehatan)
            <tr>
                <td class="border text-center">{{ $no_ks++ }}</td>
                <td class="border">{{ $kondisi_kesehatan->kondisi }}</td>
                <td class="border">{{ $kondisi_kesehatan->ket_kondisi }}</td>
            </tr>
        @endforeach
    </table>
    <p><b>G. Prestasi</b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;">No</th>
            <th class="border text-center">Jenis Prestasi</th>
            <th class="border text-center">Keterangan</th>
        </tr>
        @php
            $no_prst = 1;
        @endphp
        @foreach ($data_prestasi as $item => $prestasi)
            <tr>
                <td class="border text-center">{{ $no_prst++ }}</td>
                <td class="border">{{ $prestasi->prestasi }}</td>
                <td class="border">{{ $prestasi->ket_prestasi }}</td>
            </tr>
        @endforeach
    </table>
    <p><b>H. Ketidakhadiran</b></p>
    <table style="border-collapse: collapse; padding: 4px; width: 50%; margin-top: -10px; font-size: 13px;">
        <tr>
            <td class="border">Sakit</td>
            <td class="border text-center">{{ $data_absensi['sakit'] }} hari</td>
        </tr>
        <tr>
            <td class="border">Izin</td>
            <td class="border text-center">{{ $data_absensi['ijin'] }} hari</td>
        </tr>
        <tr>
            <td class="border">Tanpa keterangan</td>
            <td class="border text-center">{{ $data_absensi['tanpa_keterangan'] }} hari</td>
        </tr>
    </table>
    <br><br><br><br>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <td style="width: 6%;"></td>
            <td style="width: 65%;">
                <p><b>Mengetahui, <br>Orangtua/Wali Murid</b></p>
                <br><br><br>
                <hr style="border: 0.3px solid black; display: block; float: left;" width="30%">
                <p></p>
            </td>
            <td>
                <p><b>Bondowoso, {{ date('d M Y') }}<br>Wali Kelas</b></p>
                <br><br><br>
                <hr style="border: 0.3px solid black; float: left;" width="80%">
                <br>
                <p style="margin-top: -5px;">NIP.000000000 </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center">
                <p><b>Mengetahui <br> Kepala Sekolah</b></p>
                <br><br>
                <hr style="border: 0.3px solid black; display: block;" width="30%">
                <p style="margin-top: -5px; margin-left: -125px;">NIP.000000000</p>
            </td>
        </tr>
    </table>
</body>

</html>
