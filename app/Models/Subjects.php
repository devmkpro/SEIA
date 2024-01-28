<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subjects extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'subjects';

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'curriculum_uuid',
        'ch',
        'ch_week',
        'description',
        'modality'
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
        $baseCode = 'DSC';
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
     * Get the curriculum that owns the subject.
     */
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_uuid', 'uuid');
    }

    public function name()
    {
        return $this->name;
    }

    /**
     * Get teachers that belongs to the subject.
     */
    public function teachers()
    {
        return $this->belongsTo(TeachersSubjects::class, 'uuid', 'subject_uuid');
    }

    
}
