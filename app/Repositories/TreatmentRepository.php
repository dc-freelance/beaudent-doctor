<?php

namespace App\Repositories;

use App\Interfaces\TreatmentInterface;
use App\Models\Treatment;
use Carbon\Carbon;

class TreatmentRepository implements TreatmentInterface
{
    private $treatment;

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
    }

    public function getAll()
    {
        $currentDate = Carbon::now()->locale('id')->format('Y-m-d');
        $treatments = $this->treatment->with(['discountTreatment.discount' => function ($query) use ($currentDate) {
            $query->where('start_date', '<=', $currentDate)->where('end_date', '>=', $currentDate);
        }])->get();

        return $treatments;
    }

    public function getById($id)
    {
        return $this->treatment->find($id);
    }
}
