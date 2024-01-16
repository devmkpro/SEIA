<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeachersSubjects extends Model
{
    use HasFactory;

    protected $table = "teachers_subjects";
    protected $primaryKey = 'uuid';
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
        'user_uuid',
        'class_uuid',
        'subject_uuid',
    ];

    /**
     * Get the user that belongs to the teacher
     */

    public function user(){
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * Get the class that belongs to the teacher
     */

    public function class(){
        return $this->belongsTo(Classes::class, 'class_uuid', 'uuid');
    }

    /*
    * Get the subjects that belongs to the teacher
    */
    public function subjects(){
        return $this->belongsTo(Subjects::class, 'subject_uuid', 'uuid');
    }
}
