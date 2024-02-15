<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class State extends Model
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
        'name',
        'ibge_code',
    ];

    /**
     * Get the quantity of schools in this state.
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'ibge_code');
    }

    /**
     * Get the quantity of schools in this state.
     */

    public function schools()
    {
        return $this->cities()->with('schools')->get()->pluck('schools')->flatten(1);
    }


}
