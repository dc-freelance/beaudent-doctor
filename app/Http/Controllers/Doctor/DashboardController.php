<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Interfaces\IncomeReportInterface;
use App\Interfaces\QueueInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $incomeReport;

    private $queue;

    public function __construct(IncomeReportInterface $incomeReport, QueueInterface $queue)
    {
        $this->incomeReport = $incomeReport;
        $this->queue = $queue;
    }

    public function index(Request $request)
    {
        $results = $this->incomeReport->getIncome();
        if ($request->ajax()) {
            return view('doctor.dashboard.table.income', compact('results'))->render();
        }

        $stats = $this->incomeReport->getStats();
        $totalFeeToday = $stats['total_fee_today'];
        $totalFee = $stats['total_fee'];
        $totalPatient = $stats['total_patient'];
        $totalExamination = $stats['total_examination'];
        $totalWaitingList = $this->queue->getWaitingList()->count();

        return view('doctor.dashboard.index', compact('totalFeeToday', 'totalFee', 'totalPatient', 'totalExamination', 'totalWaitingList'));
    }
}
