<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TeachersSchoolsSubjects;

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

    protected function generateCode(): int
    {
        $code = rand(100000, 999999);
        $codeExists = Classes::where('code', $code)->first();
        if ($codeExists) {
            $this->generateCode();
        }
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
        'room',
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
     * Teacher responsible for the class
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_responsible_uuid', 'uuid');
    }

    /**
     * Teachers of the class
     */
    public function teachers()
    {
        return $this->hasMany(TeachersSchoolsSubjects::class, 'school_uuid', 'schools_uuid', 'user_uuid', 'user_uuid', 'class_uuid', 'uuid');
    }

    public function school(){
        return $this->belongsTo(School::class, 'schools_uuid', 'uuid');
    }

}
