<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{

    protected $table = 'suppliers';

    protected $primaryKey = 'supplier_id';

    protected $fillable = [

        'supplier_name',
        'contact_person_name',
        'email',
        'phone',

        'address',
        'city',
        'state',
        'zip_code',

        'category_id',
        'gst_tex',
        'payment_term_id',

        'bank_name',
        'account_number',
        'ifsc_code',

        'status',

        'created_by',
        'updated_by',
    ];

   
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_term_id', 'payment_term_id');
    }
}