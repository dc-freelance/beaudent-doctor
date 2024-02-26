<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    const ADMIN_PUSAT_ROLE = 'admin_pusat';

    const ADMIN_CABANG_ROLE = 'admin_cabang';

    const FRONT_OFFICE_ROLE = 'frontoffice';

    const MANAGER_CABANG_ROLE = 'manager_cabang';

    const BILLING_ROLE = 'billing';

    const OWNER_ROLE = 'owner';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'join_date',
        'password',
        'branch_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function shift_log()
    {
        return $this->hasMany(ShiftLog::class, 'user_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'cashier_id', 'id');
    }

    public function addonTransaction()
    {
        return $this->hasMany(AddonTransaction::class, 'doctor_id', 'id');
    }
}
