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
            $model->code = date('YmdHis') . Str::random(6);
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
        'type',
        'code'
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function request()
    {
        return $this->belongsTo(SchoolConnectionRequest::class, 'request_uuid', 'uuid');
    }


}
