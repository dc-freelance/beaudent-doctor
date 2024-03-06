<?php

namespace App\Repositories;

use App\Interfaces\ScheduleInterface;
use App\Models\DoctorSchedule;

class ScheduleRepository implements ScheduleInterface
{
    private $doctorSchedule;

    public function __construct(DoctorSchedule $doctorSchedule)
    {
        $this->doctorSchedule = $doctorSchedule;
    }

    public function getAll()
    {
        return $this->doctorSchedule->with('branch')
            ->when(request()->filled('start_date') && request()->filled('end_date'), function ($query) {
                $query->where('date', '>=', request()->start_date.' 00:00:00')
                    ->where('date', '<=', request()->end_date.' 23:59:59');
            })
            ->when(request()->filled('month'), function ($query) {
                $query->whereYear('date', explode('-', request()->month)[0])
                    ->whereMonth('date', explode('-', request()->month)[1]);
            })
            ->where('doctor_id', session('doctor')->id)->orderBy('created_at', 'desc')->get();
    }
}
