<?php

namespace App\Models\Classes;

use App\Models\Curriculum\Curriculum;
use App\Models\Room\Rooms;
use App\Models\School\School;
use App\Models\School\SchoolYear;
use App\Models\Subject\Subjects;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Classes extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'classes';


    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
            $model->code = $model->generateCode();
        });
    }

    /**
     * Generate a unique code for the subject.
     */
    public function generateCode()
    {
        $baseCode = 'SEIATurma';
        $counter = 1;
        $code = $baseCode . $counter;

        do {
            $code = $baseCode . $counter;
            if (!$this::where('code', $code)->exists()) {
                return $code;
            }
            $counter++;
        } while ($this::where('code', $code)->exists());

        return $code;
    }


    protected $fillable = [
        'uuid',
        'name',
        'schools_uuid',
        'school_years_uuid',
        'curriculum_uuid',
        'modality',
        'code',
        'status',
        'turn',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'start_time',
        'end_time',
        'max_students',
        'primary_room',
        'teacher_responsible_uuid',
    ];

    /**
     * Get the school year that owns the Classes
     */

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_years_uuid', 'uuid');
    }

    /**
     * Get the currilum that owns the Classes
     */

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_uuid', 'uuid');
    }


    /**
     * Teachers of the class
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teachers_schools', 'class_uuid', 'user_uuid', 'uuid', 'uuid');
    }

    public function subjects()
    {
        return $this->hasMany(Subjects::class, 'curriculum_uuid', 'curriculum_uuid');
    }

    /**
     * Get the school that owns the Classes
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'schools_uuid', 'uuid');
    }

    /**
     * Get the students of the class
     */
    public function rooms()
    {
        return $this->belongsToMany(Rooms::class, 'classes_rooms', 'class_uuid', 'rooms_uuid', 'uuid', 'uuid');
    }
}
