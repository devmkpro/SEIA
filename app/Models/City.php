<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class City extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
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
        'name',
        'ibge_code',
        'state_id',
    ];


    /**
     * Get the quantity of schools in this city.
     */

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    /**
     * Get the state that owns the city.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'ibge_code');
    }
}
