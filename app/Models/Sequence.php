<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'year',
        'month',
        'branch_id',
        'no',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
