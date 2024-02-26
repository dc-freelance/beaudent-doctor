<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OdontogramResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'examination_id',
        'odontogram_id',
        'tooth_number',
        'tooth_position',
        'img_name',
        'side',
        'diagnosis',
        'remark',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function odontogram()
    {
        return $this->belongsTo(Odontogram::class);
    }
}
