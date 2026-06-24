<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisition extends Model
{
    protected $fillable = [

        'requisition_id',
        'department_id',
        'requested',
        'request_date',
        'required_date',
        'priority',
        'remarks',
        'status'
    ];

    public function details()
    {
        return $this->hasMany(PurchaseRequisitionDetail::class);
    }

    public function department()
{
    return $this->belongsTo(
        Department::class,
        'department_id',
        'department_id'
    );
}
}