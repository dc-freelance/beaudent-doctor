<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AddonInterface;
use App\Interfaces\ExaminationInterface;
use App\Interfaces\ItemInterface;
use App\Interfaces\TransactionInterface;
use App\Interfaces\TreatmentInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transaction;
    private $examination;
    private $treatment;
    private $item;
    private $addon;

    public function __construct(TransactionInterface $transaction, ExaminationInterface $examination, TreatmentInterface $treatment, ItemInterface $item, AddonInterface $addon)
    {
        $this->transaction = $transaction;
        $this->examination = $examination;
        $this->treatment   = $treatment;
        $this->item        = $item;
        $this->addon       = $addon;
    }

    public function create($examination_id)
    {
        $transaction       = $this->transaction->getByExaminationId($examination_id);
        $examination       = $this->examination->getById($examination_id);
        $branchId          = $examination->reservation->branch_id;
        $transactionCode   = $this->transaction->generateTransactionCode('PCH', date('Y'), date('m'), $branchId);
        $treatmentDiscount = $examination->reservation->treatment->discountTreatment->discount;

        // Master
        $treatments            = $this->treatment->getAll();
        $items                 = $this->item->getAll();
        $addons                = $this->addon->getAll();
        $examinationTreatments = $this->transaction->getExaminationTreatments($examination_id);
        $examinationItems      = $this->transaction->getExaminationItems($examination_id);
        $examinationAddons     = $this->transaction->getExaminationAddons($examination_id);
        $doctorId              = session('doctor')->id;


        return view('doctor.transaction.create', compact('transaction', 'examination', 'transactionCode', 'treatmentDiscount', 'treatments', 'examinationTreatments', 'items', 'examinationItems', 'addons', 'doctorId', 'examinationAddons'));
    }

    public function addTreatment(Request $request)
    {
        $request->validate([
            'examination_id' => 'required|numeric',
            'treatment_id'   => 'required|numeric',
            'qty'            => 'required|numeric',
            'sub_total'      => 'required|numeric',
        ]);

        $this->transaction->addTreatment($request->except('_token'));
        return response()->json(true);
    }

    public function removeTreatment(Request $request)
    {
        $this->transaction->removeTreatment($request->id);
        return response()->json(true);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'examination_id'   => ['required', 'numeric'],
            'item_id'          => ['required', 'numeric'],
            'qty'              => ['required', 'numeric'],
            'sub_total'        => ['required', 'numeric'],
            'note_interaction' => ['nullable', 'string'],
            'amount_a_day'     => ['nullable', 'numeric'],
            'days'             => ['nullable', 'numeric'],
            'period'           => ['nullable', 'string'],
            'guide'            => ['nullable', 'string'],
        ]);

        $this->transaction->addItem($request->except('_token'));
        return response()->json(true);
    }

    public function removeItem(Request $request)
    {
        $this->transaction->removeItem($request->id);
        return response()->json(true);
    }

    public function addAddon(Request $request)
    {
        $request->validate([
            'examination_id' => ['required', 'numeric'],
            'user_id'        => ['nullable', 'numeric'],
            'addon_id'       => ['required', 'numeric'],
            'sub_total'      => ['required', 'numeric'],
            'fee'            => ['required', 'numeric'],
        ]);

        $request['doctor_id'] = session('doctor')->id;
        $this->transaction->addAddon($request->except('_token'));
        return response()->json(true);
    }

    public function removeAddon(Request $request)
    {
        $this->transaction->removeAddon($request->id);
        return response()->json(true);
    }
}
