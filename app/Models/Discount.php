<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'name',
        'discount_type',
        'discount',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function getDiscount()
    {
        return $this->get();
    }

    public function discountItems()
    {
        return $this->hasMany(DiscountItem::class, 'discount_id', 'id');
    }

    public function discountTreatments()
    {
        return $this->hasMany(DiscountTreatment::class, 'discount_id', 'id');
    }

    public function getDiscountById($id)
    {
        return $this->where('id', $id)->first();
    }
}
