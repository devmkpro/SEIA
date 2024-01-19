<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SchoolYear extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'school_years';

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
     * Generate a code for this model
     */
    public function generateCode(): string
    {
        do {
            $code = rand(100000, 999999);
        } while (School::where('code', $code)->exists());

        return $code;
    }

    protected $fillable = [
        'code',
        'name',
        'start_date',
        'end_date',
        'active',
    ];
}
