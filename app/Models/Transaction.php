<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Transaction extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $table = 'transactions';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_method_id', 'id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class, 'examination_id', 'id');
    }
}
