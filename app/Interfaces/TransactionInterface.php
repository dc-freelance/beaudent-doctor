<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function store($examination_id, $data);
    public function getByExaminationId($examination_id);
    public function generateTransactionCode($prefix, $year, $month, $branch_id);

    public function addTreatment($data);
    public function getExaminationTreatments($examination_id);
    public function removeTreatment($id);

    public function addItem($data);
    public function getExaminationItems($examination_id);
    public function removeItem($id);

    public function addAddon($data);
    public function getExaminationAddons($examination_id);
    public function removeAddon($id);
}
