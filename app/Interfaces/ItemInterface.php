<?php

namespace App\Interfaces;

interface ItemInterface
{
    public function getAll();
    public function getById($id);
}
