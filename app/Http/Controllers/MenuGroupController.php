<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuGroup;
use Illuminate\Support\Facades\Validator;


class MenuGroupController extends Controller
{
    
    public function menu_groups(Request $request)
    {

        $menu_groups = MenuGroup::where('deleted', 0)->get();

        return view('MenuGroups.menu_groups',compact('menu_groups'));
    }

      public function menu_group_list_table(Request $request)
    {
        $query = MenuGroup::where('menu_groups.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'menu_groups.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'menu_groups.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('menu_groups.menu_group_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->menu_group_id)) {

            $query->where('menu_groups.menu_group_id', $request->menu_group_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('menu_groups.menu_group_name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('menu_groups.menu_group_id', 'ASC');

        } else {

            $query->latest('menu_groups.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'menu_groups.menu_group_id',
                'menu_groups.menu_group_name',
                'created_user.name as created_by',
                'menu_groups.created_at',
                'updated_user.name as updated_by',
                'menu_groups.updated_at'

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

      public function menu_group_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'menu_group_name' => 'required',
            'menu_group_icon' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('menu_groups')->with('toast_error', 'Menu Group not found.');
        }

        $menu_groups = new MenuGroup(); 

        // Assign other fields
        $menu_groups->menu_group_name = $request->menu_group_name;
        $menu_groups->menu_group_icon = $request->menu_group_icon;
        $menu_groups->created_by = Auth::user()->id;

        $menu_groups->save();

        // dd($menu_groups);

        return redirect()->route('menu_groups')->with('toast_success', 'Menu Group added successfully!');


    }

      public function menu_group_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'menu_group_name' => 'required',
            'menu_group_icon' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('menu_groups')->with('toast_error', 'Menu Group not found.');
        }

        $menu_groups = MenuGroup::find($request->menu_group_id);

        $menu_groups_details = MenuGroup::where('menu_group_id',$request->menu_group_id)->first();

        $menu_groups->menu_group_name = $request->menu_group_name;
        $menu_groups->menu_group_icon = $request->menu_group_icon;
        $menu_groups->updated_by = Auth::user()->id;

        $menu_groups->save();

        return redirect()->route('menu_groups')->with('toast_success', 'Menu Group updated successfully!');
    }


     public function menu_group_edit(Request $request)
    {

        
        $menu_groups_details = MenuGroup::where('menu_group_id',$request->menu_group_id)->where('deleted', 0)->first();

        // dd($menu_groups_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="menu_group_id" value="'. $menu_groups_details->menu_group_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Menu Group Name *</label>
                    <input type="text" class="form-input" name="menu_group_name"  value="' . $menu_groups_details->menu_group_name .'"  required>
                </div>
               <div class="form-group">
                  <label class="form-label">Menu Group Icon *</label>
                  <input type="text" class="form-input" name="menu_group_icon"  value="' . $menu_groups_details->menu_group_icon .'"  required/>
                </div>

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function menu_group_delete(Request $request)
    {
        $menu_groups = MenuGroup::find($request->menu_group_id);

        if(!$menu_groups){

            return response()->json([
                'status' => false,
                'message' => 'Menu Group not found'
            ]);
        }

        $menu_groups->deleted = 1;

        $menu_groups->updated_by = Auth::id();

        $menu_groups->save();

        return response()->json([

            'status' => true,

            'message' => 'Menu Group deleted successfully'
        ]);
    }

}