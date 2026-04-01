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
        'kehadiran',
        'jumlah_hadir',
        'ips',
        'total_nilai',
        'grade',
        'dosen_id',
        'semester'
    ];

    protected $nullable = [
        'remedial_uts',
        'remedial_uas',
        'kehadiran',
        'ips'
    ];



    protected $casts = [
        'tugas' => 'decimal:2',
        'uts' => 'decimal:2',
        'uas' => 'decimal:2',
        'kehadiran' => 'decimal:2',
        'ips' => 'decimal:2',
        'total_nilai' => 'decimal:2',
'remedial_uts' => 'decimal:2',
        'remedial_uas' => 'decimal:2',
    ];

    public static function calculateIPS($tugas, $uts, $remedialUts, $uas, $remedialUas, $kehadiran = 100)
    {
        $weightTugas = 0.2;
        $weightUts = 0.35;
        $weightUas = 0.45;

        $finalUts = $remedialUts ?: $uts;
        $finalUas = $remedialUas ?: $uas;
        $nilaiAkhir = ($tugas * $weightTugas) + ($finalUts * $weightUts) + ($finalUas * $weightUas);
        $attendanceFactor = $kehadiran / 100;
        
        $ips = round($nilaiAkhir * $attendanceFactor, 2);
        
        return [
            'total_nilai' => $nilaiAkhir,
            'ips' => $ips,
            'grade' => self::getGrade($ips)
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

