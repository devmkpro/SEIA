<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeachersSchoolsSubjects extends Model
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
        'user_uuid',
        'school_uuid',
        'class_uuid',
        'status',
        
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function school(){
        return $this->belongsTo(School::class, 'school_uuid', 'uuid');
    }

    public function subjects(){
        return $this->belongsTo(Subjects::class, 'subject_uuid', 'uuid');
    }


}
