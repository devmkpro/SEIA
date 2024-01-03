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
        });
    }

    /**
     * Get the curriculum that owns the subject.
     */
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_uuid', 'uuid');
    }
   
}
