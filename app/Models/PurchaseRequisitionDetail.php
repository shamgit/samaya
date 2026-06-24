<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisitionDetail extends Model
{
    protected $fillable = [

        'purchase_requisition_id',
        'product_id',
        'category',
        'color',
        'size',
        'quantity',
        'unit'
    ];

    public function requisition()
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
}
