<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentBonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatment_id',
        'doctor_category_id',
        'bonus_type',
        'bonus_rate',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function doctorCategory()
    {
        return $this->belongsTo(DoctorCategory::class);
    }
}
