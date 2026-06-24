<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [

        'category_id',

        'product_image',

        'product_name',

        'product_code',

        'unit_of_measure',

        'product_color',

        'supplier_id',

        'cost_price',

        'warehouse_location',

        'reorder_level',

        'created_by',

        'updated_by',
    ];
}