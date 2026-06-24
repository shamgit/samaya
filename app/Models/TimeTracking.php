<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTracking extends Model
{
    use HasFactory;

    protected $primaryKey = 'time_tracking_id';

    protected $table = 'time_trackings';

    protected $fillable = [

        'employee_id',

        'employee_code',

        'designation_id',

        'department_id',

        'project_task',

        'form_date',

        'start_time',

        'end_time',

        'total_work_hours',

        'dask_description',

        'status',

        'deleted',

        'created_by',

        'updated_by'
    ];
}
