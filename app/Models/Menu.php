<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Menu extends Model 
{

    protected $table = 'menus';

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_group_id',
        'menu_name', 
        'menu_icon',
        'menu_link',
        'deleted',
        'created_by',
        'updated_by'
    ];

         public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id', 'menu_group_id');
    }
}