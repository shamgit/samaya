<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class PayrollExport implements FromCollection, WithHeadings
{
    protected $employee_id;

    public function __construct($employee_id = null)
    {
        $this->employee_id = $employee_id;
    }

    public function collection()
    {
       $query = Payroll::leftJoin('employees','employees.employee_id','=','payrolls.employee_id')
        ->leftJoin('departments','departments.department_id','=','payrolls.department_id' )
        ->select(
            'payrolls.employee_code',
            'employees.employee_name',
            'departments.name as department_name',
            'payrolls.basic_salary',
            'payrolls.net_allowance',
            'payrolls.net_deduction',
            'payrolls.net_salary',
             DB::raw("
                CASE
                    WHEN payrolls.payroll_status = 1 THEN 'Pending'
                    WHEN payrolls.payroll_status = 2 THEN 'Processed'
                    ELSE 'Unknown'
                END as payroll_status
            ")
        )
        ->orderBy('payrolls.payroll_id', 'desc')
        ->where('payrolls.deleted', 0);

        if ($this->employee_id) {
            $query->where(
                'payrolls.employee_id',
                $this->employee_id
            );
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Employee Name',
            'Department',
            'Basic Salary',
            'Allowances',
            'Deductions',
            'Net Salary',
            'Status',
        ];
    }
}