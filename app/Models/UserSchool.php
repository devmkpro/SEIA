<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TeachersSubjects;

class UserSchool extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'users_schools';


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
        'users_uuid',
        'school_uuid',
        'role',
    ];

    /**
     * Get the user that owns the 'AlunoEscola'
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_uuid', 'uuid');
    }

    /**
     * Get the school that owns the 'AlunoEscola'
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_uuid', 'uuid');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role', 'uuid');
    }

    public function subjects(){
        return $this->hasMany(TeachersSubjects::class, 'user_uuid', 'users_uuid')->where('school_uuid', $this->school_uuid);
    }
}
