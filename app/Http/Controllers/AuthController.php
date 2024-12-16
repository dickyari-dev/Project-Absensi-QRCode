<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $token = Token::latest()->first();
        $tokenCode = $token->token;
        return view('landing', compact('tokenCode'));
    }
    
    public function login() {
        return view('login');
    }

    public function absensi()
    {
        return view('absensi');
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // validate keterangan error
        $validator->setCustomMessages([
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()) {
                if (Auth::user()->role == 'operator') {
                    return redirect()->route('operator.dashboard');
                } elseif (Auth::user()->role == 'atasan') {
                    return redirect()->route('atasan.dashboard');
                } else {
                    return back()->with('error', 'Akun anda tidak memiliki akses ke halaman ini');
                }
            } else {
                return back()->with('error', 'Akun anda belum diaktifkan');
            }
        } else {
            return back()->with('error', 'Kombinasi email dan password tidak sesuai');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    // store absensi
    public function storeAbsensi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'nip' => 'required',
            'absensi' => 'required',
            'bukti_absensi' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10048',
        ]);
        
        // Ambil Data Pegawai
        $pegawai = Employee::where('nip', $request->nip)->first();
        if (!$pegawai) {
            return back()->with('error', 'NIP tidak ditemukan');
        } else {
            $user_id = $pegawai->user_id;
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek Apakah absensi nya ijin atau tugas
        if ($request->absensi == 'ijin' or $request->absensi == 'sakit' or $request->absensi == 'dinas') {
            if ($request->bukti_absensi == null) {
                return back()->with('error', 'Jika Anda memilih Dinas / Sakit / Izin, maka Bukti tidak boleh kosong');
            }
        }

        if ($request->bukti_absensi) {
            $bukti = $request->bukti_absensi;
            // Simpan bukti di direktori public/bukti
            $bukti->storeAs('public/bukti', $bukti->getClientOriginalName());
            $buktiName = $bukti->getClientOriginalName();
            $bukti = $buktiName;
        } else {
            $bukti = null;
        }

        // Cek Apakah absensi sudah ada
        $cekAbsensi = Attendance::where('user_id', $user_id)->where('tanggal', date('d'))->where('bulan', date('m'))->where('tahun', date('Y'))->first();
        if ($cekAbsensi) {
            return back()->with('error', 'Anda sudah absen hari ini');
        }

        $token = Token::latest()->first();
        if ($token->token == $request->token) {
            $absensi = new Attendance();
            $absensi->user_id = $user_id;
            $absensi->token = $request->token;
            $absensi->nip = $request->nip;
            $absensi->status = $request->absensi;
            $absensi->file = $bukti;
            $absensi->tanggal = date('d');
            $absensi->bulan = date('m');
            $absensi->tahun = date('Y');
            $absensi->save();

            $pegawai = Employee::where('nip', $request->nip)->first();
            $nama = $pegawai->name;
            return redirect()->route('index')->with('success', 'Haloo ' . $nama . ' Anda berhasil absen hari ini');
        } else {
            return back()->with('error', 'Qr code tidak valid');
        }
    }

    public function getPegawai($nip) {
        // Logic to fetch the employee data based on NIP
        $pegawai = Employee::where('nip', $nip)->first();
        if ($pegawai) {
            return response()->json([
                'nama' => $pegawai->name,
                'pangkat' => $pegawai->pangkat,
                'gol_ruang' => $pegawai->gol_ruang,
            ]);
        }
        return response()->json(['message' => 'Pegawai not found'], 404);
    }
}


