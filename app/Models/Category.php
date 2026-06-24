<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Category extends Model 
{

    protected $table = 'category';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name', 
        'deleted',
        'created_by',
        'updated_by'
    ];
}