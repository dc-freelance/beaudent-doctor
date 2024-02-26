<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'items';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function discountItem()
    {
        return $this->hasOne(DiscountItem::class, 'item_id', 'id');
    }

    public function examinationItems()
    {
        return $this->hasMany(ExaminationItem::class, 'item_id', 'id');
    }
}
