<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Designations;
use App\Models\LeaveTypes;
use App\Models\Employee;
use App\Models\User;
use App\Models\Leave;

class LeaveController extends Controller
{
    
    public function leaves(Request $request)
    {

        $leave_types = LeaveTypes::where('deleted', 0)->get();
        
       
        return view('Leaves.leaves',compact('leave_types'));
    }

    public function leave_add(Request $request)
    {
        $user = Auth::user();

        $users = User::where('role_id', '!=', 3)->where('role_id', '!=', 4)->where('deleted', 0)->get();

        if ($user->role_id == 4) {

            $employee = Employee::where('employee_id', $user->employee_id)
                ->where('deleted', 0)
                ->first();

            if ($employee) {

                $employees = Employee::where('employee_id', $employee->employee_id)
                    ->where('deleted', 0)
                    ->get();

                $leave_types = LeaveTypes::where('deleted', 0)
                    ->get();

            } else {

                $employees = collect();

                $leave_types = collect();
            }

        } else {

            $employees = Employee::where('deleted', 0)
                ->get();

            $leave_types = LeaveTypes::where('deleted', 0)
                ->get();
        }

        return view('Leaves.leave_add',compact('employees', 'leave_types', 'users'));
    }

       public function leave_list_table(Request $request)
    {

        $user = Auth::user();

        $query = Leave::query()->where('leaves.deleted', 0)
                ->leftJoin('employees','employees.employee_id','=','leaves.employee_id' )
                ->leftJoin('leave_types','leave_types.leave_type_id','=','leaves.leave_type_id' )
                ->leftJoin('users','users.id','=','leaves.manager_approval' )
                ->leftJoin('users as created_user','created_user.id','=','leaves.created_by');
                
        if($user->role_id == 4){

            $query->where('leaves.employee_id', $user->employee_id);

        }else{

            $query->where('leaves.manager_approval', $user->id);
        }

        $totalRecords = Leave::where('deleted', 0)->count();


        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->where('leaves.employee_code', 'LIKE', "%{$search}%")

                    ->orWhere('employees.employee_name', 'LIKE', "%{$search}%")

                    ->orWhere('leave_types.name', 'LIKE', "%{$search}%")

                    ->orWhere('leaves.from_date', 'LIKE', "%{$search}%")

                    ->orWhere('leaves.to_date', 'LIKE', "%{$search}%")

                    ->orWhere('users.name', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->leave_type_id)) {

            $query->where('leaves.leave_type_id', $request->leave_type_id);
        }

    
        $filteredRecords = $query->count();


        if ($request->sort == 'name') {

            $query->orderBy(
                'employees.employee_name',
                'ASC'
            );

        } elseif ($request->sort == 'created_at') {

            $query->orderBy(
                'leaves.created_at',
                'DESC'
            );

        } else {

            $query->latest('leaves.created_at');
        }



        $data = $query->select(

            'leaves.leave_id',

            'employees.employee_name',

            'leaves.employee_code',

            'leave_types.name as leave_type_name',

            'leaves.from_date',

            'leaves.to_date',

            'users.name as manager_name',

            'leaves.leave_status',

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

       public function leave_edit(Request $request,$leave_id)
    {
        $leave_id = base64_decode($leave_id);
        $user = Auth::user();

        $leave_details = Leave::where('leave_id', $leave_id)->where('deleted', 0)->first();

        $employees = Employee::where('employee_id',$leave_details->employee_id)->where('deleted', 0)->get();

        $departments = Department::where('department_id',$leave_details->department_id)->where('deleted', 0)->get();

        $designations = Designations::where('designation_id',$leave_details->designation_id)->where('deleted', 0)->get();

        $leave_types = LeaveTypes::where('deleted', 0)->get();

        $users = User::where('role_id', '!=', 3)->where('role_id', '!=', 4)->where('deleted', 0)->get();

        return view('Leaves.leave_edit',compact('employees','leave_details','departments','designations','leave_types','users'));
    }

      public function leave_view(Request $request,$leave_id)
    {
        $leave_id = base64_decode($leave_id);
        $user = Auth::user();

        $leave_details = Leave::where('leave_id', $leave_id)->where('deleted', 0)->first();

        $employees = Employee::where('employee_id',$leave_details->employee_id)->where('deleted', 0)->first();

        $departments = Department::where('department_id',$leave_details->department_id)->where('deleted', 0)->first();

        $designations = Designations::where('designation_id',$leave_details->designation_id)->where('deleted', 0)->first();

        $leave_types = LeaveTypes::where('leave_type_id',$leave_details->leave_type_id)->where('deleted', 0)->first();

        $users = User::where('id',$leave_details->manager_approval)->where('role_id', '!=', 3)->where('role_id', '!=', 4)->where('deleted', 0)->first();

        return view('Leaves.leave_view',compact('employees','leave_details','departments','designations','leave_types','users'));
    }


     public function store_leave(Request $request)
    {
        //   dd($request->all());

        $validator = Validator::make($request->all(), [

            'employee_id' => 'required',

            'leave_type_id' => 'required',

            'from_date' => 'required',

            'to_date' => 'required',

            'reason' => 'required',
        ]);

        

        if ($validator->fails()) {
            return redirect()->route('leaves')->with('toast_error', 'Leave Request Validator.');
        }
        

        Leave::create([

            'employee_id' => $request->employee_id,

            'employee_code' => $request->employee_code,

            'designation_id' => $request->designation_id,

            'department_id' => $request->department_id,

            'leave_type_id' => $request->leave_type_id,

            'from_date' => $request->from_date,

            'to_date' => $request->to_date,

            'reason' => $request->reason,

            'manager_approval' => $request->manager_approval,

            'created_by' => Auth::id(),
        ]);

        
        return redirect()->route('leaves')->with('toast_success', 'Leave Request Added Successfully!');

    }


    public function update_leave(Request $request){

     //   dd($request->all());

        $validator = Validator::make($request->all(), [

            'employee_id' => 'required',

            'leave_type_id' => 'required',

            'from_date' => 'required',

            'to_date' => 'required',

            'reason' => 'required',
        ]);

        

        if ($validator->fails()) {
            return redirect()->route('leaves')->with('toast_error', 'Leave Request Validator.');
        }

        $leave = Leave::find($request->leave_id);

        $Leave_details = Leave::where('leave_id',$request->leave_id)->first();

        $leave->employee_id = $request->employee_id;
        $leave->employee_code = $request->employee_code;
        $leave->designation_id = $request->designation_id;
        $leave->department_id = $request->department_id;
        $leave->leave_type_id = $request->leave_type_id;
        $leave->from_date = $request->from_date;
        $leave->to_date = $request->to_date;
        $leave->reason = $request->reason;
        $leave->manager_approval = $request->manager_approval;
        $leave->updated_by = Auth::user()->id;

        $leave->save();


      return redirect()->route('leaves')->with('toast_success', 'Leave Request Update Successfully!');
        
    }

      public function leave_delete(Request $request)
    {
        $leave = Leave::find($request->leave_id);

        if(!$leave){

            return response()->json([

                'status' => false,

                'message' => 'leave not found'
            ]);
        }

        $leave->deleted = 1;

        $leave->updated_by = Auth::id();

        $leave->save();

        return response()->json([

            'status' => true,

            'message' => 'Leave deleted successfully'
        ]);
    }

}