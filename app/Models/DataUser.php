<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class DataUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    protected $table = 'data_users';
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
        'user_uuid',
        'landline',
        'inep',
        'cpf',
        'rg',
        'birth_date',
        'gender',
        'country',
        'street',
        'number',
        'district',
        'city',
        'state',
        'zip_code',
        'mother_name',
        'father_name',
        'cpf_responsible',
        'blood_type',
        'deficiency',
        'observation',
        'zone',
        'city_birth',
        'state_birth',
        'name_responsible',

    ];

    protected $casts = [
        'birth_date' => 'date',
        'deficiency' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
