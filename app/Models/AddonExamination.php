<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddonExamination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'examination_id',
        'user_id',
        'doctor_id',
        'fee_percentage',
        'addon_id',
        'fee',
        'sub_total',
        'qty',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
