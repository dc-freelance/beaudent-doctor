<?php

namespace App\Repositories;

use App\Interfaces\MedicalRecordInterface;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\MedicalRecord;
use App\Models\Transaction;

class MedicalRecordRepository implements MedicalRecordInterface
{
    private $medicalRecord;
    private $branch;
    private $customer;
    private $transaction;

    public function __construct(MedicalRecord $medicalRecord, Branch $branch, Customer $customer, Transaction  $transaction)
    {
        $this->medicalRecord = $medicalRecord;
        $this->branch        = $branch;
        $this->customer      = $customer;
        $this->transaction   = $transaction;
    }

    // Create new medical record if customer has not had one in the branch
    public function create($data)
    {
        $branchCode          = $this->branch->find($data['branch_id'])->code;
        $medicalRecordNumber = uniqid() . '-' . $branchCode;

        $medicalRecord = $this->medicalRecord->where('customer_id', $data['customer_id'])
            ->where('branch_id', $data['branch_id'])
            ->first();

        if ($medicalRecord) {
            return $medicalRecord;
        }

        $medicalRecord = $this->medicalRecord->create([
            'medical_record_number' => $medicalRecordNumber,
            'customer_id'           => $data['customer_id'],
            'branch_id'             => $data['branch_id'],
        ]);

        return $medicalRecord;
    }

    public function store($data)
    {
        $this->medicalRecord->create($data);
    }
}
