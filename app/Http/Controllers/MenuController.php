<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\MenuGroup;
use Illuminate\Support\Facades\Validator;


class MenuController extends Controller
{
    
    public function menus(Request $request)
    {

        $menus = Menu::where('deleted', 0)->get();
        $menu_groups = MenuGroup::where('deleted', 0)->get();
        return view('Menus.menus',compact('menus','menu_groups'));
    }

       public function menu_list_table(Request $request)
    {
        $query = Menu::where('menus.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'menus.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'menus.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('menus.menu_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->menu_id)) {

            $query->where('menus.menu_id', $request->menu_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('menus.menu_name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('menus.menu_id', 'ASC');

        } else {

            $query->latest('menus.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'menus.menu_id',
                'menus.menu_name',
                'created_user.name as created_by',
                'menus.created_at',
                'updated_user.name as updated_by',
                'menus.updated_at'

            )
            ->skip($request->start)
            ->take($request->length)
            ->get();

        return response()->json([

            'draw' => intval($request->draw),

            'recordsTotal' => $totalRecords,

            'recordsFiltered' => $totalRecords,

            'data' => $data,
        ]);
    }

      public function menu_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'menu_name' => 'required',
            'menu_group_id' => 'required',
            'menu_link' => 'required',
            'menu_icon' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('menus')->with('toast_error', 'Menu Group not found.');
        }

        $menus = new Menu(); 

        // Assign other fields
        $menus->menu_name = $request->menu_name;
        $menus->menu_group_id = $request->menu_group_id;
        $menus->menu_link = $request->menu_link;
        $menus->menu_icon = $request->menu_icon;
        $menus->created_by = Auth::user()->id;

        $menus->save();

        // dd($menus);

        return redirect()->route('menus')->with('toast_success', 'Menu added successfully!');


    }

      public function menu_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required',
            'menu_group_id' => 'required',
            'menu_link' => 'required',
            'menu_icon' => 'required',
        ]);


        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('menus')->with('toast_error', 'Menu not found.');
        }

        $menus = Menu::find($request->menu_id);

        $menus_details = Menu::where('menu_id',$request->menu_id)->first();

        $menus->menu_name = $request->menu_name;
        $menus->menu_group_id = $request->menu_group_id;
        $menus->menu_link = $request->menu_link;
        $menus->menu_icon = $request->menu_icon;
        $menus->updated_by = Auth::user()->id;

        $menus->save();

        return redirect()->route('menus')->with('toast_success', 'Menu  updated successfully!');
    }


     public function menu_edit(Request $request)
    {

        
        $menu_details = Menu::where('menu_id',$request->menu_id)->where('deleted', 0)->first();
        $menu_groups = MenuGroup::where('deleted', 0)->get();
        // dd($menu_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="menu_id" value="'. $menu_details->menu_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Menu  Name *</label>
                    <input type="text" class="form-input" name="menu_name"  value="' . $menu_details->menu_name .'"  required>
                </div>
                 <div class="form-group">
                  <label class="form-label">Menu Group *</label>
                    <select class="form-input" id="menu_group_id" name="menu_group_id">
                    <option disabled value="">Select Menu Group</option>';
                        foreach ($menu_groups as $menu_group) {
                            $selected = $menu_details->menu_group_id == $menu_group->menu_group_id ? 'selected' : '';
                            $model .= '<option value="' . $menu_group->menu_group_id . '" ' . $selected . '>' .$menu_group->menu_group_name. '</option>';
                        }
                        $model .= '</select>
                   </select>
                </div>
                 <div class="form-group">
                  <label class="form-label">Menu Link *</label>
                  <input type="text" class="form-input" name="menu_link" value="' . $menu_details->menu_link .'"  required/>
                </div>
               <div class="form-group">
                  <label class="form-label">Menu Icon *</label>
                  <input type="text" class="form-input" name="menu_icon"  value="' . $menu_details->menu_icon .'"  required/>
                </div>

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function menu_delete(Request $request)
    {
        $menus = Menu::find($request->menu_id);

        if(!$menus){

            return response()->json([
                'status' => false,
                'message' => 'Menu not found'
            ]);
        }

        $menus->deleted = 1;

        $menus->updated_by = Auth::id();

        $menus->save();

        return response()->json([

            'status' => true,

            'message' => 'Menu deleted successfully'
        ]);
    }
}