<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;

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

    public function save(Request $request)
    {
        $this->customer->company_id = $request->company_id;
        $this->customer->name = $request->name;
        $this->customer->surname = $request->surname;
        $this->customer->title = $request->title;
        $this->customer->phone_number = $request->phone_number;
        $this->customer->email = $request->email;
        $this->customer->nationality_id = $request->nationality_id;
        $this->customer->gender = $request->gender;
        $this->customer->marriage = $request->marriage;
        $this->customer->identity_type_id = $request->identity_type_id;
        $this->customer->identity_expiration_date = $request->identity_expiration_date;
        $this->customer->identity_number = $request->identity_number;
        $this->customer->passport_number = $request->passport_number;
        $this->customer->birth_date = $request->birth_date;
        $this->customer->birth_place = $request->birth_place;
        $this->customer->mother_name = $request->mother_name;
        $this->customer->father_name = $request->father_name;
        $this->customer->save();

        return $this->customer;
    }

    public function getCustomersByKeyword($keyword)
    {
        return Customer::where('name', 'like', '%' . $keyword . '%')->get();
    }
}
