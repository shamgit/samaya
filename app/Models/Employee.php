<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $primaryKey = 'employee_id';

    protected $fillable = [

        'designation_id',
        'department_id',
        'role_id',
        'employee_name',
        'employee_code',
        'phone',
        'date_of_birth',
        'gender',
        'email',
        'address',
        'city',
        'state',
        'zip_code',
        'joining_date',
        'employee_type',
        'company_name',
        'employee_document',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'bank_address',
        'pf_number',
        'payment_type',
        'basic_salary',
        'allowances',
        'total_salary',
        'status',
        'created_by',
        'updated_by'
    ];

        public function attendances()
    {
        return $this->hasMany(
            Attendance::class,
            'employee_id',
            'employee_id'
        );
    }
}