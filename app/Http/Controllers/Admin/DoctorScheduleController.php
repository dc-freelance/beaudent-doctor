<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\DoctorScheduleInterface;
use App\Interfaces\DoctorInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DoctorScheduleController extends Controller
{
    private $doctorSchedule;
    private $doctor;

    public function __construct(DoctorScheduleInterface $doctorSchedule)
    {
        $this->doctorSchedule = $doctorSchedule;
        $this->doctor = Session::get('doctor');
    }

    public function index(Request $request)
    {
        $id_doctor = Session::get('doctor')->id;
        $datas = $this->doctorSchedule->getById($id_doctor);
        if ($request->ajax()) {
            return datatables()
                ->of($datas)
                ->addColumn('name', function ($data) {
                    return $data->doctor->name;
                })
                ->addColumn('branch', function ($data) {
                    return $data->branch->name;
                })
                ->addColumn('date', function ($data) {
                    return Carbon::parse($data->date)->locale('id')->isoFormat('LL');
                })
                ->addColumn('shift', function ($data) {
                    return $data->shift;
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('doctor.doctor-schedule.index');
    }
}
