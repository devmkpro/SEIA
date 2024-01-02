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
        });
    }
    
    /**
     * Get the school that owns the curriculum.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }


}
