<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table =
        'purchase_orders';

    protected $fillable = [

        'supplier_id',

        'po_number',

        'po_date',

        'delivery_date',

        'delivery_location',

        'payment_terms',

        'notes',

        'gst_rate',

        'subtotal',

        'gst_amount',

        'total_amount',

        'attachment',

        'status'

    ];


    public function supplier()
    {
        return $this->belongsTo(
            Supplier::class,
            'supplier_id',
            'supplier_id'
        );
    }


    public function items()
    {
        return $this->hasMany(
            PurchaseOrderItem::class,
            'po_id'
        );
    }

}