<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'medical_record_number', // must be unique
        'customer_id',
        'branch_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function examination()
    {
        return $this->hasOne(Examination::class);
    }
}
