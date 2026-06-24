<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LeaveTypes extends Model 
{

    protected $table = 'leave_types';

    protected $primaryKey = 'leave_type_id';

    protected $fillable = [
        'name', 
        'deleted',
        'created_by',
        'updated_by'
    ];
}