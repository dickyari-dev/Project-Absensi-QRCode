<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportAbsensi implements FromView, WithMapping
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $bulan = request('bulan');
        $tahun = request('tahun');
        $users = User::where('role', 'pegawai')->with('attendances')->get();
        $absensi = Attendance::where('bulan', $bulan)->where('tahun', $tahun)->get();
        
        $tanggal = [];
        for ($i = 1; $i <= 31; $i++) {
            $tanggal[] = $i;
        }

        $absensiData = [];

        foreach ($users as $user) {
            $tgl = [];
            for ($i = 1; $i <= 31; $i++) {
                $tgl[$i] = $absensi->where('user_id', $user->id)->where('tanggal', $i)->where('bulan', $bulan)->where('tahun', $tahun)->first()->status ?? 'Absen';
            }
            $absensiData[] = [
                'id' => $user->id,
                'tanggal' => $tanggal,
                'nama' => $user->name,
                'nip' => $user->employee->nip,
                'pangkat' => $user->employee->pangkat,
                'gol.ruang' => $user->employee->gol_ruang,
                'status' => $tgl,
            ];
        }
        // dd($absensiData);

        return view('exports.absensi', compact('absensiData', 'bulan', 'tahun', 'users'));
    }

    public function map($absensi): array
    {
        return [$absensi->id, $absensi->tanggal];
    }
}
