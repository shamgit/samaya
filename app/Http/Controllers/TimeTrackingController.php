<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Designations;
use App\Models\Employee;
use App\Models\Roles;
use App\Models\User;
use App\Models\TimeTracking;
use App\Exports\TimeTrackingExport;
use Maatwebsite\Excel\Facades\Excel;

class TimeTrackingController extends Controller
{
    
    public function time_tracking(Request $request)
    {

        $user = Auth::user();

         if ($user->role_id == 4) {

            $employee = Employee::where('employee_id',$user->employee_id)->where('deleted', 0)->first();

            if ($employee) {
                $employees = Employee::where('employee_id',$employee->employee_id)->where('deleted', 0)->get();

            } else {

                $employees = collect();
            }

        } else {

            $employees = Employee::where('deleted', 0)->get();
        }

        return view('TimeTracking.time_tracking',compact('employees'));
    }

       public function time_entry_list_table(Request $request)
    {

        $user = Auth::user();

        $query = TimeTracking::query()->where('time_trackings.deleted', 0)
                ->leftJoin('employees','employees.employee_id','=','time_trackings.employee_id' )
                ->leftJoin('users as created_user','created_user.id','=','time_trackings.created_by');

        if ($user->role_id == 4) {

            $query->where(
                'time_trackings.employee_id',
                $user->employee_id
            );
        }

        $totalRecords = TimeTracking::where('deleted', 0)->count();


        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->where('time_trackings.employee_code', 'LIKE', "%{$search}%")

                    ->orWhere('employees.employee_name', 'LIKE', "%{$search}%")

                    ->orWhere('time_trackings.project_task', 'LIKE', "%{$search}%")

                    ->orWhere('time_trackings.total_work_hours', 'LIKE', "%{$search}%")

                    ->orWhere('time_trackings.form_date', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->employee_id)) {

            $query->where('time_trackings.employee_id', $request->employee_id);
        }

        // Date Filter
        if (!empty($request->form_date)) {

            $query->where(
                'time_trackings.form_date',
                trim($request->form_date)
            );
        }

    
        $filteredRecords = $query->count();


        if ($request->sort == 'name') {

            $query->orderBy(
                'time_trackings.employee_id',
                'ASC'
            );

        } elseif ($request->sort == 'created_at') {

            $query->orderBy(
                'time_trackings.created_at',
                'DESC'
            );

        } else {

            $query->latest('time_trackings.created_at');
        }



        $data = $query->select(

                'time_trackings.time_tracking_id',

                'time_trackings.employee_code',

                'employees.employee_name',

                'time_trackings.project_task',

                'time_trackings.total_work_hours',

                'time_trackings.form_date',
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


     public function time_entry_add(Request $request)
    {

         $user = Auth::user();

         if ($user->role_id == 4) {

            $employee = Employee::where('employee_id',$user->employee_id)->where('deleted', 0)->first();

            if ($employee) {
                $employees = Employee::where('employee_id',$employee->employee_id)->where('deleted', 0)->get();

            } else {

                $employees = collect();
            }

        } else {

            $employees = Employee::where('deleted', 0)->get();
        }

       

        return view('TimeTracking.time_entry_add',compact('employees'));
    }


      public function time_entry_edit(Request $request,$time_tracking_id)
    {
        $time_tracking_id = base64_decode($time_tracking_id);
        $user = Auth::user();

        $time_entry_details = TimeTracking::where('time_tracking_id', $time_tracking_id)->where('deleted', 0)->first();

        $employees = Employee::where('employee_id',$time_entry_details->employee_id)->where('deleted', 0)->get();

        $departments = Department::where('department_id',$time_entry_details->department_id)->where('deleted', 0)->get();

        $designations = Designations::where('designation_id',$time_entry_details->designation_id)->where('deleted', 0)->get();

        return view('TimeTracking.time_entry_edit',compact('employees','time_entry_details','departments','designations'));
    }

      public function time_entry_view(Request $request,$time_tracking_id)
    {
        $time_tracking_id = base64_decode($time_tracking_id);
        $user = Auth::user();

        $time_entry_details = TimeTracking::where('time_tracking_id', $time_tracking_id)->where('deleted', 0)->first();

        $employees = Employee::where('employee_id',$time_entry_details->employee_id)->where('deleted', 0)->first();

        $departments = Department::where('department_id',$time_entry_details->department_id)->where('deleted', 0)->first();

        $designations = Designations::where('designation_id',$time_entry_details->designation_id)->where('deleted', 0)->first();

        return view('TimeTracking.time_entry_view',compact('employees','time_entry_details','departments','designations'));
    }

    

    public function get_employee_details(Request $request)
    {

        $employee = Employee::query()

            ->leftJoin(
                'designations',
                'designations.designation_id',
                '=',
                'employees.designation_id'
            )

            ->leftJoin(
                'departments',
                'departments.department_id',
                '=',
                'employees.department_id'
            )

            ->where(
                'employees.employee_id',
                $request->employee_id
            )

            ->select(

                'employees.employee_code',

                'employees.designation_id',

                'employees.department_id',

                'designations.name as designation_name',

                'departments.name as department_name'

            )->where('employees.deleted', 0)->first();

        return response()->json($employee);
    }



    public function store_time_tracking(Request $request)
    {
        $request->validate([

            'employee_id' => 'required',

            'start_time' => 'required',

            'end_time' => 'required',

            'dask_description' => 'required',

        ]);

        TimeTracking::create([

            'employee_id' => $request->employee_id,

            'employee_code' => $request->employee_code,

            'designation_id' => $request->designation_id,

            'department_id' => $request->department_id,

            'project_task' => $request->project_task,

            'form_date' => $request->form_date,

            'start_time' => $request->start_time,

            'end_time' => $request->end_time,

            'total_work_hours' => $request->total_work_hours,

            'dask_description' => $request->dask_description,

            'created_by' => Auth::id(),

        ]);

        return redirect()->route('time_tracking')->with('toast_success', 'Time Entry Added Successfully');
    }

    public function update_time_tracking(Request $request)
    {
        $request->validate([

            'employee_id' => 'required',

            'start_time' => 'required',

            'end_time' => 'required',

            'dask_description' => 'required',
        ]);

      
        $time_tracking = TimeTracking::where('time_tracking_id',$request->time_tracking_id)->first();

     
        if (!$time_tracking) {

            return redirect()->route('time_tracking')->with('toast_error','Time Tracking not found.');
        }

    
        $time_tracking->employee_id = $request->employee_id;

        $time_tracking->employee_code = $request->employee_code;

        $time_tracking->designation_id = $request->designation_id;

        $time_tracking->department_id = $request->department_id;

        $time_tracking->project_task = $request->project_task;

        $time_tracking->form_date = $request->form_date;

        $time_tracking->start_time = $request->start_time;

        $time_tracking->end_time = $request->end_time;

        $time_tracking->total_work_hours = $request->total_work_hours;

        $time_tracking->dask_description = $request->dask_description;

        $time_tracking->updated_by = Auth::user()->id;

        $time_tracking->save();

        return redirect()->route('time_tracking')->with('toast_success','Time Entry Updated Successfully');
    }


      public function time_tracking_delete(Request $request)
    {
        $time_tracking = TimeTracking::find($request->time_tracking_id);

        if(!$time_tracking){

            return response()->json([

                'status' => false,

                'message' => 'Time Entry not found'
            ]);
        }

        $time_tracking->deleted = 1;

        $time_tracking->updated_by = Auth::id();

        $time_tracking->save();

        return response()->json([

            'status' => true,

            'message' => 'Time Entry deleted successfully'
        ]);
    }


     public function time_entry_excel(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id == 4) {

            $time_entry = TimeTracking::where('employee_id', $user->employee_id)->where('deleted', 0)->first();

            if (!$time_entry) {
                return redirect()->back()->with('toast_error','Time Entry record not found.');
            }

            return Excel::download(new TimeTrackingExport($time_entry->employee_id),'time_entry_details.xlsx');
        }

        return Excel::download( new TimeTrackingExport(),'time_entry_details.xlsx');
    }


}