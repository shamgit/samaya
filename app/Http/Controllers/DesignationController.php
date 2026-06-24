<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use App\Models\Menu;
use App\Models\Designations;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;


class DesignationController extends Controller
{


    public function designations(Request $request)
    {
        $designations = Designations::where('deleted', 0)->where('designation_type', 1)->get();
        $users = User::where('deleted', 0)->get();
        return view('Designations.designations', compact('designations','users'));
    }

    public function designation_add(Request $request)
    {
        $users = User::where('deleted', 0)->get();
        $roles = Roles::where('deleted', 0)->get();
        $designations = Designations::where('deleted', 0)->get();
        $menus = Menu::where('deleted', 0)->get();

        return view('Designations.designation_add', compact('users','roles','designations','menus'));
    }

     public function designation_edit(Request $request,$designation_id)
    {
        $designation_id = base64_decode($designation_id);
        $designation_details = Designations::where('designation_id',$designation_id)->where('deleted', 0)->first();
        $users = User::where('deleted', 0)->get();
        $roles = Roles::where('deleted', 0)->get();
        $menus = Menu::where('deleted', 0)->get();

        return view('Designations.designation_edit', compact('users','roles','designation_details','menus'));
    }


     public function designation_list(Request $request)
    {
        $query = Designations::query()->where('designations.designation_type', 1)->where('designations.deleted', 0)
            ->leftJoin(
                'users as created_user',
                'created_user.id',
                '=',
                'designations.created_by'
            );

        $totalRecords = Designations::where('deleted', 0)->count();

        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->Where('designations.name', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->designation_id)) {

            $query->where(
                'designations.designation_id',
                $request->designation_id
            );
        }


        $filteredRecords = $query->count();

        if ($request->sort == 'name') {

            $query->orderBy('designations.name', 'ASC');

        } else {

            $query->latest('designations.created_at');
        }


        $data = $query->select(

                'designations.designation_id',

                'designations.name',

                'created_user.name as created_by',

                'designations.created_at'
            )

            ->skip($request->start)

            ->take($request->length)

            ->get();

        return response()->json([

            'draw' => intval($request->draw),

            'recordsTotal' => $totalRecords,

            'recordsFiltered' => $filteredRecords,

            'data' => $data,
        ]);
    }



    public function designation_list_table(Request $request)
    {
        $query = Designations::query()->where('designations.deleted', 0)->whereNotNull('designations.user_id')

            ->leftJoin(
                'roles',
                'roles.role_id',
                '=',
                'designations.role_id'
            )

            ->leftJoin(
                'users',
                'users.id',
                '=',
                'designations.user_id'
            )

            ->leftJoin(
                'users as created_user',
                'created_user.id',
                '=',
                'designations.created_by'
            );

        $totalRecords = Designations::where('deleted', 0)->count();

        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->Where('users.name', 'LIKE', "%{$search}%")

                    ->orWhere('roles.role_name', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->user_id)) {

            $query->where(
                'designations.user_id',
                $request->user_id
            );
        }


        $filteredRecords = $query->count();

        if ($request->sort == 'user_id') {

            $query->orderBy('designations.user_id', 'ASC');

        } else {

            $query->latest('designations.created_at');
        }


        $data = $query->select(

                'designations.designation_id',

                'users.name as user_name',

                'roles.role_name',

                'created_user.name as created_by',

                'designations.created_at'
            )

            ->skip($request->start)

            ->take($request->length)

            ->get();

        return response()->json([

            'draw' => intval($request->draw),

            'recordsTotal' => $totalRecords,

            'recordsFiltered' => $filteredRecords,

            'data' => $data,
        ]);
    }

      public function store(Request $request)
    {
        $request->validate([
            
            'name' => 'required',
        ]);

        $designations = new Designations();

        $designations->name = $request->name;

        $designations->designation_type = 1;

        $designations->created_by = Auth::id();

        $designations->save();

        return redirect()->route('designations')->with('toast_success', 'Designation added successfully!');
    }

      public function designations_update(Request $request)
    {
       
        $designations = Designations::find($request->designation_id);


        $designations->name = $request->name;

        $designations->updated_by = Auth::id();

        $designations->save();

        return redirect()->route('designations')->with('toast_success', 'Designation Update successfully!');
    }

      public function edit(Request $request)
    {

        
        $designation_details = Designations::where('designation_id',$request->designation_id)->where('deleted', 0)->first();

        // dd($designation_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="designation_id" value="'. $designation_details->designation_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Designation Name *</label>
                    <input type="text" class="form-input" name="name"  value="' . $designation_details->name .'" required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

      public function designation_store(Request $request)
    {
        $request->validate([
            
            'user_id' => 'required',

            'role_id' => 'required',

            'access_menus' => 'required|array',

        ]);

        $designations = new Designations();

        $designations->user_id = $request->user_id;

        $designations->role_id = $request->role_id;

        $designations->description = $request->description;

        $designations->designation_type = 2;

        $designations->access_menus = implode(',', $request->access_menus);

        $designations->created_by = Auth::id();


        $designations->save();

        return redirect()->route('designations')->with('toast_success', 'Designation added successfully!');
    }

        public function designation_update(Request $request)
    {
        $request->validate([

            'user_id' => 'required',

            'role_id' => 'required',

            'access_menus' => 'required|array',

        ]);

      

        $designation = Designations::findOrFail(
            $request->designation_id
        );

        $designation->user_id = $request->user_id;

        $designation->role_id = $request->role_id;

        $designation->description = $request->description;

        $designation->access_menus = implode(
            ',',
            $request->access_menus
        );

        $designation->updated_by = Auth::id();

        $designation->save();

    

        return redirect()

            ->route('designations')
            ->with(
                'toast_success',
                'Designation updated successfully!'
            );
    }




    public function designation_delete(Request $request)
    {
        $designations = Designations::find($request->designation_id);

        if(!$designations){

            return response()->json([

                'status' => false,

                'message' => 'Designation not found'
            ]);
        }

        $designations->deleted = 1;

        $designations->updated_by = Auth::id();

        $designations->save();

        return response()->json([

            'status' => true,

            'message' => 'Designation deleted successfully'
        ]);
    }


    public function get_user_details(Request $request)
{
    $user = User::where('id', $request->user_id)
        ->where('deleted', 0)
        ->first();

    if (!$user) {

        return response()->json([
            'status' => false
        ]);
    }

    $employee = Employee::where(
            'employee_id',
            $user->employee_id
        )
        ->where('deleted', 0)
        ->first();

    $designations = null;

    if ($employee) {

        $designations = Designations::where(
                'designation_id',
                $employee->designation_id
            )
            ->where('deleted', 0)
            ->first();
    }

    return response()->json([

        'status' => true,

        'user' => $user,

        'role_id' => $user->role_id,

        'employee' => $employee,

        'designations' => $designations,

    ]);
}
}