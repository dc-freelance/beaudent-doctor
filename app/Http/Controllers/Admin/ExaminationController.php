<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ExaminationInterface;
use App\Interfaces\MedicalRecordInterface;
use App\Interfaces\QueueInterface;
use App\Interfaces\TransactionInterface;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    private $medicalRecord;
    private $reservation;
    private $examination;
    private $transaction;

    public function __construct(MedicalRecordInterface $medicalRecord, QueueInterface $reservation, ExaminationInterface $examination, TransactionInterface $transaction)
    {
        $this->medicalRecord = $medicalRecord;
        $this->reservation   = $reservation;
        $this->examination   = $examination;
        $this->transaction   = $transaction;
    }

    public function index()
    {
    }

    public function create($reservationId)
    {
        $reservation   = $this->reservation->getReservationById($reservationId);
        $medicalRecord = $this->medicalRecord->create($reservation);
        $doctor        = session('doctor');

        return view('doctor.examination.create', compact('reservation', 'medicalRecord', 'doctor'));
    }

    public function edit($id)
    {
        $data          = $this->examination->getById($id);
        $reservation   = $data['reservation'] ?? null;
        $medicalRecord = $data['medicalRecord'] ?? null;
        $doctor        = $data['doctor'] ?? null;
        return view('doctor.examination.edit', compact('data', 'reservation', 'medicalRecord', 'doctor'));
    }

    public function show($id)
    {
        $examination       = $this->examination->getById($id);
        $reservation       = $examination['reservation'];
        $medicalRecord     = $examination['medicalRecord'];
        $odontogramResults = $examination['odontogramResults'];
        $transaction       = $this->transaction->getByExaminationId($id);

        return view('doctor.queue.show', compact('reservation', 'medicalRecord', 'examination', 'odontogramResults', 'transaction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medical_record_id'        => ['required', 'exists:medical_records,id'],
            'customer_id'              => ['required', 'exists:customers,id'],
            'systolic_blood_pressure'  => ['required'],
            'diastolic_blood_pressure' => ['required'],
            'blood_type'               => ['required', 'in:A,B,AB,O'],
            'heart_disease'            => ['required', 'in:1,0'],
            'diabetes'                 => ['required', 'in:1,0'],
            'blood_clotting_disorder'  => ['required', 'in:1,0'],
            'hepatitis'                => ['required', 'in:1,0'],
            'digestive_diseases'       => ['required', 'in:1,0'],
            'other_diseases'           => ['required', 'in:1,0'],
            'allergies_to_medicines'   => ['required', 'in:1,0'],
            'medications'              => ['nullable'],
            'allergies_to_food'        => ['required', 'in:1,0'],
            'foods'                    => ['nullable'],
            'doctor_id'                => ['required', 'exists:doctors,id'],
            'reservation_id'           => ['required', 'exists:reservations,id'],
        ]);

        try {
            $examination = $this->examination->store($request->except('_token'));
            toast('Pemeriksaan berhasil disimpan', 'success');
            return redirect()->route('doctor.examinations.show', $examination->id);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            toast('Pemeriksaan gagal disimpan', 'error');

            return redirect()->back()->with('error', 'Pemeriksaan gagal disimpan');
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'medical_record_id'        => ['required', 'exists:medical_records,id'],
            'customer_id'              => ['required', 'exists:customers,id'],
            'systolic_blood_pressure'  => ['required'],
            'diastolic_blood_pressure' => ['required'],
            'blood_type'               => ['required', 'in:A,B,AB,O'],
            'heart_disease'            => ['required', 'in:1,0'],
            'diabetes'                 => ['required', 'in:1,0'],
            'blood_clotting_disorder'  => ['required', 'in:1,0'],
            'hepatitis'                => ['required', 'in:1,0'],
            'digestive_diseases'       => ['required', 'in:1,0'],
            'other_diseases'           => ['required', 'in:1,0'],
            'allergies_to_medicines'   => ['required', 'in:1,0'],
            'medications'              => ['nullable'],
            'allergies_to_food'        => ['required', 'in:1,0'],
            'foods'                    => ['nullable'],
            'doctor_id'                => ['required', 'exists:doctors,id'],
            'reservation_id'           => ['required', 'exists:reservations,id'],
        ]);

        try {
            $this->examination->update($id, $request->except('_token'));
            toast('Pemeriksaan berhasil diupdate', 'success');
            return redirect()->route('doctor.examinations.show', $id);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            toast('Pemeriksaan gagal diupdate', 'error');

            return redirect()->back()->with('error', 'Pemeriksaan gagal diupdate');
        }
    }
}
