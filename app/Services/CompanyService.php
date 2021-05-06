<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyService
{
    private $company;

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function save(Request $request)
    {
        $this->company->title = $request->title;
        $this->company->phone_number = $request->phone_number;
        $this->company->tax_number = $request->tax_number;
        $this->company->tax_office = $request->tax_office;
        $this->company->custom_discount = $request->custom_discount;
        $this->company->invoice_address = $request->invoice_address;
        $this->company->save();

        return $this->company;
    }
}
