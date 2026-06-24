<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    protected $employee_id;

    public function __construct($employee_id = null)
    {
        $this->employee_id = $employee_id;
    }

    public function collection()
    {
        $query = Employee::leftJoin(
                'departments',
                'departments.department_id',
                '=',
                'employees.department_id'
            )
            ->leftJoin(
                'designations',
                'designations.designation_id',
                '=',
                'employees.designation_id'
            )
            ->select(
                'employees.employee_code',
                'employees.employee_name',
                'employees.email',
                'employees.phone',
                'departments.name as department_name',
                'designations.name as designation_name',
                'employees.joining_date'
            )
            ->where('employees.deleted', 0);

        if ($this->employee_id) {
            $query->where(
                'employees.employee_id',
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
            'Email',
            'Phone',
            'Department',
            'Designation',
            'Joining Date'
        ];
    }
}