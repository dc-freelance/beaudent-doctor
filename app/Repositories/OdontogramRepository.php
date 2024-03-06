<?php

namespace App\Repositories;

use App\Interfaces\OdontogramInterface;
use App\Models\Odontogram;

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
