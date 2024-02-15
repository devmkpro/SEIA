<?php

namespace App\Models\Curriculum;

use App\Models\Classes\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\School\School;
use App\Models\Subject\Subjects;

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
        'default_time_class',
        'turn',
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
     * Generate a unique code for the subject.
     */
    public function generateCode()
    {
        $baseCode = 'SEIAMatriz';
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
