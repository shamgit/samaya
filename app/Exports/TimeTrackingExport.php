<?php

namespace App\Exports;

use App\Models\TimeTracking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimeTrackingExport implements FromCollection, WithHeadings
{
    protected $employee_id;

    public function __construct($employee_id = null)
    {
        $this->employee_id = $employee_id;
    }

    public function collection()
    {
       $query = TimeTracking::leftJoin('employees','employees.employee_id','=','time_trackings.employee_id' )
        ->select(
            'time_trackings.employee_code',
            'employees.employee_name',
            'time_trackings.project_task',
            'time_trackings.total_work_hours',
            'time_trackings.form_date',
        )
        ->orderBy('time_trackings.form_date', 'desc')
        ->where('time_trackings.deleted', 0);

        if ($this->employee_id) {
            $query->where(
                'time_trackings.employee_id',
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
            'Project / Task',
            'Work Hours',
            'Date',
        ];
    }
}