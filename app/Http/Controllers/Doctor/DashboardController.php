<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('doctor.dashboard.index');
    }
}
