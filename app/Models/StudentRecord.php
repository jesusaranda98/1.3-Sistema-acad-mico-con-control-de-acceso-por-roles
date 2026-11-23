<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_name',
        'absences',
        'grade',
    ];

    protected function casts(): array
    {
        return [
            'absences' => 'integer',
            'grade' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getEquivalenceCodeAttribute(): string
    {
        $grade = (float) $this->grade;

        if ($grade < 6.0) {
            return 'NA';
        }

        if ($grade < 7.5) {
            return 'SA';
        }

        if ($grade < 9.0) {
            return 'DE';
        }

        return 'AU';
    }

    public function getEquivalenceLabelAttribute(): string
    {
        return match ($this->equivalence_code) {
            'NA' => 'No Acreditado',
            'SA' => 'Suficiente',
            'DE' => 'Destacado',
            'AU' => 'Autónomo',
            default => 'No Acreditado',
        };
    }
}