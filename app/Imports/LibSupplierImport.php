<?php

namespace App\Imports;

use App\Models\LibSupplier;
use App\Models\LibSupplierTagCompany;
use App\Models\LibSupplierTagParty;
use App\Models\LibCountry;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LibSupplierImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            $countryId = $this->getCountryId($row['country_name']);
            $companyIds = $this->getCompanyIds($row['company_name']);
            $partyTypeIds = $this->getPartyTypeIds($row['party_type']);

            $lib_supplier = LibSupplier::create([
                'supplier_name'  => $row['supplier_name'],
                'short_name'     => $row['short_name'],
                'country_id'     => $countryId,
                'tag_company'    => implode(",", $companyIds),
                'party_type'     => implode(",", $partyTypeIds),
                'contact_person' => $row['contact_person'],
                'contact_no'     => $row['contact_no'],
                'web_site'       => $row['website'],
                'email'          => $row['email'],
                'address'        => $row['address'],
                'created_by'     => Auth::id(),
            ]);

            // Insert related companies
            foreach ($companyIds as $companyId) {
                LibSupplierTagCompany::create([
                    'company_id' => $companyId,
                    'supplier_id' => $lib_supplier->id,
                ]);
            }

            // Insert related party types
            foreach ($partyTypeIds as $partyTypeId) {
                LibSupplierTagParty::create([
                    'party_type' => $partyTypeId,
                    'supplier_id' => $lib_supplier->id,
                ]);
            }

            return $lib_supplier;
        });
    }

    private function getCountryId($countryName)
    {
        return LibCountry::where('country_name', trim($countryName))->value('id') ?? null;
    }

    private function getCompanyIds($companyNames)
    {
        $companyNamesArray = explode(',', $companyNames);
        return Company::whereIn('company_name', array_map('trim', $companyNamesArray))->pluck('id')->toArray();
    }

    private function getPartyTypeIds($partyTypeNames)
    {
        $partyTypeArray = explode(',', $partyTypeNames);
        $partyTypeIds = [];

        foreach ($partyTypeArray as $partyTypeName) {
            $id = array_search(trim($partyTypeName), party_type_supplier());
            if ($id !== false) {
                $partyTypeIds[] = $id;
            }
        }

        return $partyTypeIds;
    }
}
