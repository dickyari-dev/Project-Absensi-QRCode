<?php

namespace App\Http\Controllers;

use App\Exports\ExportAbsensi;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AtasanController extends Controller
{
    public function dashboard()
    {
        return view('atasan.dashboard');
    }

    public function dataKaryawan()
    {
        $dataPegawai = User::where('role', 'pegawai')->get();
        $employee = Employee::all();

        return view('atasan.data-pegawai', compact('dataPegawai', 'employee'));
    }

    public function dataAbsensi()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $users = User::where('role', 'pegawai')->with('attendances')->get();
    
        $filteredAttendances = Attendance::all()
            ->groupBy('user_id');
        return view('atasan.data-absensi', compact('users', 'filteredAttendances', 'bulan', 'tahun'));
    }
    public function downloadExcel($bulan, $tahun)
    {
        $users = User::where('role', 'pegawai')->with('attendances')->get();
        $absensi = Attendance::where('bulan', $bulan)->where('tahun', $tahun)->get();


        // Attempt to download the Excel file
        return Excel::download(new ExportAbsensi($bulan, $tahun), 'Absensi.xlsx');
    }

    public function downloadPdf($bulan, $tahun)
    {
        $users = User::where('role', 'pegawai')->with('attendances')->get();
        $filteredAttendances = Attendance::all()
        ->groupBy('user_id');

        $pdf = Pdf::loadView('exports.absensi-pdf', compact('bulan', 'tahun', 'users', 'filteredAttendances'))
        ->setPaper([0, 0, 1300, 1300], 'landscape')
            ->setOptions(['margin-left' => 5, 'margin-right' => 5, 'margin-top' => 5, 'margin-bottom' => 5]);
        return $pdf->download('Absensi.pdf');
    }
}
