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
        'is_admin_override',
        'notes',
        'attachment',
    ];

    protected $casts = [
        'date' => 'date',
        'is_admin_override' => 'boolean',
    ];

    /**
     * Accessor untuk menentukan status efektif absensi (terutama untuk Laporan).
     * Siswa dihitung HADIR/TERLAMBAT hanya jika sudah scan pulang (time_out != null)
     * atau telah di-override secara manual oleh Admin.
     */
    public function getEffectiveStatusAttribute(): string
    {
        if (in_array($this->status, ['Hadir', 'Terlambat'])) {
            if ($this->time_out === null && !$this->is_admin_override) {
                return 'Alpa';
            }
        }

        return $this->status ?? 'Alpa';
    }

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
