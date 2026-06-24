<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';

    protected $fillable = [

        'employee_id',
        'department_id',
        'employee_code',
        'attendance_date',
        'check_in',
        'check_out',
        'attendance_status_id',
        'created_by',
        'updated_by',
        'deleted',
        'test',

    ];

    // Employee Relation
    public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'employee_id'
        );
    }

    // Attendance Status Relation
    public function attendanceStatus()
    {
        return $this->belongsTo(
            AttendanceStatus::class,
            'attendance_status_id',
            'attendance_statu_id'
        );
    }
    
}
