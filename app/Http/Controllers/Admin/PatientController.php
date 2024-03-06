<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ExaminationInterface;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $examination;

    public function __construct(ExaminationInterface $examination)
    {
        $this->examination = $examination;
    }

    public function index(Request $request)
    {
        $examinations = $this->examination->getAllExaminationGroupByCustomer();
        if ($request->ajax()) {
            return datatables()
                ->of($examinations)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('date_of_birth', function ($data) {
                    return date('d/m/Y', strtotime($data->date_of_birth));
                })
                ->addColumn('gender', function ($data) {
                    return $data->gender == 'Male' ? 'Laki-laki' : 'Perempuan';
                })
                ->addColumn('examination_count', function ($data) {
                    return $data->examinations->count();
                })
                ->addColumn('action', function ($data) {
                    return view('admin.patient.column.action', compact('data'));
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.patient.index', compact('examinations'));
    }

    public function examinations($customer_id)
    {
        $data = $this->examination->getExaminationByCustomerId($customer_id);
        $examinationHistories = $data['examinations'];

        return view('admin.patient.examinations', compact('data', 'examinationHistories'));
    }
}
