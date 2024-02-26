<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Addon extends Model
{
    use HasFactory;
    use HasFactory, HasRoles, SoftDeletes;

    protected $table = 'addons';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function addonExaminations()
    {
        return $this->hasMany(AddonExamination::class);
    }
}
