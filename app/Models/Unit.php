<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Unit extends Model 
{

    protected $table = 'unit_of_measure';

    protected $primaryKey = 'unit_id';

    protected $fillable = [
        'name', 
        'deleted',
        'created_by',
        'updated_by'
    ];
}