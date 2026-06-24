<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;


class DepartmentController extends Controller
{
    
    
    public function department_master(Request $request)
    {

        $departments = Department::where('deleted', 0)->get();

        return view('Department.department_master',compact('departments'));
    }


    public function department_list_table(Request $request)
    {
        $query = Department::where('departments.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'departments.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'departments.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('departments.name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->department_id)) {

            $query->where('departments.department_id', $request->department_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('departments.name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('departments.department_id', 'ASC');

        } else {

            $query->latest('departments.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'departments.department_id',
                'departments.name',
                'created_user.name as created_by',
                'departments.created_at',
                'updated_user.name as updated_by',
                'departments.updated_at'

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



    public function department_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('department_master')->with('toast_error', 'Department not found.');
        }

        $department = new Department(); 

        // Assign other fields
        $department->name = $request->name;
        $department->created_by = Auth::user()->id;

        $department->save();

        // dd($department);

        return redirect()->route('department_master')->with('toast_success', 'Department added successfully!');


    }



     public function department_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('department_master')->with('toast_error', 'Department not found.');
        }

        $department = Department::find($request->department_id);

        $department_details = Department::where('department_id',$request->department_id)->first();


        // Update project fields
        $department->name = $request->name;
        $department->updated_by = Auth::user()->id;

        $department->save();

        return redirect()->route('department_master')->with('toast_success', 'Department updated successfully!');
    }


     public function department_edit(Request $request)
    {

        
        $department_details = Department::where('department_id',$request->department_id)->where('deleted', 0)->first();

        // dd($department_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="department_id" value="'. $department_details->department_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Department Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" name="name"  value="' . $department_details->name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function department_delete(Request $request)
    {
        $department = Department::find($request->department_id);

        if(!$department){

            return response()->json([
                'status' => false,
                'message' => 'Department not found'
            ]);
        }

        $department->deleted = 1;

        $department->updated_by = Auth::id();

        $department->save();

        return response()->json([

            'status' => true,

            'message' => 'Department deleted successfully'
        ]);
    }

}
