<?php

namespace App\Repositories;

use App\Interfaces\CustomerInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerInterface
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getAll()
    {
        return $this->customer->all();
    }
}
