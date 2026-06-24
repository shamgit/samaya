<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $table =
        'purchase_order_items';

    protected $fillable =['po_id','product_id','qty','unit_price','total'];
    public function purchaseOrder()
    {
        return $this->belongsTo(
            PurchaseOrder::class,
            'po_id'
        );
    }


    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }
}