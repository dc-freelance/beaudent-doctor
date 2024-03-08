<?php

namespace App\Repositories;

use App\Interfaces\QueueInterface;
use App\Models\Branch;
use App\Models\ConfigShift;
use App\Models\Customer;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class QueueRepository implements QueueInterface
{
    private $reservation;
    private $doctor;
    private $customer;
    private $branch;
    private $doctorSchedule;

    public function __construct(
        Reservation $reservation,
        Doctor $doctor,
        ConfigShift $configShift,
        Customer $customer,
        Branch $branch,
        DoctorSchedule $doctorSchedule
    ) {
        $this->reservation = $reservation;
        $this->doctor = $doctor;
        $this->customer = $customer;
        $this->branch = $branch;
        $this->doctorSchedule = $doctorSchedule;
    }

    public function getAllReservation()
    {
        $currentTime = Carbon::now('Asia/Jakarta')->format('H:i');
        $configShift = ConfigShift::where([
            ['start_time', '<=', $currentTime],
            ['end_time', '>=', $currentTime],
        ])->first();
        $reservations = [];
        if ($configShift) {
            $reservations = $this->reservation
                ->where('request_date', Carbon::now('Asia/Jakarta')->format('Y-m-d'))
                ->where('status', 'Confirm')
                ->where('request_time', '>=', $configShift->start_time)
                ->where('request_time', '<=', $configShift->end_time)
                ->where('examination_status', 0)
                ->orderBy('request_time', 'asc')
                ->get();

            $reservations->map(function ($reservation) {
                $reservation->customer = $this->customer
                    ->where('id', $reservation->customer_id)
                    ->first();
                $reservation->branch = $this->branch
                    ->where('id', $reservation->branch_id)
                    ->first();
            });
        }

        $doctor = $this->doctor
            ->where('id', Session::get('doctor')->id)
            ->first();

        $doctorSchedule = $this->doctorSchedule
            ->where('doctor_id', $doctor->id)
            ->where('date', Carbon::now('Asia/Jakarta')->format('Y-m-d'))
            ->first();

        if (!$reservations || !$doctorSchedule) {
            return [];
        }

        $reservations = $reservations->filter(function ($reservation) use ($doctorSchedule) {
            return $reservation->branch_id == $doctorSchedule->branch_id;
        });

        return $reservations;
    }

    public function getReservationById($id)
    {
        $reservation = $this->reservation->where('id', $id)
            ->with('customer', 'branch', 'examination')
            ->first();

        return $reservation;
    }

    public function updateExaminationStatus($id, $status)
    {
        return $this->reservation->where('id', $id)->update($status);
    }

    public function getWaitingList()
    {
        $reservations = $this->reservation
            ->where([
                ['status', 'Confirm'],
                ['request_date', Carbon::now('Asia/Jakarta')->format('Y-m-d')],
                ['examination_status', 0],
            ])
            ->get();

        return $reservations;
    }
}
