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
        return $this->doctorSchedule->with('branch')->where('doctor_id', session('doctor')->id)->orderBy('created_at', 'desc')->get();
    }
}
