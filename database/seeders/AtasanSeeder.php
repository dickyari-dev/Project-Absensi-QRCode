<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AtasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert user and get its ID
        $userId = DB::table('users')->insertGetId([
            'name' => 'Atasan',
            'email' => 'atasan@gmail.com',
            'password' => Hash::make('atasan'),
            'role' => 'atasan',
        ]);

        // Create employee with the inserted user_id
        Employee::create([
            'user_id' => $userId,
            'name' => 'Atasan',
            'nip' => '1234567890',
            'pangkat' => 'Atasan',
            'gol_ruang' => 'Atasan',
            'jabatan' => 'Atasan',
            'status' => true,
            'foto' => 'default.jpg',
        ]);
    }
}
