<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $employee_id;

    public function __construct($employee_id = null)
    {
        $this->employee_id = $employee_id;
    }

    public function collection()
    {
       $query = Attendance::leftJoin(
            'employees',
            'employees.employee_id',
            '=',
            'attendances.employee_id'
        )
        ->leftJoin(
            'departments',
            'departments.department_id',
            '=',
            'attendances.department_id'
        )
        ->leftJoin(
            'attendance_status',
            'attendance_status.attendance_statu_id',
            '=',
            'attendances.attendance_status_id'
        )
        ->select(
            'employees.employee_code',
            'employees.employee_name',
            'departments.name as department_name',
             DB::raw("DATE_FORMAT(attendances.attendance_date, '%d %b %Y') as attendance_date"),
            'attendances.check_in',
            'attendances.check_out',
            'attendance_status.attendance_status_name as attendance_status_id'
        )
        ->orderBy('attendances.attendance_date', 'desc')
        ->where('attendances.deleted', 0);

        if ($this->employee_id) {
            $query->where(
                'attendances.employee_id',
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
            'Attendance Date',
            'Check In',
            'Check Out',
            'Status'
        ];
    }
}