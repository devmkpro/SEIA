<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Teacher\TeachersSubjects;


class TeachersSchedules extends Model
{
    use HasFactory;

    protected $table = "teachers_subjects_schedules";
    protected $primaryKey = "uuid";
    public $incrementing = false;

    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    protected $fillable = [
        "uuid",
        "day",
        "start_time",
        "end_time",
        "total_hours",
        "subject_uuid",
        "teacher_subject_uuid",
        "user_uuid",
    ];

    /**
     * Get the teacher subject that owns the schedule.
     */

    public function teacher_subject()
    {
        return $this->belongsTo(TeachersSubjects::class, "teacher_subject_uuid", "uuid");
    }
}
