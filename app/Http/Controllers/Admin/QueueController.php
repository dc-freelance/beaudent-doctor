<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CustomerInterface;
use App\Interfaces\QueueInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    private $queue;

    private $customer;

    private $treatment;

    public function __construct(QueueInterface $queue, CustomerInterface $customer)
    {
        $this->queue = $queue;
        $this->customer = $customer;
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

        $customers = $this->customer->getAll();

        return view('doctor.queue.index', compact('customers'));
    }

    public function updateExaminationStatus($id, Request $request)
    {
        $this->queue->updateExaminationStatus($id, $request->except('_token'));

        return response()->json(['status' => 'success', 'message' => 'Status pemeriksaan berhasil diubah.']);
    }
}
