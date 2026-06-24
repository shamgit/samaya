<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Designations;
use App\Models\Employee;
use App\Models\User;
use App\Models\AttendanceStatus;
use App\Models\Attendance;
use App\Models\LeaveTypes;
use App\Models\Leave;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    
    public function attendance_management(Request $request)
    {

        $user = Auth::user();

        if ($user->role_id == 4) {

            $employee = Employee::where('employee_id',$user->employee_id)->where('deleted', 0)->first();

         
            if ($employee) {
                $employee_count = Employee::where('employee_id',$employee->employee_id)->where('deleted', 0)->count();

                $attendance_status = Attendance::with('attendanceStatus')->where('employee_id', $employee->employee_id)->where('deleted', 0)->first();

              // dd($attendance_status->attendanceStatus);
 
                $present_count = Attendance::where('employee_id',$employee->employee_id)->whereDate('attendance_date',now()->toDateString())->where('attendance_status_id', 1)->where('deleted', 0)->count();

                $absent_count = Attendance::where('employee_id',$employee->employee_id)->where('attendance_status_id', 3)->where('deleted', 0)->count();

                $leave_count = Leave::where('employee_id',$employee->employee_id)->where('deleted', 0)->count();

                $departments = Department::where('department_id',$employee->department_id)->where('deleted', 0)->get();

            } else {

                $departments = collect();
            }

        } else {

            $departments = Department::where('deleted', 0)->get();

            $attendance_status = AttendanceStatus::where('deleted', 0)->get();

            $employee_count = Employee::where('deleted', 0)->count();

            $present_count = Attendance::whereDate('attendance_date',now()->toDateString())->where('attendance_status_id', 1)->where('deleted', 0)->count();
            $absent_count = Attendance::where('attendance_status_id', 3)->where('deleted', 0)->count();
            $leave_count = Leave::where('leaves.manager_approval', $user->id)->where('leaves.deleted', 0)->leftJoin('users','users.id','=','leaves.manager_approval')->count();
        }

        return view('Attendance.attendance_management',compact('departments','attendance_status','employee_count','present_count','absent_count','leave_count'));
    }

     public function attendance_list_table(Request $request)
    {
        $user = Auth::user();

        $query = Attendance::query()

            ->where('attendances.deleted', 0)

            ->leftJoin(
                'employees',
                'employees.employee_id',
                '=',
                'attendances.employee_id'
            )

            ->leftJoin(
                'departments',
                'departments.department_id',
                '=',
                'attendances.department_id'
            )

            ->leftJoin(
                'attendance_status',
                'attendance_status.attendance_statu_id',
                '=',
                'attendances.attendance_status_id'
            )

            ->leftJoin(
                'users as created_user',
                'created_user.id',
                '=',
                'attendances.created_by'
            );

       
        if ($user->role_id == 4) {

            $query->where(
                'attendances.employee_id',
                $user->employee_id
            );
        }

       
        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->where(
                        'attendances.employee_code',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'employees.employee_name',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'attendance_status.attendance_status_name',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'departments.name',
                        'LIKE',
                        "%{$search}%"
                    );
            });
        }

        
        if (!empty($request->department_id)) {

            $query->where(
                'attendances.department_id',
                $request->department_id
            );
        }

       
        if (!empty($request->attendance_statu_id)) {

            $query->where(
                'attendances.attendance_status_id',
                $request->attendance_statu_id
            );
        }

        
        if (!empty($request->from_date)) {

            $query->whereDate(
                'attendances.attendance_date',
                '>=',
                $request->from_date
            );
        }

     
        if (!empty($request->to_date)) {

            $query->whereDate(
                'attendances.attendance_date',
                '<=',
                $request->to_date
            );
        }

       
        $totalRecords = Attendance::where('deleted', 0)->count();

       
        $filteredRecords = $query->count();

       
        if ($request->sort == 'name') {

            $query->orderBy('employees.employee_name', 'ASC');

        } elseif ($request->sort == 'created_at') {

            $query->orderBy('attendances.created_at', 'DESC');

        } else {

            $query->latest('attendances.created_at');
        }

       
        $data = $query->select(

                'attendances.attendance_id',

                'attendances.employee_code',

                'employees.employee_name',

                'departments.name as department_name',

                'attendances.attendance_date',

                'attendances.check_in',

                'attendances.check_out',

                'attendance_status.attendance_status_name as name'
            )

            ->skip($request->start)

            ->take($request->length)

            ->get();

        return response()->json([

            'draw' => intval($request->draw),

            'recordsTotal' => $totalRecords,

            'recordsFiltered' => $filteredRecords,

            'data' => $data
        ]);
    }

        public function mark_daily_attendance(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id == 4) {

            $employee = Employee::query()

                ->where('employees.employee_id', $user->employee_id)

                ->where('employees.deleted', 0)

                ->leftJoin(
                    'departments',
                    'departments.department_id',
                    '=',
                    'employees.department_id'
                )

                ->select(
                    'employees.*',
                    'departments.name as department_name'
                )

                ->get();

            $departments = Department::where(
                    'department_id',
                    optional($employee->first())->department_id
                )
                ->where('deleted', 0)
                ->get();

        } else {

            $departments = Department::where('deleted', 0)->get();

            $employee = Employee::query()

                ->where('employees.deleted', 0)

                ->leftJoin(
                    'departments',
                    'departments.department_id',
                    '=',
                    'employees.department_id'
                )

                ->select(
                    'employees.*',
                    'departments.name as department_name'
                )

                ->get();
        }

        $attendance_status = AttendanceStatus::where('deleted',0)->get();

        return view('Attendance.mark_daily_attendance', compact('departments','attendance_status','employee'));
    }

     public function absence_tracking(Request $request)
    {
         $user = Auth::user();

          if ($user->role_id == 4) {

            $employee = Employee::query()

                ->where('employees.employee_id', $user->employee_id)

                ->where('employees.deleted', 0)

                ->leftJoin(
                    'departments',
                    'departments.department_id',
                    '=',
                    'employees.department_id'
                )

                ->select(
                    'employees.*',
                    'departments.name as department_name'
                )

                ->get();

            $departments = Department::where(
                    'department_id',
                    optional($employee->first())->department_id
                )
                ->where('deleted', 0)
                ->get();

        } else {

            $departments = Department::where('deleted', 0)->get();

            $employee = Employee::query()

                ->where('employees.deleted', 0)

                ->leftJoin(
                    'departments',
                    'departments.department_id',
                    '=',
                    'employees.department_id'
                )

                ->select(
                    'employees.*',
                    'departments.name as department_name'
                )

                ->get();
        }

        return view('Attendance.absence_tracking',compact('departments','employee'));
    }

      public function absence_tracking_view(Request $request,$leave_id)
    {
        $leave_id = base64_decode($leave_id);
        $user = Auth::user();

        $leave_details = Leave::where('leave_id', $leave_id)->where('deleted', 0)->first();

        $employees = Employee::where('employee_id',$leave_details->employee_id)->where('deleted', 0)->first();

        $departments = Department::where('department_id',$leave_details->department_id)->where('deleted', 0)->first();

        $designations = Designations::where('designation_id',$leave_details->designation_id)->where('deleted', 0)->first();

        $leave_types = LeaveTypes::where('leave_type_id',$leave_details->leave_type_id)->where('deleted', 0)->first();

        $users = User::where('id',$leave_details->manager_approval)->where('role_id', '!=', 3)->where('role_id', '!=', 4)->where('deleted', 0)->first();

        return view('Attendance.absence_tracking_view',compact('employees','leave_details','departments','designations','leave_types','users'));
    }

       public function absence_tracking_list_table(Request $request)
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

        if (!empty($request->leave_status)) {

            $query->where(
                'leaves.leave_status',
                $request->leave_status
            );
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

        public function leave_status_update(Request $request)
    {
        Leave::where('leave_id', $request->leave_id)
            ->update([
                'leave_status' => $request->leave_status
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Status Updated Successfully'
        ]);
    }


     public function mark_daily_attendance_edit(Request $request,$attendance_id)
    {

        $attendance_id = base64_decode($attendance_id);

        $user = Auth::user();
        $employee = User::where('employee_id',$user->employee_id)->where('deleted', 0)->first();
        $attendance_details = Attendance::where('attendance_id', $attendance_id)

        ->leftJoin(
            'employees',
            'employees.employee_id',
            '=',
            'attendances.employee_id'
        )

        ->leftJoin(
            'departments',
            'departments.department_id',
            '=',
            'employees.department_id'
        )

        ->where('attendances.deleted', 0)

        ->select(
            'attendances.*',
            'employees.*',
            'departments.name as department_name'
        )

        ->get();
        $departments = Department::where('deleted', 0)->get();
        $attendance_status = AttendanceStatus::where('deleted',0)->get();

        return view('Attendance.mark_daily_attendance_edit',compact('departments','attendance_status','employee','attendance_details'));
    }


        public function save_daily_attendance(Request $request)
    {
        foreach ($request->attendanceData as $attendance) {

            Attendance::updateOrCreate(

                [

                    'employee_id' => $attendance['employee_id'],

                    'attendance_date' => $attendance['attendance_date'],

                ],

                [
                    'employee_code' => $attendance['employee_code'],

                    'department_id' => $attendance['department_id'],

                    'check_in' => $attendance['check_in'],

                    'check_out' => $attendance['check_out'],

                    'attendance_status_id' =>
                        $attendance['attendance_status_id'],

                    'created_by' => Auth::id(),
                     
                    'updated_by' => Auth::id(),

                ]
            );
        }

        return response()->json([

            'status' => true,

            'message' => 'Attendance saved successfully'

        ]);
    }


        public function update_daily_attendance(Request $request)
    {
        try {

            foreach ($request->attendanceData as $attendance) {

                Attendance::where('attendance_id', $attendance['attendance_id'])
                    ->update([

                        'employee_id' => $attendance['employee_id'],

                        'employee_code' => $attendance['employee_code'],

                        'department_id' => $attendance['department_id'],

                        'attendance_date' => $attendance['attendance_date'],

                        'check_in' => $attendance['check_in'],

                        'check_out' => $attendance['check_out'],

                        'attendance_status_id' => $attendance['attendance_status_id'],

                        'updated_by' => Auth::id(),

                        'updated_at' => now()

                    ]);
            }

            return response()->json([

                'status' => true,

                'message' => 'Attendance updated successfully'

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'status' => false,

                'message' => $e->getMessage()

            ], 500);
        }
    }


      public function attendance_delete(Request $request)
    {
        $attendance = Attendance::find($request->attendance_id);

        if(!$attendance){

            return response()->json([

                'status' => false,

                'message' => 'Attendance not found'
            ]);
        }

        $attendance->deleted = 1;

        $attendance->updated_by = Auth::id();

        $attendance->save();

        return response()->json([

            'status' => true,

            'message' => 'Attendance deleted successfully'
        ]);
    }


     public function attendance_excel(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id == 4) {

            $attendance = Attendance::where('employee_id', $user->employee_id)->where('deleted', 0)->first();

            if (!$attendance) {
                return redirect()->back()->with('toast_error','Attendance record not found.');
            }

            return Excel::download(new AttendanceExport($attendance->employee_id),'attendance_details.xlsx');
        }

        return Excel::download( new AttendanceExport(),'attendance_details.xlsx');
    }
}