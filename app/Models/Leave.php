<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $primaryKey = 'leave_id';

    protected $fillable = [

        'employee_id',

        'employee_code',

        'designation_id',

        'department_id',

        'leave_type_id',

        'from_date',

        'to_date',

        'reason',

        'manager_approval',

        'leave_status',

        'deleted',

        'created_by',

        'updated_by',
    ];
}