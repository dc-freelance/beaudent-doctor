<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'treatments';

    protected $fillable = [
        'name',
        'code',
        'parent_id',
        'is_control',
        'treatment_category_id',
        'price',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'treatment_id', 'id');
    }

    public function treatmentBonus()
    {
        return $this->hasMany(TreatmentBonus::class, 'treatment');
    }

    public function getTreatment()
    {
        return $this->whereNull('parent_id')->get();
    }

    public function treatmentCategory()
    {
        return $this->belongsTo(TreatmentCategory::class, 'treatment_category_id');
    }

    public function getTreatmentById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function discountTreatment()
    {
        return $this->hasOne(DiscountTreatment::class, 'treatment_id', 'id');
    }

    public function examinationTreatment()
    {
        return $this->hasMany(ExaminationTreatment::class, 'treatment_id', 'id');
    }
}
