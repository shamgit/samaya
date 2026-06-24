<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAppraisal extends Model
{
    protected $primaryKey = 'appraisal_id';

    protected $fillable = [
        'employee_id',
        'employee_code',
        'designation_id',
        'department_id',
        'review_period',
        'rating_scale',
        'salary_increment_recommendation',
        'manager_feedback',
        'status'
    ];

        public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'employee_id'
        );
    }
}
