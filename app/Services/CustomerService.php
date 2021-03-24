<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    private $customer;

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getCustomersByKeyword($keyword)
    {
        return Customer::where('name', 'like', '%' . $keyword . '%')->get();
    }
}
