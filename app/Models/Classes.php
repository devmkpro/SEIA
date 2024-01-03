<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Classes extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'classes';


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

    protected function generateCode(): int
    {
        $code = rand(100000, 999999);
        $codeExists = Classes::where('code', $code)->first();
        if ($codeExists) {
            $this->generateCode();
        }
        return $code;
    }
    

    protected $fillable = [
        'uuid',
        'school_years_uuid',
        'curriculum_uuid',
        'code',
        'status',
        'shift',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'start_time',
        'end_time',
        'max_students',
        'room',
    ];

    /**
     * Get the school year that owns the Classes
     */

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_years_uuid', 'uuid');
    }

    /**
     * Get the currilum that owns the Classes
     */

    public function currilum()
    {
        return $this->belongsTo(Curriculum::class, 'currilum_uuid', 'uuid');
    }


}
