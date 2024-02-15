<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\School\School;
use App\Models\User;
use App\Models\Teacher\TeachersSubjects;
class TeachersSchools extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'teachers_schools';

    
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
        'uuid',
        'user_uuid',
        'school_uuid',
        'class_uuid',
        'status',
        'weekly_workload'
    ];

    /**
     * Get the user that owns the TeachersSchools
     */

    public function user(){
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * Get the school that owns the TeachersSchools
     */

    public function school(){
        return $this->belongsTo(School::class, 'school_uuid', 'uuid');
    }

    /**
     * Get the subject that owns the TeachersSchools
     */
    public function teacherSubjects(){
        return $this->belongsTo(TeachersSubjects::class, 'user_uuid', 'user_uuid');
    }

}
