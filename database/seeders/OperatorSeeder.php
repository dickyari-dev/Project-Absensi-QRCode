<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert user and get its ID
        $userId = DB::table('users')->insertGetId([
            'name' => 'Operator',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('operator'),
            'role' => 'operator',
        ]);

        // Create employee with the inserted user_id
        Employee::create([
            'user_id' => $userId,
            'name' => 'Operator',
            'nip' => '1234567890',
            'pangkat' => 'Operator',
            'gol_ruang' => 'Operator',
            'jabatan' => 'Operator',
            'status' => true,
            'foto' => 'default.jpg',
        ]);
    }
}
