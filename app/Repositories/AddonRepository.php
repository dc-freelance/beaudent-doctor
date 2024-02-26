<?php

namespace App\Repositories;

use App\Interfaces\AddonInterface;
use App\Models\Addon;

class AddonRepository implements AddonInterface
{
    private $addon;

    public function __construct(Addon $addon)
    {
        $this->addon = $addon;
    }

    public function getAll()
    {
        return $this->addon->all();
    }
}
