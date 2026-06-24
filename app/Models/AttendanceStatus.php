<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AttendanceStatus extends Model 
{

    protected $table = 'attendance_status';

    protected $primaryKey = 'attendance_statu_id';

    protected $fillable = [
        'attendance_status_name', 
        'deleted',
        'created_by',
        'updated_by'
    ];

        public function attendances()
    {
        return $this->hasMany(
            Attendance::class,
            'attendance_status_id',
            'attendance_statu_id'
        );
    }
}