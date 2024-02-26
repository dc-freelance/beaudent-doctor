<?php

namespace App\Repositories;

use App\Interfaces\OdontogramInterface;
use App\Models\Odontogram;
use App\Models\OdontogramResult;

class OdontogramRepository implements OdontogramInterface
{
    private $odontogram;

    public function __construct(Odontogram $odontogram)
    {
        $this->odontogram = $odontogram;
    }

    public function get()
    {
        return $this->odontogram->get();
    }
}
