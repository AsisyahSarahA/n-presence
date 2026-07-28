<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory;

    // Mapping manual karena nama Model ClassRoom merujuk ke tabel 'classes'
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'academic_year_id',
        'homeroom_teacher',
    ];

    /**
     * Relasi: Kelas merujuk ke satu Tahun Ajaran.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    /**
     * Relasi: Satu Kelas memiliki banyak Siswa.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
