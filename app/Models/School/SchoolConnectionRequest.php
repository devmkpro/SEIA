<?php

namespace App\Models\School;

use App\Models\Classes\Classes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class SchoolConnectionRequest extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = "school_connection_requests";

    protected $fillable = [
        "uuid",
        "school_uuid",
        "user_uuid",
        "role",
        "status",
        "class_uuid",
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

    public function school()
    {
        return $this->belongsTo(School::class, "school_uuid", "uuid");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_uuid", "uuid");
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, "class_uuid", "uuid");
    }
}
