<?php

namespace App\Interfaces;

interface OdontogramResultInterface
{
    public function get();
    public function deleteDiagnose($id);
    public function storeDiagnose($data);
    public function getByExaminationId($examinationId);
    public function groupOdontogramResults($odontogramResults);
    public function getByToothNumber($toothNumber, $examinationId);
    public function groupOdontogramResultByToothNumber($odontogramResults);
    public function groupOdontogramResultsForTable($odontogramResults);
}
