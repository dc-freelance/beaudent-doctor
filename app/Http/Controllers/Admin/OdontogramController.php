<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ExaminationInterface;
use App\Interfaces\OdontogramInterface;
use App\Interfaces\OdontogramResultInterface;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class OdontogramController extends Controller
{
    private $odontogram;
    private $odontogramResult;
    private $examination;

    public function __construct(OdontogramInterface $odontogram, OdontogramResultInterface $odontogramResult, ExaminationInterface $examination)
    {
        $this->odontogram       = $odontogram;
        $this->odontogramResult = $odontogramResult;
        $this->examination      = $examination;
    }

    public function create($examination_id)
    {
        $odontograms       = $this->odontogram->get();
        $examination       = $this->examination->getById($examination_id);
        $odontogramResults = $this->odontogramResult->getByExaminationId($examination_id);
        $odontogramGroup   = $this->odontogramResult->groupOdontogramResults($odontogramResults);

        return view('doctor.odontogram.create', compact('odontograms', 'examination', 'odontogramGroup'));
    }

    public function destroyDiagnose($id)
    {
        $this->odontogramResult->deleteDiagnose($id);
        toast('Diagnosa berhasil dihapus', 'success');
        return redirect()->back();
    }

    public function getByToothNumber($tooth_number, Request $request)
    {
        $data = $this->odontogramResult->getByToothNumber($tooth_number, $request->examination_id);
        $data = $this->odontogramResult->groupOdontogramResultByToothNumber($data);

        return view('doctor.odontogram.components._tooth_number', compact('data'));
    }

    public function storeDiagnose(Request $request)
    {
        $odontogramResult = $this->odontogramResult->storeDiagnose($request->except('_token'));
        return view('doctor.odontogram.components._render_tooth', compact('odontogramResult'));
    }

    public function show($examination_id)
    {
        $odontograms        = $this->odontogram->get();
        $examination        = $this->examination->getById($examination_id);
        $odontogramResults  = $this->odontogramResult->getByExaminationId($examination_id);
        $odontogramGroup    = $this->odontogramResult->groupOdontogramResults($odontogramResults);
        $odontogramForTable = $this->odontogramResult->groupOdontogramResultsForTable($odontogramGroup);

        return view('doctor.odontogram.show', compact('odontograms', 'examination', 'odontogramGroup', 'odontogramResults'));
    }
}
