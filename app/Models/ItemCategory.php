<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    const GENERAL_CATEGORY = 1;

    protected $fillable = [
        'name',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
