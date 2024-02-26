<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Odontogram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'symbol',
        'description',
        'placement',
        'is_outside',
    ];

    public function odontogramResults()
    {
        return $this->hasMany(OdontogramResult::class);
    }
}
