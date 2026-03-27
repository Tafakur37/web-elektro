<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';

    protected $fillable = [
        'user_id',
        'nama_matkul',
        'tugas',
        'uts',
        'remedial_uts',
        'uas',
        'remedial_uas',
        'total_nilai',
        'grade',
        'dosen_id'
    ];

    protected $casts = [
        'tugas' => 'decimal:2',
        'uts' => 'decimal:2',
        'uas' => 'decimal:2',
        'total_nilai' => 'decimal:2',
        'remedial_uts' => 'boolean',
        'remedial_uas' => 'boolean',
    ];

    public static function calculateTotal($tugas, $uts, $remedialUts, $uas, $remedialUas)
    {
        $weightTugas = 0.2;
        $weightUts = 0.35;
        $weightUas = 0.45;

        $finalUts = $remedialUts ? $uts * 0.7 : $uts;
        $finalUas = $remedialUas ? $uas * 0.7 : $uas;

        $total = ($tugas * $weightTugas) + ($finalUts * $weightUts) + ($finalUas * $weightUas);
        
        return [
            'total' => round($total, 2),
            'grade' => self::getGrade($total)
        ];
    }

    public static function getGrade($total)
    {
        if ($total >= 90) return 'A';
        if ($total >= 80) return 'B';
        if ($total >= 70) return 'C';
        if ($total >= 60) return 'D';
        return 'E';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}

