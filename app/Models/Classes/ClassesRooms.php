<?php

namespace App\Models\Classes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClassesRooms extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'classes_rooms';

    protected $fillable = [
        'uuid',
        'class_uuid',
        'room_uuid',
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
     * Get the classes associated with the classes_rooms.
     */
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_uuid', 'uuid');
    }
}
