<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'alasan',
        'berkas_path',
        'response_berkas_path',
        'staff_prodi_id',
    ];

    protected $casts = [
        'staff_prodi_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staffProdi()
    {
        return $this->belongsTo(User::class, 'staff_prodi_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeKadet($query)
    {
        return $query->whereHas('user', fn($q) => $q->where('role', 'kadet'));
    }
}


