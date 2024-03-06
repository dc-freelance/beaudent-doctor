<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_id',
        'doctor_id',
        'medical_record_id',
        'customer_id',
        'examination_date',
        'systolic_blood_pressure',
        'diastolic_blood_pressure',
        'blood_type',
        'heart_disease',
        'diabetes',
        'blood_clotting_disorder',
        'hepatitis',
        'digestive_diseases',
        'other_diseases',
        'allergies_to_medicines',
        'medications', // if allergies to medicines fill this
        'allergies_to_food',
        'foods', // if alergies to food fill this
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function odontogramResults()
    {
        return $this->hasMany(OdontogramResult::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function addonExaminations()
    {
        return $this->hasMany(AddonExamination::class);
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function examinationTreatments()
    {
        return $this->hasMany(ExaminationTreatment::class);
    }

    public function examinationItems()
    {
        return $this->hasMany(ExaminationItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
