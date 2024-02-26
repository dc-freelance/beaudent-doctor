<?php

namespace App\Interfaces;

interface ExaminationInterface
{
    public function getById($id);
    public function store($data);
    public function update($id, $data);
    public function getExaminationByTransactionId($transactionId);
}
