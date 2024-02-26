<?php

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\AddonExamination;
use App\Models\Branch;
use App\Models\ExaminationItem;
use App\Models\ExaminationTreatment;
use App\Models\Sequence;
use App\Models\Transaction;

class TransactionRepository implements TransactionInterface
{
    private $transaction;
    private $branch;
    private $sequence;
    private $examinationTreatment;
    private $examinationItem;
    private $examinationAddon;

    public function __construct(Transaction $transaction, Branch $branch, Sequence $sequence, ExaminationTreatment $examinationTreatment, ExaminationItem $examinationItem, AddonExamination $examinationAddon)
    {
        $this->transaction          = $transaction;
        $this->branch               = $branch;
        $this->sequence             = $sequence;
        $this->examinationTreatment = $examinationTreatment;
        $this->examinationItem      = $examinationItem;
        $this->examinationAddon     = $examinationAddon;
    }

    public function store($examination_id, $data)
    {
        $data['examination_id'] = $examination_id;
        return $this->transaction->create($data);
    }

    public function getByExaminationId($examination_id)
    {
        return $this->transaction->where('examination_id', $examination_id)->first();
    }

    public function generateTransactionCode($prefix, $year, $month, $branch_id)
    {
        $lastNoOfSequence = $this->sequence->where('code', $prefix)
            ->where('year', $year)
            ->where('month', $month)
            ->where('branch_id', $branch_id)
            ->orderBy('no', 'desc')
            ->first();

        $no = 1;

        if ($lastNoOfSequence) {
            $no = $lastNoOfSequence->no + 1;
        }

        $branchCode = $this->branch->find($branch_id)->code;

        $newTransactionCode = $prefix . '-' . $branchCode . '-' . $year . '-' . $month . '-' . str_pad($no, 3, '0', STR_PAD_LEFT);

        // Menyimpan nomor urut terakhir ke dalam database
        if (!$lastNoOfSequence) {
            Sequence::create([
                'code'      => $prefix,
                'year'      => $year,
                'month'     => $month,
                'branch_id' => $branch_id,
                'no'        => $no,
            ]);
        } else {
            $lastNoOfSequence->update(['no' => $no]);
        }

        return $newTransactionCode;
    }

    public function addTreatment($data)
    {
        $this->examinationTreatment->create($data);
        $treatments = $this->examinationTreatment
            ->with('treatment')
            ->where('examination_id', $data['examination_id'])->get();
        return $treatments;
    }

    public function getExaminationTreatments($examination_id)
    {
        return $this->examinationTreatment
            ->with('treatment')
            ->where('examination_id', $examination_id)->get();
    }

    public function removeTreatment($id)
    {
        $examinationTreatment = $this->examinationTreatment->find($id);
        $examinationTreatment->delete();
    }

    public function addItem($data)
    {
        $this->examinationItem->create($data);
        $items = $this->examinationItem->where('examination_id', $data['examination_id'])->get();
        return $items;
    }

    public function getExaminationItems($examination_id)
    {
        return $this->examinationItem->where('examination_id', $examination_id)->get();
    }

    public function removeItem($id)
    {
        $examinationItem = $this->examinationItem->find($id);
        $examinationItem->delete();
    }

    public function addAddon($data)
    {
        $this->examinationAddon->create($data);
        $addons = $this->examinationAddon->where('examination_id', $data['examination_id'])->get();
        return $addons;
    }

    public function getExaminationAddons($examination_id)
    {
        return $this->examinationAddon->where('examination_id', $examination_id)->get();
    }

    public function removeAddon($id)
    {
        $examinationAddon = $this->examinationAddon->find($id);
        $examinationAddon->delete();
    }
}
