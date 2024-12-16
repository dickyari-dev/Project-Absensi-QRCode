@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Data Absensi</h5>
                <div class="row">
                    <div class="col-md-4">
                        <select name="bulan" id="bulan" class="form-select" onchange="filterData(this.value)">
                            <option value="1" {{ request('bulan', $bulan) == '1' ? 'selected' : '' }}   >Januari</option>
                            <option value="2" {{ request('bulan', $bulan) == '2' ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ request('bulan', $bulan) == '3' ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ request('bulan', $bulan) == '4' ? 'selected' : '' }}>April</option>
                            <option value="5" {{ request('bulan', $bulan) == '5' ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ request('bulan', $bulan) == '6' ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ request('bulan', $bulan) == '7' ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ request('bulan', $bulan) == '8' ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ request('bulan', $bulan) == '9' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('bulan', $bulan) == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('bulan', $bulan) == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('bulan', $bulan) == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="tahun" id="tahun" class="form-select" onchange="filterData(this.value)">
                            <option value="2024" {{ request('tahun', $tahun) == '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ request('tahun', $tahun) == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ request('tahun', $tahun) == '2026' ? 'selected' : '' }}>2026</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <a href="{{ route('operator.data-absensi.download.excel', ['bulan' => request('bulan', $bulan), 'tahun' => request('tahun', $tahun)]) }}"
                            class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Download Excel</a>
                            </div>
                            <div class="col-12 mb-2">
                                <a href="{{ route('operator.data-absensi.download.pdf', ['bulan' => request('bulan', $bulan), 'tahun' => request('tahun', $tahun)]) }}"
                            class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="">
                                    <th rowspan="2" class="sticky-top" style="background-color: white; z-index: 2;">No
                                    </th>
                                    <!-- Kolom Nama dan NIP -->
                                    <th rowspan="2" class="sticky-top" style="background-color: white; z-index: 2;">Nama
                                    </th>
                                    <th rowspan="2" class="sticky-top" style="background-color: white; z-index: 2;">NIP
                                    </th>
                                    <!-- Kolom Tanggal -->
                                    <th colspan="31" class="sticky-top" style="background-color: white; z-index: 1;">
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
                                        request('bulan', $bulan))->where('tahun', request('tahun', $tahun))->first();
                                        $status = $attendance ? $attendance->status : 'Absen';
                                        @endphp
                                        @if ($status == 'masuk')
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $user->id }}-{{ $i }}">
                                            <span class="badge bg-success">Masuk</span>
                                        </button>
                                        <div class="modal fade" id="modal-{{ $user->id }}-{{ $i }}" tabindex="-1"
                                            aria-labelledby="modal-{{ $user->id }}-{{ $i }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>Nama</td>
                                                                <td>{{ $user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>NIP</td>
                                                                <td>{{ $user->employee->nip }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Status Absen</td>
                                                                <td>{{ $attendance->status }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Waktu Absen</td>
                                                                <td>{{ $attendance->created_at->format('H:i:s') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bukti Absen</td>
                                                                <td>
                                                                    @if ($attendance->file)
                                                                    <a href="{{ asset('storage/bukti/' . $attendance->file) }}"
                                                                        target="_blank" class="btn btn-link">
                                                                        Lihat Bukti
                                                                    </a>
                                                                    @else
                                                                    <span class="badge bg-danger">Belum ada bukti
                                                                        absen</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif ($status == 'izin')
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $user->id }}-{{ $i }}">
                                            <span class="badge bg-warning">Izin</span>
                                        </button>
                                        <div class="modal fade" id="modal-{{ $user->id }}-{{ $i }}" tabindex="-1"
                                            aria-labelledby="modal-{{ $user->id }}-{{ $i }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Absensi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>Nama</td>
                                                                <td>{{ $user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>NIP</td>
                                                                <td>{{ $user->employee->nip }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Status Absen</td>
                                                                <td>{{ $attendance->status }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Waktu Absen</td>
                                                                <td>{{ $attendance->created_at->format('H:i:s') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bukti Absen</td>
                                                                <td>
                                                                    @if ($attendance->file)
                                                                    <a href="{{ asset('storage/bukti/' . $attendance->file) }}"
                                                                        target="_blank" class="btn btn-link">
                                                                        Lihat Bukti
                                                                    </a>
                                                                    @else
                                                                    <span class="badge bg-danger">Belum ada bukti
                                                                        absen</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif ($status == 'sakit')
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $user->id }}-{{ $i }}">
                                            <span class="badge bg-warning">Sakit</span>
                                        </button>
                                        <div class="modal fade" id="modal-{{ $user->id }}-{{ $i }}" tabindex="-1"
                                            aria-labelledby="modal-{{ $user->id }}-{{ $i }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Absensi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>Nama</td>
                                                                <td>{{ $user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>NIP</td>
                                                                <td>{{ $user->employee->nip }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Status Absen</td>
                                                                <td>{{ $attendance->status }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Waktu Absen</td>
                                                                <td>{{ $attendance->created_at->format('H:i:s') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bukti Absen</td>
                                                                <td>
                                                                    @if ($attendance->file)
                                                                    <a href="{{ asset('storage/bukti/' . $attendance->file) }}"
                                                                        target="_blank" class="btn btn-link">
                                                                        Lihat Bukti
                                                                    </a>
                                                                    @else
                                                                    <span class="badge bg-danger">Belum ada bukti
                                                                        absen</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif ($status == 'dinas')
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $user->id }}-{{ $i }}">
                                            <span class="badge bg-warning">Dinas</span>
                                        </button>
                                        <div class="modal fade" id="modal-{{ $user->id }}-{{ $i }}" tabindex="-1"
                                            aria-labelledby="modal-{{ $user->id }}-{{ $i }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Absensi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>Nama</td>
                                                                <td>{{ $user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>NIP</td>
                                                                <td>{{ $user->employee->nip }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Status Absen</td>
                                                                <td>{{ $attendance->status }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Waktu Absen</td>
                                                                <td>{{ $attendance->created_at->format('H:i:s') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bukti Absen</td>
                                                                <td>
                                                                    @if ($attendance->file)
                                                                    <a href="{{ asset('storage/bukti/' . $attendance->file) }}"
                                                                        target="_blank" class="btn btn-link">
                                                                        Lihat Bukti
                                                                    </a>
                                                                    @else
                                                                    <span class="badge bg-danger">Belum ada bukti
                                                                        absen</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $user->id }}-{{ $i }}">
                                            <span class="badge bg-danger">Absen</span>
                                        </button>
                                        <div class="modal fade" id="modal-{{ $user->id }}-{{ $i }}" tabindex="-1"
                                            aria-labelledby="modal-{{ $user->id }}-{{ $i }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Absensi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tidak ada data absensi</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@endsection

@section('script')
<script>
    function filterData(bulan) {
        // ubah url dengan bulan dan tahun yang dipilih
        var tahun = document.getElementById('tahun').value; // Ambil tahun yang dipilih
        window.location.href = "{{ route('operator.data-absensi') }}?bulan=" + bulan + "&tahun=" + tahun; // Tambahkan tahun ke URL

        // Ubah attendance
        var attendance = document.querySelectorAll('.attendance');
        attendance.forEach(function(item) {
            item.style.display = 'none';
        });
    }
</script>
@endsection