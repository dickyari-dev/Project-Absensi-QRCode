<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $fillable = ['user_id', 'token', 'nip', 'status', 'file', 'tanggal', 'bulan', 'tahun'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
