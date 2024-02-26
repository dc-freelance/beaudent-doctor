<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservations';

    protected $guarded = [];

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function treatments()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

    public function getTanggalReservasiTextAttribute()
    {
        return Carbon::parse($this->request_date)->locale('id')->isoFormat('LL');
    }

    public function getTanggalTransferTextAttribute()
    {
        return Carbon::parse($this->transfer_date)->locale('id')->isoFormat('LL');
    }

    public function getWaktuReservasiTextAttribute()
    {
        return Carbon::parse($this->request_time)->locale('id')->isoFormat('LT');
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class, 'reservation_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function examination()
    {
        return $this->hasOne(Examination::class, 'reservation_id', 'id');
    }
}
