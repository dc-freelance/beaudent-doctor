<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Interfaces\IncomeReportInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $incomeReport;

    public function __construct(IncomeReportInterface $incomeReport)
    {
        $this->incomeReport = $incomeReport;
    }

    public function index(Request $request)
    {
        $results = $this->incomeReport->getIncome();
        if ($request->ajax()) {
            return view('doctor.dashboard.table.income', compact('results'))->render();
        }
        return view('doctor.dashboard.index');
    }
}
