<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\QueueInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    private $queue;

    public function __construct(QueueInterface $queue)
    {
        $this->queue = $queue;
    }

    public function index(Request $request)
    {
        $queues = $this->queue->getAllReservation();
        if ($request->ajax()) {
            return datatables()
                ->of($queues)
                ->addColumn('no', function ($data) {
                    return $data->no;
                })
                ->addColumn('branch', function ($data) {
                    return $data->branch->name;
                })
                ->addColumn('request_date', function ($data) {
                    return Carbon::parse($data->request_date)->format('d-m-Y');
                })
                ->addColumn('request_time', function ($data) {
                    return Carbon::parse($data->request_time)->locale('id')->format('H:i');
                })
                ->addColumn('customer', function ($data) {
                    return $data->customer->name;
                })
                ->addColumn('action', function ($data) {
                    return view('doctor.queue.column.action', compact('data'));
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('doctor.queue.index');
    }

    public function show($id)
    {
        // $data = $this->queue->getReservationById($id);

        // return view('doctor.queue.show', compact('data'));
    }

    public function updateExaminationStatus($id, Request $request)
    {
        $this->queue->updateExaminationStatus($id, $request->except('_token'));

        return response()->json(['status' => 'success', 'message' => 'Status pemeriksaan berhasil diubah.']);
    }
}
