<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payrolls';

    protected $primaryKey = 'payroll_id';

    protected $fillable = [

        'employee_id',

        'employee_code',

        'designation_id',

        'department_id',

        'pay_period_start_date',

        'pay_period_end_date',

        'pay_date',

        'basic_salary',

        'hra',

        'transport_allowance',

        'other_allowance',

        'total_allowance',

        'pf',

        'professional_tax',

        'other_deduction',

        'total_deduction',

        'income_tax',
        
        'net_basic_salary',
        
        'net_allowance',

        'net_deduction',

        'net_salary',

        'payroll_status',

        'created_by',

        'updated_by'
    ];
}
