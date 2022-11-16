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
                    {{ $data_siswa->siswa->nama }}
                </td>
            </tr>
        </table>
        <p style="text-align: center">NISN/NIS:</p>
        <table class="center" style="border: 1px solid black; padding: 4px; width: 40%; margin-top: -10px;">
            <tr>
                <td style="text-align: center;">
                    {{ $data_siswa->siswa->nisn ?? '-' }} / {{ $data_siswa->siswa->nis ?? '-' }}
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
            <td style="width: 50%">: {{ $data_siswa->Siswa->nama }}</td>
            <td style="width: 20%;">Kelas</td>
            <td>: {{ $data_siswa->Kelas->kelas }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Nisn/nis</td>
            <td>: {{ $data_siswa->siswa->nisn ?? '-' }} / {{ $data_siswa->siswa->nis ?? '-' }}</td>
            <td style="width: 20%;">Fase</td>
            <td>: {{ RaportController::FaseKelas($data_siswa->Kelas->kelas) }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Sekolah</td>
            <td>: SDN Ardisaeng 01 Bondowoso</td>
            <td style="width: 20%;">Semester</td>
            <td>: {{ $data_siswa->Semester->nama_smester }}</td>
        </tr>
        <tr>
            <td style="width: 20%">Alamat</td>
            <td>: Bondowoso</td>
            <td style="width: 20%;">Tahun Pelajaran</td>
            <td>: {{ $data_siswa->TahunAjaran->tahun_ajaran }}</td>
        </tr>
    </table>
    <br>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;">No</th>
            <th class="border text-center">Mata Pelajaran</th>
            <th class="border text-center" style="width: 10%;">Nilai Akhir</th>
            <th class="border text-center">Capaian Kompetensi</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data_nilai as $items => $nilai)
            @php
                $grnerate_nilai = RaportController::GenerateNilai($nilai['nilai_total']);
                $gnerate_predikat = RaportController::GeneratePredikat($grnerate_nilai);
                $line_text = 'Ananda ' . $data_siswa->siswa->nama . ', ' . $gnerate_predikat . ' ';
            @endphp
            <tr>
                <td class="border text-center">{{ $no++ }}</td>
                <td class="border">{{ RaportController::GetNameMapel($items)->nama_mt }}</td>
                <td class="border text-center">{{ $nilai['nilai_total'] }}</td>
                <td class="border">{{ $line_text . $nilai['tujuan'] }}</td>
            </tr>
        @endforeach
    </table>

    <br>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;">No</th>
            <th class="border text-center">Ekstrakulikuler</th>
            <th class="border text-center">Keterangan</th>
        </tr>
        @php
            $no_start = 1;
        @endphp
        @if (count($data_ekskul) < 1)
            <tr>
                <td class="border text-center">1</td>
                <td class="border">.................</td>
                <td class="border">.................</td>
            </tr>
            <tr>
                <td class="border text-center">2</td>
                <td class="border">.................</td>
                <td class="border">.................</td>
            </tr>
            <tr>
                <td class="border text-center">3</td>
                <td class="border">.................</td>
                <td class="border">.................</td>
            </tr>
        @else
            @foreach ($data_ekskul as $key => $ekskul)
                @if ($ekskul->Ekskul != null)
                    <tr>
                        <td class="border text-center">{{ $key + 1 }}</td>
                        <td class="border">{{ $ekskul->Ekskul->nama_ekskul }}</td>
                        <td class="border">{{ $ekskul->keterangan }}</td>
                    </tr>
                @endif
            @endforeach
        @endif
    </table>

    <br>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <th class="border" style="width: 7%; text-align: center;" colspan="2">Ketidakhadiran</th>
            <td class="text-center" style="vertical-align: top;" rowspan="4">
                <p><b>Bondowoso, {{ $date }}</b></p>
                <br><br>
                <p>Nama Wali Kelas</p>
            </td>
        </tr>
        <tr>
            <td class="border" style="width: 25%;">Sakit</td>
            <td class="border text-center" style="width: 15%;">{{ $data_absensi['sakit'] }} hari</td>
        </tr>
        <tr>
            <td class="border">Ijin</td>
            <td class="border text-center">{{ $data_absensi['ijin'] }} hari</td>
        </tr>
        <tr>
            <td class="border">Tanpa Keterangan</td>
            <td class="border text-center">{{ $data_absensi['tanpa_keterangan'] }} hari</td>
        </tr>
    </table>

    <br><br><br><br>
    <table style="border-collapse: collapse; padding: 4px; width: 100%; margin-top: -10px; font-size: 13px;">
        <tr>
            <td class="text-center">
                <p><b>Wali Murid</b></p>
                <br><br>
                <p>Nama Wali Murid</p>
            </td>
            <td class="text-center">
                <p><b>Wali Kelas</b></p>
                <br><br>
                <p>Nama Wali Kelas</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <p><b>Kepala Sekolah</b></p>
                <br><br>
                <p>Nama Kepala Sekolah</p>
            </td>
        </tr>
    </table>


</body>

</html>
