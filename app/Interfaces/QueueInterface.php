<?php

namespace App\Interfaces;

interface QueueInterface
{
    public function getAllReservation();

    public function getReservationById($id);

    public function updateExaminationStatus($id, $status);
}
