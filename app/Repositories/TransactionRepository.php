<?php

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\AddonExamination;
use App\Models\Branch;
use App\Models\DoctorBonus;
use App\Models\Examination;
use App\Models\ExaminationItem;
use App\Models\ExaminationTreatment;
use App\Models\Sequence;
use App\Models\Transaction;
use App\Models\TreatmentBonus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionRepository implements TransactionInterface
{
    private $transaction;
    private $branch;
    private $sequence;
    private $examinationTreatment;
    private $examinationItem;
    private $examinationAddon;
    private $treatmentBonus;
    private $examination;
    private $doctorBonus;

    public function __construct(Transaction $transaction, Branch $branch, Sequence $sequence, ExaminationTreatment $examinationTreatment, ExaminationItem $examinationItem, AddonExamination $examinationAddon, TreatmentBonus $treatmentBonus, Examination $examination, DoctorBonus $doctorBonus)
    {
        $this->transaction          = $transaction;
        $this->branch               = $branch;
        $this->sequence             = $sequence;
        $this->examinationTreatment = $examinationTreatment;
        $this->examinationItem      = $examinationItem;
        $this->examinationAddon     = $examinationAddon;
        $this->treatmentBonus       = $treatmentBonus;
        $this->examination          = $examination;
        $this->doctorBonus          = $doctorBonus;
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $doctor = session('doctor');
            $examinationTreatments = $this->examinationTreatment->where('examination_id', $data['examination_id'])->get();
            foreach ($examinationTreatments as $examinationTreatment) {
                $treatmentBonus = $this->treatmentBonus->where('treatment_id', $examinationTreatment->treatment_id)->first();
                if ($treatmentBonus->doctor_category_id == $doctor->id) {
                    if (strtolower($treatmentBonus->bonus_type) == 'percentage') {
                        $totalBonus = $examinationTreatment->sub_total * $treatmentBonus->bonus_rate / 100;
                        $this->doctorBonus->create([
                            'examination_treatment_id' => $examinationTreatment->id,
                            'doctor_id'                => $doctor->id,
                            'bonus'                    => $totalBonus,
                            'branch_id'                => $data['branch_id'],
                        ]);
                    } else {
                        $totalBonus = $treatmentBonus->bonus_rate;
                        $this->doctorBonus->create([
                            'examination_treatment_id' => $examinationTreatment->id,
                            'doctor_id'                => $doctor->id,
                            'bonus'                    => $totalBonus,
                            'branch_id'                => $data['branch_id'],
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        try {
            $data['date_time'] = date('Y-m-d H:i:s');
            $data['code']      = 'BEU-' . $this->generateTransactionCode('PYMNT', date('Y'), date('m'), $data['branch_id']);

            // TODO:  Hitung di billing
            $data['ppn_status']  = 'Without';
            $data['discount']    = 0;
            $data['total_ppn']   = 0;
            $data['grand_total'] = $data['total'];

            $this->transaction->create($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        try {
            $reservation = $this->examination->find($data['examination_id'])->reservation;
            $reservation->examination_status = 1;
            $reservation->status = 'Done';
            $reservation->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
    }

    public function getByExaminationId($examination_id)
    {
        return $this->transaction->where('examination_id', $examination_id)->first();
    }

    public function generateTransactionCode($prefix, $year, $month, $branch_id)
    {
        $sequence = $this->sequence->where('code', $prefix)
            ->where('year', $year)
            ->where('month', $month)
            ->where('branch_id', $branch_id)
            ->first();

        if ($sequence) {
            $sequence->increment('no');
        } else {
            $sequence = $this->sequence->create([
                'code'      => $prefix,
                'year'      => $year,
                'month'     => $month,
                'branch_id' => $branch_id,
                'no'        => 1,
            ]);
        }

        $sequence->no = str_pad($sequence->no, 3, '0', STR_PAD_LEFT);

        return $sequence->code . '-' . $sequence->year . '-' . $sequence->month . '-' . $sequence->no;
    }

    public function addTreatment($data)
    {
        try {
            $proofFilename = uniqid() . '.' . $data['proof']->extension();
            $data['proof']->storeAs('public/exmtreatment-proof', $proofFilename);
            $data['proof'] = $proofFilename;

            $this->examinationTreatment->create($data);
            $treatments = $this->examinationTreatment
                ->with('treatment')
                ->where('examination_id', $data['examination_id'])->get();
            return $treatments;
        } catch (\Throwable $th) {
            Storage::delete('public/exmtreatment-proof/' . $proofFilename);
            throw $th;
        }
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
        Storage::delete('public/exmtreatment-proof/' . $examinationTreatment->proof);
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

    public function getTransactionSummary($examination_id)
    {
        $treatments = $this->examinationTreatment
            ->where('examination_id', $examination_id)
            ->sum('sub_total');

        $items = $this->examinationItem
            ->where('examination_id', $examination_id)
            ->sum('sub_total');

        $addons = $this->examinationAddon
            ->where('examination_id', $examination_id)
            ->sum('sub_total');

        $treatments = $treatments ?? 0;
        $items      = $items ?? 0;
        $addons     = $addons ?? 0;

        return [
            'treatments' => $treatments,
            'items'      => $items,
            'addons'     => $addons,
            'total'      => $treatments + $items + $addons,
        ];
    }
}
