<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\LibBuyer;
use App\Models\LibCountry;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LibBuyerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LibBuyer::all()->map(function ($buyer) {
            return [
                'buyer_name'     => $buyer->buyer_name,
                'short_name'     => $buyer->short_name,
                'country_id'     => $this->getCountryNames($buyer->country_id),
                'tag_company'    => $this->getCompanyNames($buyer->tag_company),
                'party_type'     => $this->getPartyTypes($buyer->party_type),
                'contact_person' => $buyer->contact_person,
                'contact_no'     => $buyer->contact_no,
                'web_site'       => $buyer->web_site,
                'email'          => $buyer->email,
                'address'        => $buyer->address,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Buyer Name',
            'Short Name',
            'Country Name',
            'Company Name',
            'Party Type',
            'Contact Person',
            'Contact No',
            'Website',
            'Email',
            'Address'
        ];
    }

    private function getCountryNames($countryIds)
    {
        $countryIdsArray = explode(',', $countryIds);
        $countries = LibCountry::whereIn('id', $countryIdsArray)->pluck('country_name')->toArray();
        return implode(', ', $countries);
    }

    private function getCompanyNames($companyIds)
    {
        $companyIdsArray = explode(',', $companyIds);
        $companies = Company::whereIn('id', $companyIdsArray)->pluck('company_name')->toArray();
        return implode(', ', $companies);
    }

    private function getPartyTypes($partyTypes)
    {
        $partyTypeIds = explode(',', $partyTypes);
        $partyTypeNames = array_map(fn($id) => party_type()[$id] ?? $id, $partyTypeIds);
        return implode(', ', $partyTypeNames);
    }
}
