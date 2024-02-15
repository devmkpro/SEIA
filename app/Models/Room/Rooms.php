<?php

namespace App\Models\Room;

use App\Models\Classes\ClassesRooms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rooms extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'description',
        'school_uuid',
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
     * Generate a unique code for the room.
     */
    public function generateCode()
    {
        $baseCode = 'SALA';
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
     * Get the school that owns the room.
     */
    public function classes()
    {
        return $this->hasMany(ClassesRooms::class, 'rooms_uuid', 'uuid');
    }

}
