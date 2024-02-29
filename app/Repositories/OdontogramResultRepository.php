<?php

namespace App\Repositories;

use App\Interfaces\OdontogramResultInterface;
use App\Models\Odontogram;
use App\Models\OdontogramResult;

class OdontogramResultRepository implements OdontogramResultInterface
{
    private $odontogramResult;
    private $odontogram;

    public function __construct(OdontogramResult $odontogramResult, Odontogram $odontogram)
    {
        $this->odontogramResult = $odontogramResult;
        $this->odontogram       = $odontogram;
    }

    public function get()
    {
        return $this->odontogramResult->all();
    }

    public function getByExaminationId($examinationId)
    {
        return $this->odontogramResult->where('examination_id', $examinationId)->get();
    }

    public function groupOdontogramResults($odontogramResults)
    {
        $groupedOdontogramResults = $odontogramResults->groupBy('tooth_number');

        foreach ($groupedOdontogramResults as $toothNumber => $toothPositions) {
            $groupedOdontogramResults[$toothNumber] = [
                'img_name' => $toothPositions->first()['img_name'],
                'side'     => $toothPositions->first()['side'] ?? null,
                'top'      => $toothPositions->where('tooth_position', 'top')->first()['diagnosis'] ?? null,
                'bottom'   => $toothPositions->where('tooth_position', 'bottom')->first()['diagnosis'] ?? null,
                'left'     => $toothPositions->where('tooth_position', 'left')->first()['diagnosis'] ?? null,
                'right'    => $toothPositions->where('tooth_position', 'right')->first()['diagnosis'] ?? null,
                'center'   => $toothPositions->where('tooth_position', 'center')->first()['diagnosis'] ?? null,
                'all'      => $toothPositions->where('tooth_position', 'all')->map(function ($item) {
                    return [
                        'id'         => $item['id'],
                        'diagnosis'  => $item['diagnosis'],
                        'remark'     => $item['remark'],
                        'odontogram' => $this->odontogram->find($item['odontogram_id']),
                        'is_outside' => $this->odontogram->find($item['odontogram_id'])->is_outside,
                    ];
                }),
            ];
        }

        return $groupedOdontogramResults;
    }

    public function deleteDiagnose($id)
    {
        return $this->odontogramResult->find($id)->delete();
    }

    public function getByToothNumber($toothNumber, $examinationId)
    {
        return $this->odontogramResult->where('tooth_number', $toothNumber)->where('examination_id', $examinationId)->get();
    }

    public function groupOdontogramResultByToothNumber($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = [
                'id'           => $value['id'],
                'tooth_number' => $value['tooth_number'],
                'top'          => $value['tooth_position'] === 'top' ? $value['diagnosis'] : null,
                'bottom'       => $value['tooth_position'] === 'bottom' ? $value['diagnosis'] : null,
                'left'         => $value['tooth_position'] === 'left' ? $value['diagnosis'] : null,
                'right'        => $value['tooth_position'] === 'right' ? $value['diagnosis'] : null,
                'center'       => $value['tooth_position'] === 'center' ? $value['diagnosis'] : null,
                'all'          => $value['tooth_position'] === 'all' ? $value['diagnosis'] : null,
                'is_outside'   => $this->odontogram->find(($value['odontogram_id']))->is_outside,
                'img_name'     => $value['img_name'] ?? '',
                'side'         => $value['side'] ?? '',
            ];
        }

        return $data;
    }

    public function storeDiagnose($data)
    {

        $imgName = last(explode('/', $data['img_name']));

        if ($data['tooth_position'] === 'all') {
            $odontogramResult = $this->odontogramResult->create([
                'examination_id' => $data['examination_id'],
                'tooth_number'   => $data['tooth_number'],
                'tooth_position' => $data['tooth_position'],
                'odontogram_id'  => $data['odontogram_id'],
                'img_name'       => $imgName,
                'side'           => $data['side'],
                'diagnosis'      => $data['diagnosis'],
                'remark'         => $data['remark'] ?? null,
            ]);
        } else {
            $odontogramResult = $this->odontogramResult->updateOrCreate(
                [
                    'examination_id' => $data['examination_id'],
                    'tooth_number'   => $data['tooth_number'],
                    'tooth_position' => $data['tooth_position'],
                ],
                [
                    'odontogram_id' => $data['odontogram_id'],
                    'img_name'      => $imgName,
                    'side'          => $data['side'],
                    'diagnosis'     => $data['diagnosis'],
                    'remark'        => $data['remark'] ?? null,
                ]
            );
        }

        $odontogramResult = $this->odontogramResult->where([
            ['examination_id', $data['examination_id']],
            ['tooth_number', $data['tooth_number']],
        ])->get();

        $odontogramResult = $this->groupOdontogramResultAfterStore($odontogramResult);

        return $odontogramResult;
    }

    private function groupOdontogramResultAfterStore($data)
    {
        $singleData = [
            'img_name'     => $data->first()['img_name'] ?? '',
            'id'           => $data->first()['id'],
            'tooth_number' => $data->first()['tooth_number'],
            'side'         => $data->first()['side'] ?? '',
        ];

        $positions = ['top', 'bottom', 'left', 'right', 'center'];
        foreach ($positions as $position) {
            $singleData[$position] = $data->where('tooth_position', $position)->first()['diagnosis'] ?? null;
        }

        $singleData['all'] = $data->where('tooth_position', 'all')->map(function ($item) {
            return [
                'id'         => $item['id'],
                'diagnosis'  => $item['diagnosis'],
                'remark'     => $item['remark'],
                'odontogram' => $this->odontogram->find(($item['odontogram_id'])),
                'is_outside' => $this->odontogram->find(($item['odontogram_id']))->is_outside,
            ];
        });

        return $singleData;
    }

    public function groupOdontogramResultsForTable($odontogramResults)
    {
        $odontograms = $this->odontogramResult->get()->groupBy('tooth_number');
        return $odontograms;
    }
}
