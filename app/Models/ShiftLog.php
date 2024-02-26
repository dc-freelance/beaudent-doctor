<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class ShiftLog extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $table = 'shift_logs';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function config_shift()
    {
        return $this->belongsTo(ConfigShift::class, 'config_shift_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
