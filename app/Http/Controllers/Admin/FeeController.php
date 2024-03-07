<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\IncomeReportInterface;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    private $income;

    public function __construct(IncomeReportInterface $income)
    {
        $this->income = $income;
    }

    public function index(Request $request)
    {
        $results = $this->income->getIncome();
        if ($request->ajax()) {
            return view('doctor.fee.table._fee', compact('results'));
        }
        return view('doctor.fee.index');
    }
}
