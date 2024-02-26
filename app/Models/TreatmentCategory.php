<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'treatment_categories';

    protected $guarded = [];

    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'category_id');
    }
}
