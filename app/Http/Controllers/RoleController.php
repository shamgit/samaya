<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Roles;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    
    public function roles(Request $request)
    {

        $roles = Roles::where('deleted', 0)->get();

        return view('Roles.roles',compact('roles'));
    }


    public function roles_list_table(Request $request)
    {
        $query = Roles::where('roles.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'roles.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'roles.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('roles.role_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->role_id)) {

            $query->where('roles.role_id', $request->role_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('roles.role_name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('roles.role_id', 'ASC');

        } else {

            $query->latest('roles.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'roles.role_id',
                'roles.role_name',
                'created_user.name as created_by',
                'roles.created_at',
                'updated_user.name as updated_by',
                'roles.updated_at'

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



    public function roles_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'role_name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('roles')->with('toast_error', 'Roles not found.');
        }

        $roles = new Roles(); 

        // Assign other fields
        $roles->role_name = $request->role_name;
        $roles->created_by = Auth::user()->id;

        $roles->save();

        // dd($roles);

        return redirect()->route('roles')->with('toast_success', 'Roles added successfully!');


    }



     public function roles_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'role_name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('roles')->with('toast_error', 'Roles not found.');
        }

        $roles = Roles::find($request->role_id);

        $roles_details = Roles::where('role_id',$request->role_id)->first();


        // Update project fields
        $roles->role_name = $request->role_name;
        $roles->updated_by = Auth::user()->id;

        $roles->save();

        return redirect()->route('roles')->with('toast_success', 'Roles updated successfully!');
    }


     public function roles_edit(Request $request)
    {

        
        $roles_details = Roles::where('role_id',$request->role_id)->where('deleted', 0)->first();

        // dd($roles_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="role_id" value="'. $roles_details->role_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Role Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" name="role_name"  value="' . $roles_details->role_name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function roles_delete(Request $request)
    {
        $role = Roles::find($request->role_id);

        if(!$role){

            return response()->json([
                'status' => false,
                'message' => 'Role not found'
            ]);
        }

        $role->deleted = 1;

        $role->updated_by = Auth::id();

        $role->save();

        return response()->json([

            'status' => true,

            'message' => 'Role deleted successfully'
        ]);
    }

}
