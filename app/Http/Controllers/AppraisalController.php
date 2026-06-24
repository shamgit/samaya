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
use App\Models\EmployeeAppraisal;



class AppraisalController extends Controller
{
    
    public function appraisal_management(Request $request)
    {

        $user = Auth::user();

         if ($user->role_id == 4) {

            $employee = Employee::where('employee_id',$user->employee_id)->where('deleted', 0)->first();

            if ($employee) {
                $employees = Employee::where('employee_id',$employee->employee_id)->where('deleted', 0)->get();
                $employee_count = Employee::where('employee_id',$employee->employee_id)->where('deleted', 0)->count();
                $panding_count = EmployeeAppraisal::where('employee_id',$employee->employee_id)->where('status', 1)->where('deleted', 0)->count();
                $departments = Department::where('department_id',$employee->department_id)->where('deleted', 0)->get();

            } else {

                $employees = collect();
            }

        } else {
            $employee_count = Employee::where('deleted', 0)->count();
            $panding_count = EmployeeAppraisal::where('status', 1)->where('deleted', 0)->count();
            $employees = Employee::where('deleted', 0)->get();
            $departments = Department::where('deleted', 0)->get();
        }

        return view('Appraisal.appraisal_management',compact('employees','panding_count','departments','employee_count'));
    }

     public function appraisal_evaluation_form(Request $request)
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


        return view('Appraisal.appraisal_evaluation_form',compact('employees'));
    }

       public function appraisal_list_table(Request $request)
    {

        $user = Auth::user();

        $query = EmployeeAppraisal::query()->where('employee_appraisals.deleted', 0)
                ->leftJoin('employees','employees.employee_id','=','employee_appraisals.employee_id' )
                ->leftJoin('departments','departments.department_id','=','employee_appraisals.department_id' )
                ->leftJoin('users as created_user','created_user.id','=','employee_appraisals.created_by');

        if ($user->role_id == 4) {

            $query->where(
                'employee_appraisals.employee_id',
                $user->employee_id
            );
        }

        $totalRecords = EmployeeAppraisal::where('deleted', 0)->count();


        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->where('employee_appraisals.employee_code', 'LIKE', "%{$search}%")

                    ->orWhere('employees.employee_name', 'LIKE', "%{$search}%")

                    ->orWhere('departments.name', 'LIKE', "%{$search}%")

                    ->orWhere('employee_appraisals.review_period', 'LIKE', "%{$search}%")

                    ->orWhere('employee_appraisals.rating_scale', 'LIKE', "%{$search}%")

                    ->orWhere('employee_appraisals.salary_increment_recommendation', 'LIKE', "%{$search}%")

                    ->orWhere('employee_appraisals.status', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->employee_id)) {

            $query->where('employee_appraisals.employee_id', $request->employee_id);
        }

        if (!empty($request->department_id)) {

            $query->where('employee_appraisals.department_id', $request->department_id);
        }

        if (!empty($request->status)) {

            $query->where('employee_appraisals.status', $request->status);
        }



    
        $filteredRecords = $query->count();


        if ($request->sort == 'name') {

            $query->orderBy(
                'employee_appraisals.employee_id',
                'ASC'
            );

        } elseif ($request->sort == 'created_at') {

            $query->orderBy(
                'employee_appraisals.created_at',
                'DESC'
            );

        } else {

            $query->latest('employee_appraisals.created_at');
        }



        $data = $query->select(

                'employee_appraisals.appraisal_id',

                'employee_appraisals.employee_code',

                'employees.employee_name',

                'departments.name as  department_name',

                'employee_appraisals.review_period',

                'employee_appraisals.rating_scale',

                'employee_appraisals.salary_increment_recommendation',

                'employee_appraisals.status',
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


     public function appraisal_store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'rating_scale' => 'required',
            'salary_increment_recommendation' => 'required',
            'manager_feedback' => 'required',
        ]);

        EmployeeAppraisal::create([
            'employee_id' => $request->employee_id,
            'employee_code' => $request->employee_code,
            'designation_id' => $request->designation_id,
            'department_id' => $request->department_id,
            'review_period' => $request->review_period,
            'rating_scale' => $request->rating_scale,
            'salary_increment_recommendation' => str_replace(',', '', $request->salary_increment_recommendation),
            'manager_feedback' => $request->manager_feedback,
            'status' => 1
        ]);

        return redirect()->route('appraisal_management')->with('toast_success', 'Appraisal Saved Successfully');
    }

    public function appraisal_update(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'rating_scale' => 'required',
            'salary_increment_recommendation' => 'required',
            'manager_feedback' => 'required',
        ]);

        $appraisal = EmployeeAppraisal::where('appraisal_id',$request->appraisal_id)->firstOrFail();

        $status = ($request->action == 'approval') ? 2 : 1;

        $appraisal->update([
            'employee_id' => $request->employee_id,
            'employee_code' => $request->employee_code,
            'designation_id' => $request->designation_id,
            'department_id' => $request->department_id,
            'review_period' => $request->review_period,
            'rating_scale' => $request->rating_scale,
            'salary_increment_recommendation' => str_replace(',', '', $request->salary_increment_recommendation),
            'manager_feedback' => $request->manager_feedback,
            'status' => $status,
        ]);

        if ($status == 2) {
            return redirect()->route('appraisal_management')->with('toast_success', 'Appraisal sent for approval successfully');
        }

        return redirect()->route('appraisal_management')->with('toast_success', 'Appraisal updated successfully');
    }

     public function appraisal_evaluation_edit(Request $request,$appraisal_id)
    {

        $appraisal_id = base64_decode($appraisal_id);

        $user = Auth::user();
        $appraisals_details = EmployeeAppraisal::where('appraisal_id', $appraisal_id)->where('deleted', 0)->first();

        $employees = Employee::where('employee_id',$appraisals_details->employee_id)->where('deleted', 0)->get();

        $departments = Department::where('department_id',$appraisals_details->department_id)->where('deleted', 0)->get();

        $designations = Designations::where('designation_id',$appraisals_details->designation_id)->where('deleted', 0)->get();
        
       

        return view('Appraisal.appraisal_evaluation_edit',compact('departments','designations','employees','appraisals_details'));
    }

     public function appraisal_evaluation_view(Request $request,$appraisal_id)
    {

        $appraisal_id = base64_decode($appraisal_id);
        $user = Auth::user();
        $appraisals_details = EmployeeAppraisal::where('employee_appraisals.appraisal_id',$appraisal_id)
        ->leftJoin(
            'employees',
            'employees.employee_id',
            '=',
            'employee_appraisals.employee_id'
        )
        ->leftJoin(
            'departments',
            'departments.department_id',
            '=',
            'employee_appraisals.department_id'
        )
        ->leftJoin(
            'designations',
            'designations.designation_id',
            '=',
            'employee_appraisals.designation_id'
        )
        ->where('employee_appraisals.deleted', 0)
        ->select(
            'employee_appraisals.*',
            'employees.employee_name',
            'employees.employee_code',
            'employees.email',
            'designations.name as designation_name',
            'departments.name as department_name'
        )
        ->first();

        $departments = Department::where('deleted', 0)->get();

        return view('Appraisal.appraisal_evaluation_view',compact('departments','appraisals_details'));
    }

}