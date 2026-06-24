<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AttendanceStatus;

class AttendanceStatusController extends Controller
{
    
    public function attendance_status(Request $request)
    {

        $attendance_status = AttendanceStatus::where('deleted', 0)->get();
        return view('AttendanceStatus.attendance_status',compact('attendance_status'));
    }

     public function attendance_status_list_table(Request $request)
    {
        $query = AttendanceStatus::where('attendance_status.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'attendance_status.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'attendance_status.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('attendance_status.attendance_status_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->attendance_statu_id)) {

            $query->where('attendance_status.attendance_statu_id', $request->attendance_statu_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('attendance_status.attendance_status_name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('attendance_status.attendance_statu_id', 'ASC');

        } else {

            $query->latest('attendance_status.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'attendance_status.attendance_statu_id',
                'attendance_status.attendance_status_name',
                'created_user.name as created_by',
                'attendance_status.created_at',
                'updated_user.name as updated_by',
                'attendance_status.updated_at'

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



    public function attendance_status_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'attendance_status_name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('attendance_status')->with('toast_error', 'Attendance Status not found.');
        }

        $attendance_status = new AttendanceStatus(); 

        // Assign other fields
        $attendance_status->attendance_status_name = $request->attendance_status_name;
        $attendance_status->created_by = Auth::user()->id;

        $attendance_status->save();

        // dd($attendance_status);

        return redirect()->route('attendance_status')->with('toast_success', 'Attendance Status added successfully!');


    }



     public function attendance_status_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'attendance_status_name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('attendance_status')->with('toast_error', 'Attendance Statu not found.');
        }

        $attendance_status = AttendanceStatus::find($request->attendance_statu_id);

        $attendance_status_details = AttendanceStatus::where('attendance_statu_id',$request->attendance_statu_id)->first();


        // Update project fields
        $attendance_status->attendance_status_name = $request->attendance_status_name;
        $attendance_status->updated_by = Auth::user()->id;

        $attendance_status->save();

        return redirect()->route('attendance_status')->with('toast_success', 'Attendance Statu updated successfully!');
    }


     public function attendance_status_edit(Request $request)
    {

        
        $attendance_status_details = AttendanceStatus::where('attendance_statu_id',$request->attendance_statu_id)->where('deleted', 0)->first();

        // dd($attendance_status_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="attendance_statu_id" value="'. $attendance_status_details->attendance_statu_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Attendance Statu Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" name="attendance_status_name"  value="' . $attendance_status_details->attendance_status_name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function attendance_status_delete(Request $request)
    {
        $attendance_status = AttendanceStatus::find($request->attendance_statu_id);

        if(!$attendance_status){

            return response()->json([
                'status' => false,
                'message' => 'Attendance Statu not found'
            ]);
        }

        $attendance_status->deleted = 1;

        $attendance_status->updated_by = Auth::id();

        $attendance_status->save();

        return response()->json([

            'status' => true,

            'message' => 'Attendance Statu deleted successfully'
        ]);
    }
}