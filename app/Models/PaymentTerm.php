<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model 
{

    protected $table = 'payment_terms';

    protected $primaryKey = 'payment_term_id';

    protected $fillable = [
        'name', 
        'deleted',
        'created_by',
        'updated_by'
    ];
}