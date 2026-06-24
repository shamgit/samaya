<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierExport implements FromCollection, WithHeadings
{
    protected $supplier_id;

    public function __construct($supplier_id = null)
    {
        $this->supplier_id = $supplier_id;
    }

    public function collection()
    {
        $query = Supplier::leftJoin(
                'category',
                'category.category_id',
                '=',
                'suppliers.category_id'
            )
            ->leftJoin(
                'payment_terms',
                'payment_terms.payment_term_id',
                '=',
                'suppliers.payment_term_id'
            )
            ->select(
                'suppliers.supplier_name',
                'suppliers.contact_person_name',
                'category.category_name',
                'suppliers.phone',
                'suppliers.email',
                'suppliers.address',
                'suppliers.city',
                'suppliers.state',
                'suppliers.zip_code',
                'suppliers.gst_tex',
                'payment_terms.name as payment_term_name'
            )
            ->where('suppliers.deleted', 0)
            ->orderBy('suppliers.supplier_id', 'desc');

        if ($this->supplier_id) {
            $query->where(
                'suppliers.supplier_id',
                $this->supplier_id
            );
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Supplier Name',
            'Contact Person',
            'Category',
            'Phone',
            'Email',
            'Address',
            'City',
            'State',
            'Zip Code',
            'GST/TAX',
            'Payment Terms',
        ];
    }
}
