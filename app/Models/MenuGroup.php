<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model 
{

    protected $table = 'menu_groups';

    protected $primaryKey = 'menu_group_id';

    protected $fillable = [
        'menu_group_name', 
        'menu_group_icon', 
        'deleted',
        'created_by',
        'updated_by'
    ];

       public function menus()
    {
        return $this->hasMany(Menu::class, 'menu_group_id', 'menu_group_id');
    }
}