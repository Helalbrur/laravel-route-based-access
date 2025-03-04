<?php

namespace App\Exports;

use App\Models\LibSupplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LibSupplierExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LibSupplier::with(['country', 'tagCompany', 'tagParty'])->get();
    }

    public function headings(): array
    {
        return [
            'Supplier Name',
            'Short Name',
            'Country',
            'Company Names',
            'Party Types',
            'Contact Person',
            'Contact No',
            'Website',
            'Email',
            'Address',
        ];
    }

    public function map($supplier): array
    {
        return [
            $supplier->supplier_name,
            $supplier->short_name,
            $supplier->country->country_name ?? '',
            $supplier->tagCompany->pluck('company_name')->implode(', '),
            $supplier->tagParty->pluck('party_type')->implode(', '),
            $supplier->contact_person,
            $supplier->contact_no,
            $supplier->web_site,
            $supplier->email,
            $supplier->address,
        ];
    }
}
