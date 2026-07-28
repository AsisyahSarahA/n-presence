<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'time_in',
        'time_out',
        'status',
        'late_duration_minutes',
        'scanned_by',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relasi: Absensi merujuk ke satu Siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Relasi: Absensi dicatat oleh/scanned by Guru/User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
