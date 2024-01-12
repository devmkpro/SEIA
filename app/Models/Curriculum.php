<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Curriculum extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'curricula';

    protected $fillable = [
        'uuid',
        'code',
        'school_uuid',
        'series',
        'weekly_hours',
        'total_hours',
        'start_time',
        'end_time',
        'description',
        'modality',
        'complementary_information',
    ];

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
     * Generate a unique code for the curriculum.
     */
    protected function generateCode(): int
    {
        $code = rand(100000, 999999);
        if (Curriculum::where('code', $code)->exists()) {
            return $this->generateCode();
        }
        return $code;
    }
    
    /**
     * Get the school that owns the curriculum.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Subjects that belong to the curriculum.
     */
    public function subjects()
    {
        return $this->hasMany(Subjects::class, 'curriculum_uuid', 'uuid');
    }

    /**
     * Get classes that belong to the curriculum.
     */
    public function classes()
    {
        return $this->hasMany(Classes::class, 'curriculum_uuid', 'uuid');
    }


}
