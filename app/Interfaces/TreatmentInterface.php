<?php

namespace App\Interfaces;

interface TreatmentInterface
{
    public function getAll();

    public function getById($id);
}
