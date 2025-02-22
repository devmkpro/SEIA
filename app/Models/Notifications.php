<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notifications extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    protected $table = 'notifications';
    public $incrementing = false;

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

    protected $fillable = [
        'uuid',
        'title',
        'body',
        'icon',
        'read',
        'request_uuid',
        'user_uuid',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user(){
        $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function request(){
        $this->belongsTo(SchoolConnectionRequest::class, 'request_uuid', 'uuid');
    }


}
