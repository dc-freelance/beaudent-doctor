<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'category_id');
    }

    public function treatmentBonuses()
    {
        return $this->hasMany(TreatmentBonus::class, 'doctor_category_id');
    }
}
