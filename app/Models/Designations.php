<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Designations extends Model 
{

    protected $table = 'designations';

    protected $primaryKey = 'designation_id';

    protected $fillable = [
        'user_id',
        'role_id', 
        'name', 
        'description',
        'access_menus',
        'designation_type',
        'deleted',
        'created_by',
        'updated_by'
    ];

     protected $casts = [

        'access_menus' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}