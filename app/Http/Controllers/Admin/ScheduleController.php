<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ScheduleInterface;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private $schedule;

    public function __construct(ScheduleInterface $schedule)
    {
        $this->schedule = $schedule;
    }

    public function index(Request $request)
    {
        $result = $this->schedule->getAll();
        if ($request->ajax()) {
            return datatables()
                ->of($result)
                ->addColumn('date', function ($data) {
                    return date('Y-m-d', strtotime($data->created_at));
                })
                ->addColumn('time', function ($data) {
                    return date('H:i', strtotime($data->created_at));
                })
                ->addColumn('branch', function ($data) {
                    return $data->branch->name;
                })
                ->addColumn('status', function ($data) {
                    $status = date('Y-m-d H:i', strtotime($data->created_at)) == date('Y-m-d H:i') ? 'now' : (date('Y-m-d H:i', strtotime($data->created_at)) < date('Y-m-d H:i') ? 'done' : 'upcoming');

                    return view('admin.schedule._status', compact('status'));
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.schedule.index');
    }
}
