<?php

namespace App\Repositories;

use App\Interfaces\DoctorScheduleInterface;
use App\Models\DoctorSchedule;

class DoctorScheduleRepository implements DoctorScheduleInterface
{
    private $doctorSchedule;

    public function __construct(DoctorSchedule $doctorSchedule)
    {
        $this->doctorSchedule = $doctorSchedule;
    }

    public function getById($id)
    {
        return $this->doctorSchedule->with('doctor', 'branch')->where('doctor_id',$id)->get();
    }
}
