<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'item_id',
        'qty',
        'sub_total',
        'note_interaction',
        'amount_a_day',
        'day',
        'period',
        'duration',
        'guide',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
