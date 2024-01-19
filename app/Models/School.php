<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class School extends Model
{
    use HasFactory;
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
            $model->code = $model->generateCode();
        });
    }

    /**
     * Generate a code for this model
     */
    public function generateCode(): string
    {
        do {
            $code = rand(100000, 999999);
        } while (School::where('code', $code)->exists());

        return $code;
    }

    protected $fillable = [
        'city_uuid',
        'code',        
        'name',
        'email',
        'phone',
        'landline',
        'zip_code',
        'district',
        'slug',
        'email_responsible',
        'active',
        'public',
        'has_education_infant',
        'has_education_fundamental',
        'has_education_medium',
        'has_education_professional',
        'inep',
        'number',
        'street',
        'complement',
        'cnpj',
    ];

    /**
     * Get the city that owns the school.
     */
    public function city()
    {
        return $this->hasOne(City::class, 'uuid', 'city_uuid');
    }

    /**
     * Get the state that owns the school.
     */
    public function state()
    {
        return $this->hasOneThrough(State::class, City::class, 'uuid', 'ibge_code', 'city_uuid', 'state_id');
    }

    /**
     * Get the students for the school.
     */
    public function students()
    {
        $role = Role::where('name', 'student')->first();
        return $this->belongsToMany(User::class, 'users_schools', 'school_uuid', 'users_uuid')->wherePivot('role', $role->uuid);
    }

    /**
     * Get the teachers for the school.
     */
    public function teachers()
    {
        $role = Role::where('name', 'teacher')->first();
        $teachers = UserSchool::where('school_uuid', $this->uuid)->where('role', $role->uuid)->get();
        return $teachers;
    }


}
