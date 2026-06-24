<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PurchaseRequestStatus extends Model 
{

    protected $table = 'purchase_request_status';

    protected $primaryKey = 'purchase_request_status_id';

    protected $fillable = [
        'name', 
        'deleted',
        'created_by',
        'updated_by'
    ];
}