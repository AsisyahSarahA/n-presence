<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'parent_name',
        'parent_phone',
        'status_type',
        'start_date',
        'end_date',
        'notes',
        'attachment',
        'approval_status',
        'approved_by',
        'rejected_reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
