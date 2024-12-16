<?php

namespace App\Http\Controllers;

use App\Exports\ExportAbsensi;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Token;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OperatorController extends Controller
{
    public function dashboard()
    {
        $token = Token::latest()->first();
        $qrCode = QrCode::size(150)->generate($token->token);
        $tokenCode = $token->token;
        return view('operator.dashboard', compact('token', 'qrCode', 'tokenCode'));
    }

    public function dataPegawai()
    {
        $dataPegawai = User::where('role', 'pegawai')->get();
        $employee = Employee::all();

        return view('operator.data-pegawai', compact('dataPegawai', 'employee'));
    }

    public function storePegawai(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'nip' => 'required|unique:employees',
            'pangkat' => 'required',
            'gol_ruang' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // Generate filename
            $filename = time() . '.' . $photo->getClientOriginalExtension();

            // Simpan file ke dalam storage/app/public/images/pegawai
            $path = $photo->storeAs('public/images/pegawai', $filename);

            // Simpan nama file ke dalam database
            $image = 'images/pegawai/' . $filename; // Simpan path relatif        }

            $employee = Employee::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'nip' => $request->nip,
                'pangkat' => $request->pangkat,
                'gol_ruang' => $request->gol_ruang,
                'jabatan' => 'Pegawai',
                'status' => '1',
                'foto' => $image,
            ]);


            return redirect()->route('operator.data-pegawai')->with('success', 'Pegawai berhasil ditambahkan');
        }
    }

    public function updatePegawai(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:employees,nip,' . $request->id,
            'pangkat' => 'required',
            'gol_ruang' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|min:8',
        ]);
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $employee = Employee::find($request->id);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('public/images/pegawai', $filename);
            $image = 'images/pegawai/' . $filename;
            $employee->foto = $image;
        }
        $employee->name = $request->name;
        $employee->nip = $request->nip;
        $employee->pangkat = $request->pangkat;
        $employee->gol_ruang = $request->gol_ruang;
        $employee->save();

        return redirect()->route('operator.data-pegawai')->with('success', 'Pegawai berhasil diupdate');
    }

    public function deletePegawai($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('operator.data-pegawai')->with('success', 'Pegawai berhasil dihapus');
    }

    // generate qr code
    public function generateQrCode()
    {

        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = substr(str_shuffle(str_repeat($pool, 5)), 0, 30);

        // Delete old token
        Token::truncate();

        $token = Token::create([
            'token' => $token,
        ]);

        return redirect()->route('operator.dashboard')->with('success', 'Qr Code berhasil Diperbarui');
    }

    public function dataAbsensi()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $users = User::where('role', 'pegawai')->with('attendances')->get();
    
        $filteredAttendances = Attendance::all()
            ->groupBy('user_id');
    
        return view('operator.data-absensi', compact('users', 'filteredAttendances', 'bulan', 'tahun'));
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

