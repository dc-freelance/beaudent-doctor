<?php

namespace App\Repositories;

use App\Interfaces\ItemInterface;
use App\Models\Item;
use App\Models\Unit;
use Carbon\Carbon;

class ItemRepository implements ItemInterface
{
    private $item;
    private $itemUnit;

    public function __construct(Item $item, Unit $itemUnit)
    {
        $this->item = $item;
        $this->itemUnit = $itemUnit;
    }

    public function getAll()
    {
        $currentDate = Carbon::now()->locale('id')->format('Y-m-d');
        return $this->item->with(['unit', 'category', 'discountItem.discount' => function ($query) use ($currentDate) {
            $query->where('start_date', '<=', $currentDate)->where('end_date', '>=', $currentDate);
        }])->get();
    }

    public function getById($id)
    {
        return $this->item->with('unit', 'category')->find($id);
    }
}
