<?php

namespace App\Repositories;

use App\Interfaces\ExaminationInterface;
use App\Models\Customer;
use App\Models\Examination;
use Carbon\Carbon;

class ExaminationRepository implements ExaminationInterface
{
    private $examination;
    private $customer;

    public function __construct(Examination $examination, Customer $customer)
    {
        $this->examination = $examination;
        $this->customer = $customer;
    }

    public function getById($id)
    {
        return $this->examination->with(
            'reservation',
            'doctor',
            'medicalRecord',
            'customer',
            'odontogramResults'
        )->find($id);
    }

    public function getExaminationByTransactionId($transactionId)
    {
        return $this->examination->where('transaction_id', $transactionId)->first();
    }

    public function store($data)
    {
        $examination = $this->examination->updateOrCreate(
            [
                'reservation_id'    => $data['reservation_id'],
                'doctor_id'         => $data['doctor_id'],
                'medical_record_id' => $data['medical_record_id'],
            ],
            [
                'reservation_id'           => $data['reservation_id'],
                'doctor_id'                => $data['doctor_id'],
                'medical_record_id'        => $data['medical_record_id'],
                'customer_id'              => $data['customer_id'],
                'examination_date'         => Carbon::now()->locale('id')->isoFormat('YYYY-MM-DD'),
                'systolic_blood_pressure'  => $data['systolic_blood_pressure'],
                'diastolic_blood_pressure' => $data['diastolic_blood_pressure'],
                'blood_type'               => $data['blood_type'],
                'heart_disease'            => $data['heart_disease'],
                'diabetes'                 => $data['diabetes'],
                'blood_clotting_disorder'  => $data['blood_clotting_disorder'],
                'hepatitis'                => $data['hepatitis'],
                'digestive_diseases'       => $data['digestive_diseases'],
                'other_diseases'           => $data['other_diseases'],
                'allergies_to_medicines'   => $data['allergies_to_medicines'],
                'medications'              => $data['medications'] ?? null,
                'allergies_to_food'        => $data['allergies_to_food'],
                'foods'                    => $data['foods'] ?? null,
            ]
        );

        return $examination;
    }

    public function update($id, $data)
    {
        $examination = $this->examination->find($id);
        $examination->update($data);

        return $examination;
    }

    public function getAllExaminationGroupByCustomer()
    {
        $customers = $this->customer->with('examinations')->has('examinations')->get();
        return $customers;
    }

    public function getExaminationByCustomerId($customerId)
    {
        $examinations = $this->customer->with('examinations')->find($customerId);
        return $examinations;
    }
}
