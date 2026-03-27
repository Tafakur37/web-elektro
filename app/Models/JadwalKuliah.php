<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kuliah';

    protected $fillable = [
        'semester',
        'mata_kuliah',
        'dosen',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruang',
        'cohort'
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];
}
