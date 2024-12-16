<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Absensi</title>

</head>

<body>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    @php
                    $bulan = date('F', mktime(0, 0, 0, $bulan, 10));
                    @endphp
                    <h1 class="text-center" style="text-align: center;">Data Absensi {{ $bulan }} {{ $tahun }}</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="">
                                        <th rowspan="2" width="50px">No
                                        </th>
                                        <!-- Kolom Nama dan NIP -->
                                        <th rowspan="2" width="100px">Nama
                                        </th>
                                        <th rowspan="2" width="100px">NIP
                                        </th>
                                        <!-- Kolom Tanggal -->
                                        <th colspan="31">
                                            Tanggal</th>
                                    </tr>
                                    <tr>
                                        {{-- Tanggal 1-31 --}}
                                        @for ($i = 1; $i <= 31; $i++) <th>{{ $i }}</th>
                                            @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Contoh Data --}}
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->employee->nip }}</td>
                                        @for ($i = 1; $i <= 31; $i++) <td>
                                            @php
                                            $attendance = $user->attendances->where('tanggal', $i)->where('bulan',
                                            request('bulan', $bulan))->where('tahun', request('tahun',
                                            $tahun))->first();
                                            $status = $attendance ? $attendance->status : 'Absen';
                                            @endphp
                                            @if ($status == 'masuk')
                                            <span class="badge bg-success">Masuk</span>
                                            @elseif ($status == 'izin')
                                            <span class="badge bg-warning">Izin</span>
                                            @elseif ($status == 'sakit')
                                            <span class="badge bg-warning">Sakit</span>
                                            @elseif ($status == 'dinas')
                                            <span class="badge bg-warning">Dinas</span>
                                            @else
                                            <span class="badge bg-danger">Absen</span>
                                            @endif
                                            </td>
                                            @endfor
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>