<?php
namespace App\Imports;

use App\Models\Company;
use App\Models\LibBuyer;
use App\Models\LibCountry;
use App\Models\LibBuyerTagParty;
use App\Models\LibBuyerTagCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LibBuyerImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        //dd($row);
        return DB::transaction(function () use ($row) {
            $countryId = $this->getCountryId($row['country_name']);
            $companyIds = $this->getCompanyIds($row['company_name']);
            $partyTypeIds = $this->getPartyTypeIds($row['party_type']);

            $lib_buyer = LibBuyer::create([
                'buyer_name'    => $row['buyer_name'],
                'short_name'    => $row['short_name'],
                'country_id'    => $countryId,
                'tag_company'   => implode(",", $companyIds),
                'party_type'    => implode(",", $partyTypeIds),
                'contact_person'=> $row['contact_person'],
                'contact_no'    => $row['contact_no'],
                'web_site'      => $row['website'],
                'email'         => $row['email'],
                'address'       => $row['address'],
                'created_by'    => Auth::id(),
            ]);

            // Insert companies
            foreach ($companyIds as $companyId) {
                LibBuyerTagCompany::create([
                    'company_id' => $companyId,
                    'buyer_id'   => $lib_buyer->id,
                ]);
            }

            // Insert party types
            foreach ($partyTypeIds as $partyTypeId) {
                LibBuyerTagParty::create([
                    'party_type' => $partyTypeId,
                    'buyer_id'   => $lib_buyer->id,
                ]);
            }

            return $lib_buyer;
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
            $id = array_search(trim($partyTypeName), party_type());
            if ($id !== false) {
                $partyTypeIds[] = $id;
            }
        }

        return $partyTypeIds;
    }
}
