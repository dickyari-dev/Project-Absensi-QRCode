<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi</title>
</head>

<body>
    @php
        if($bulan == 1){
            $bulanName = 'Januari';
        }elseif($bulan == 2){
            $bulanName = 'Februari';
        }elseif($bulan == 3){
            $bulanName = 'Maret';
        }elseif($bulan == 4){
            $bulanName = 'April';
        }elseif($bulan == 5){
            $bulanName = 'Mei';
        }elseif($bulan == 6){
            $bulanName = 'Juni';
        }elseif($bulan == 7){
            $bulanName = 'Juli';
        }elseif($bulan == 8){
            $bulanName = 'Agustus';
        }elseif($bulan == 9){
            $bulanName = 'September';
        }elseif($bulan == 10){
            $bulanName = 'Oktober';
        }elseif($bulan == 11){
            $bulanName = 'November';
        }elseif($bulan == 12){
            $bulanName = 'Desember';
        }
    @endphp
    <h1 style="text-align: center; width: 100%;"> Data Absensi</h1>
    <h5 style="text-align: center; width: 100%;"> {{ $bulanName }} - {{ $tahun }}</h5>
    <table>
        <thead>
            <tr class="">
                <th rowspan="2" style="text-align: center; font-weight: bold;">No
                </th>
                <!-- Kolom Nama dan NIP -->
                <th rowspan="2" style="text-align: center; font-weight: bold;">Nama
                </th>
                <th rowspan="2" style="text-align: center; font-weight: bold;">NIP
                </th>
                <th rowspan="2" style="text-align: center; font-weight: bold;">Pangkat
                </th>
                <th rowspan="2" style="text-align: center; font-weight: bold;">Gol. Ruang
                </th>
                <!-- Kolom Tanggal -->
                <th colspan="31" style="font-weight: bold;">
                    Tanggal</th>
            </tr>
            <tr>
                {{-- Tanggal 1-31 --}}
                @for ($i = 1; $i <= 31; $i++) <th style="text-align: center; font-weight: bold;">{{ $i }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td style="width: 50px; text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-transform: uppercase; width: 200px; text-align: center;">{{ $absensiData[$loop->index]['nama'] }}</td>
                <td style="text-transform: uppercase; width: 200px; text-align: center;">{{ $absensiData[$loop->index]['nip'] }}</td>
                <td style="text-transform: uppercase; width: 100px; text-align: center;">{{ $absensiData[$loop->index]['pangkat'] }}</td>
                <td style="text-transform: uppercase; width: 100px; text-align: center;">{{ $absensiData[$loop->index]['gol.ruang'] }}</td>
                @for ($i = 1; $i <= 31; $i++) 
                <td style="text-transform: uppercase; width: 100px; text-align: center;">
                    {{ $absensiData[$loop->index]['status'][$i] }}
                </td>
                @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>