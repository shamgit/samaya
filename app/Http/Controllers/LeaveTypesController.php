<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LeaveTypes;

class LeaveTypesController extends Controller
{
    
    public function leave_types(Request $request)
    {

        $leave_types = LeaveTypes::where('deleted', 0)->get();
        return view('LeaveTypes.leave_types',compact('leave_types'));
    }

     public function leave_types_list_table(Request $request)
    {
        $query = LeaveTypes::where('leave_types.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'leave_types.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'leave_types.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('leave_types.name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->leave_type_id)) {

            $query->where('leave_types.leave_type_id', $request->leave_type_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('leave_types.name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('leave_types.leave_type_id', 'ASC');

        } else {

            $query->latest('leave_types.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'leave_types.leave_type_id',
                'leave_types.name',
                'created_user.name as created_by',
                'leave_types.created_at',
                'updated_user.name as updated_by',
                'leave_types.updated_at'

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



    public function leave_types_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('leave_types')->with('toast_error', 'Leave Type not found.');
        }

        $leave_types = new LeaveTypes(); 

        // Assign other fields
        $leave_types->name = $request->name;
        $leave_types->created_by = Auth::user()->id;

        $leave_types->save();

        // dd($leave_types);

        return redirect()->route('leave_types')->with('toast_success', 'Leave Type added successfully!');


    }



     public function leave_types_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('leave_types')->with('toast_error', 'Leave Type not found.');
        }

        $leave_types = LeaveTypes::find($request->leave_type_id);

        $leave_types_details = LeaveTypes::where('leave_type_id',$request->leave_type_id)->first();


        // Update project fields
        $leave_types->name = $request->name;
        $leave_types->updated_by = Auth::user()->id;

        $leave_types->save();

        return redirect()->route('leave_types')->with('toast_success', 'Leave Type updated successfully!');
    }


     public function leave_types_edit(Request $request)
    {

        
        $leave_types_details = LeaveTypes::where('leave_type_id',$request->leave_type_id)->where('deleted', 0)->first();

        // dd($leave_types_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="leave_type_id" value="'. $leave_types_details->leave_type_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Leave Type Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" name="name"  value="' . $leave_types_details->name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function leave_types_delete(Request $request)
    {
        $leave_types = LeaveTypes::find($request->leave_type_id);

        if(!$leave_types){

            return response()->json([
                'status' => false,
                'message' => 'Leave Type not found'
            ]);
        }

        $leave_types->deleted = 1;

        $leave_types->updated_by = Auth::id();

        $leave_types->save();

        return response()->json([

            'status' => true,

            'message' => 'Leave Type deleted successfully'
        ]);
    }
}