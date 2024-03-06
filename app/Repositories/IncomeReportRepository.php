<?php

namespace App\Repositories;

use App\Interfaces\IncomeReportInterface;
use App\Models\AddonExamination;
use App\Models\DoctorBonus;
use App\Models\ExaminationTreatment;
use App\Models\Transaction;

class IncomeReportRepository implements IncomeReportInterface
{
    private $transaction;

    private $doctorBonus;

    private $examinationTreatment;

    private $addonExamination;

    public function __construct(Transaction $transaction, DoctorBonus $doctorBonus, ExaminationTreatment $examinationTreatment, AddonExamination $addonExamination)
    {
        $this->transaction = $transaction;
        $this->doctorBonus = $doctorBonus;
        $this->examinationTreatment = $examinationTreatment;
        $this->addonExamination = $addonExamination;
    }

    public function getIncome()
    {
        $doctor = session('doctor');
        $transactions = $this->transaction
            ->when(request()->filled('start_date') && request()->filled('end_date'), function ($query) {
                $query->where('created_at', '>=', request()->start_date.' 00:00:00')
                    ->where('created_at', '<=', request()->end_date.' 23:59:59');
            })
            ->where('is_paid', 1)
            ->where('doctor_id', $doctor->id)
            ->get();

        foreach ($transactions as $transaction) {
            $examinationTreatments = $this->examinationTreatment->where('examination_id', $transaction->examination_id)->get();
            foreach ($examinationTreatments as $examinationTreatment) {
                $doctorBonus = $this->doctorBonus->where('examination_treatment_id', $examinationTreatment->id)->sum('bonus');
                $examinationTreatment->doctor_bonus = $doctorBonus;
            }
            $transaction->examination_treatments = $examinationTreatments;
            $transaction->addonExamination = $this->addonExamination->where('examination_id', $transaction->examination_id)->get();
            $transaction->total_fee = $transaction->examination_treatments->sum('doctor_bonus') + $transaction->addonExamination->sum('fee');
        }

        $transactions = $transactions->map(function ($data) {
            return [
                'transaction_code' => $data->code,
                'transaction_date' => $data->created_at->format('Y-m-d'),
                'branch' => $data->branch->name,
                'branch_id' => $data->branch_id,
                'patient' => $data->customer->name,
                'doctor' => $data->doctor->name,
                'treatments' => $data->examination_treatments->map(function ($treatment) {
                    return $treatment->treatment->name;
                })->implode(', '),
                'total_fee_treatment' => $data->examination_treatments->sum('doctor_bonus'),
                'total_fee_addon' => $data->addonExamination->sum('fee'),
                'total_fee' => $data->total_fee,
            ];
        });

        return $transactions;
    }

    public function getStats()
    {
        $doctor = session('doctor');
        $transactions = $this->transaction
            ->with('branch', 'doctor', 'customer', 'examination', 'examination.examinationTreatments', 'examination.addonExaminations')
            ->where('is_paid', 1)->where('doctor_id', $doctor->id)->get();

        $transactions->map(function ($data) {
            $examinationTreatments = $data->examination->examinationTreatments;
            foreach ($examinationTreatments as $examinationTreatment) {
                $doctorBonus = $this->doctorBonus->where('examination_treatment_id', $examinationTreatment->id)->sum('bonus');
                $examinationTreatment->doctor_bonus = $doctorBonus;
            }
            $data->examination_treatments = $examinationTreatments;
            $data->addonExamination = $data->examination->addonExaminations;
            $data->total_fee = $data->examination_treatments->sum('doctor_bonus') + $data->addonExamination->sum('fee');
        })->toArray();

        return [
            'total_fee_today' => $transactions->where('created_at', '>=', now()->format('Y-m-d').' 00:00:00')->where('created_at', '<=', now()->format('Y-m-d').' 23:59:59')->sum('total_fee'),
            'total_fee' => $transactions->sum('total_fee'),
            'total_patient' => $transactions->groupBy('customer_id')->count(),
            'total_examination' => $transactions->count(),
        ];
    }
}
