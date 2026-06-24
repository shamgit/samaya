<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Designations;
use App\Models\Employee;
use App\Models\Roles;
use App\Models\User;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function employee_management(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id == 4) {

            $employee = Employee::where('employee_id',$user->employee_id)->where('deleted', 0)->first();

            if ($employee) {
                $departments = Department::where('department_id',$employee->department_id)->where('deleted', 0)->get();

            } else {

                $departments = collect();
            }

        } else {

            $departments = Department::where('deleted', 0)->get();
        }

        return view('Employees.employee_management',compact('departments'));
    }

     public function employee_add(Request $request)
    {

       $departments = Department::where('deleted', 0)->get();
       $designations = Designations::where('designation_type', 1)->where('role_id', 4)->where('deleted', 0)->get();
       $roles =  Roles::where('role_id', 4)->where('deleted', 0)->get();

        return view('Employees.employee_add',compact('departments','designations','roles'));
    }

        public function get_employee_code()
    {

    
        $employee = Employee::orderBy('employee_id', 'DESC')->first();

    
        $lastId = $employee ? $employee->employee_id : 0;

        return response()->json([

            'last_id' => $lastId
        ]);
    }

      public function employee_edit(Request $request,$employee_id)
    {
        $employee_id = base64_decode($employee_id);

        $user = Auth::user();
        $employees = User::where('employee_id',$user->employee_id)->where('deleted', 0)->first();
        $employee_details = Employee::where('employee_id',$employee_id)->where('deleted', 0)->first();
        $departments = Department::where('deleted', 0)->get();
        $designations = Designations::where('designation_type', 1)->where('role_id', 4)->where('deleted', 0)->get();
        $roles =  Roles::where('role_id',4)->where('deleted', 0)->get();
       
        return view('Employees.employee_edit',compact('employee_details','departments','designations','roles','employees'));
    }

     public function employee_view(Request $request,$employee_id)
    {
        $employee_id = base64_decode($employee_id);
        $employee_details = Employee::where('employees.employee_id', $employee_id)->leftJoin('departments', 'departments.department_id', '=', 'employees.department_id')->leftJoin('designations', 'designations.designation_id', '=', 'employees.designation_id')->select('employees.*', 'departments.name','designations.name as designation_name')->where('employees.deleted', 0)->first();
       

        return view('Employees.employee_view',compact('employee_details'));
    }

        public function employee_list_table(Request $request)
    {

        $user = Auth::user();

        $query = Employee::query()->where('employees.deleted', 0)->leftJoin('designations','designations.designation_id','=','employees.designation_id')
                ->leftJoin('departments','departments.department_id','=','employees.department_id' )
                ->leftJoin('users as created_user','created_user.id','=','employees.created_by');

        if ($user->role_id == 4) {

            $query->where(
                'employees.employee_id',
                $user->employee_id
            );
        }

        $totalRecords = Employee::where('deleted', 0)->count();


        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->where('employees.employee_code', 'LIKE', "%{$search}%")

                    ->orWhere('employees.employee_name', 'LIKE', "%{$search}%")

                    ->orWhere('employees.phone', 'LIKE', "%{$search}%")

                    ->orWhere('departments.name', 'LIKE', "%{$search}%")

                    ->orWhere('designations.name', 'LIKE', "%{$search}%")

                    ->orWhere('employees.phone', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->department_id)) {

            $query->where('employees.department_id', $request->department_id);
        }

    
        if ($request->status != '') {

            $query->where('employees.status', $request->status);
        }

    
        $filteredRecords = $query->count();


        if ($request->sort == 'name') {

            $query->orderBy('employees.employee_name', 'ASC');

        } elseif ($request->sort == 'created_at') {

            $query->orderBy('employees.created_at', 'DESC');

        } else {

            $query->latest('employees.created_at');
        }


        $data = $query->select(

                'employees.employee_id',

                'employees.employee_code',

                'employees.employee_name',

                'designations.name',

                'departments.name as department_name',

                'employees.joining_date',

                'employees.phone',
                

                'employees.status',
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


        public function employee_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'designation_id'    => 'required',
            'department_id'     => 'required',
            'employee_name'     => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'password'          => 'required|min:8',
            'gender'            => 'required',
            'date_of_birth'     => 'required',
            'joining_date'      => 'required',
            'role_id'           => 'required',
            'address'           => 'required',
            'city'              => 'required',
            'state'             => 'required',
            'zip_code'          => 'required',
            'company_name'     => 'required',
            'status'            => 'required',
            'employee_type'     => 'required',
            'employee_document' => 'required',
            'bank_name'     => 'required',
            'bank_account_no'     => 'required',
            'ifsc_code'     => 'required',
            'bank_address'     => 'required',
            'payment_type'     => 'required',

        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('toast_error', 'Leave Validator.');
        }


        $documentName = null;

        if ($request->hasFile('employee_document')) {

            $file = $request->file('employee_document');

            $documentName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('assets/employee_document'), $documentName);
        }


       $employee = Employee::create([
            'designation_id'    => $request->designation_id,
            'department_id'     => $request->department_id,
            'role_id'       => $request->role_id,
            'employee_name'     => $request->employee_name,
            'employee_code'     => $request->employee_code,
            'phone'             => $request->phone,
            'gender'            => $request->gender,
            'date_of_birth'      => $request->date_of_birth,
            'email'             => $request->email,
            'address'           => $request->address,
            'city'              => $request->city,
            'state'             => $request->state,
            'zip_code'          => $request->zip_code,
            'joining_date'      => $request->joining_date,
            'company_name'      => $request->company_name,
            'employee_type'     => $request->employee_type,
            'employee_document' => $documentName,
            'bank_name'         => $request->bank_name,
            'bank_account_no'   => $request->bank_account_no,
            'ifsc_code'         => $request->ifsc_code,
            'bank_address'      => $request->bank_address,
            'pf_number'         => $request->pf_number,
            'payment_type'      => $request->payment_type,
            'basic_salary'      => $request->basic_salary,
            'allowances'        => $request->allowances,
            'total_salary'      => $request->total_salary,
            'status'            => $request->status,
            'created_by'        => Auth::user()->id,

        ]);

        User::create([
            'employee_id'    => $employee->employee_id,
            'name'          => $request->employee_name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'plain_password' => $request->password,
            'phone'         => $request->phone,
            'role_id'       => $request->role_id,
            'employee_code' => $request->employee_code,
            'status'        => $request->status,

        ]);

        return redirect()->route('employee_management')->with('toast_success', 'Employee added successfully!');
    }


       public function employee_update(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'designation_id'    => 'required',
            'department_id'     => 'required',
            'employee_name'     => 'required',
            'email'             => 'required',
            'password'          => 'required|min:8',
            'phone'             => 'required',
            'role_id'           => 'required',
            'gender'            => 'required',
            'date_of_birth'     => 'required',
            'joining_date'      => 'required',
            'company_name'     => 'required',
            'address'           => 'required',
            'city'              => 'required',
            'state'             => 'required',
            'zip_code'          => 'required',
            'status'            => 'required',
            'employee_type'     => 'required',
            'bank_name'     => 'required',
            'bank_account_no'     => 'required',
            'ifsc_code'     => 'required',
            'bank_address'     => 'required',
            'payment_type'     => 'required',

        ]);

        
        if ($validator->fails()) { 
            return redirect()->back()->withErrors($validator)->withInput()->with('toast_error', 'Leave Validator.');
        }


        $employee = Employee::where('employee_id', $request->employee_id)->first();

        if (!$employee) {
            return redirect()->back()->with('toast_error', 'Employee not found');
        }

        if ($request->hasFile('employee_document')) {

            if (!empty($employee->employee_document)) {

                $oldFile = public_path(
                    'assets/employee_document/' .
                    $employee->employee_document
                );

                if (file_exists($oldFile)) {

                    unlink($oldFile);
                }
            }

            $file = $request->file('employee_document');

            $documentName = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('assets/employee_document'),
                $documentName
            );

            $employee->employee_document = $documentName;
        }

        $employee->designation_id = $request->designation_id;

        $employee->department_id = $request->department_id;

        $employee->role_id = $request->role_id;

        $employee->employee_name = $request->employee_name;

        $employee->employee_code = $request->employee_code;

        $employee->phone = $request->phone;

        $employee->gender = $request->gender;

        $employee->date_of_birth = $request->date_of_birth;

        $employee->email = $request->email;

        $employee->address = $request->address;

        $employee->city = $request->city;

        $employee->state = $request->state;

        $employee->zip_code = $request->zip_code;

        $employee->joining_date = $request->joining_date;

        $employee->company_name = $request->company_name;

        $employee->employee_type = $request->employee_type;

        $employee->bank_name = $request->bank_name;

        $employee->bank_account_no = $request->bank_account_no;

        $employee->ifsc_code = $request->ifsc_code;

        $employee->bank_address = $request->bank_address;

        $employee->pf_number = $request->pf_number;

        $employee->payment_type = $request->payment_type;

        $employee->basic_salary = $request->basic_salary;

        $employee->allowances = $request->allowances;

        $employee->total_salary = $request->total_salary;

        $employee->status = $request->status;

        $employee->updated_by = Auth::user()->id;

        $employee->save();


        $user = User::where('employee_id', $employee->employee_id)->first();

        if ($user) {

            $user->name = $request->employee_name;

            $user->email = $request->email;

            $user->phone = $request->phone;

            $user->role_id = $request->role_id;

            $user->employee_code = $request->employee_code;

            $user->status = $request->status;

           
            if (!empty($request->password)) {

                $user->password = Hash::make($request->password);

                $user->plain_password = $request->password;
            }

            $user->save();
        }


      return redirect()->route('employee_management')->with('toast_success','Employee updated successfully!');
    }
        

    
      public function employee_delete(Request $request)
    {
        $employee = Employee::find($request->employee_id);

        if(!$employee){

            return response()->json([

                'status' => false,

                'message' => 'Employee not found'
            ]);
        }

        $employee->deleted = 1;

        $employee->updated_by = Auth::id();

        $employee->save();

        return response()->json([

            'status' => true,

            'message' => 'Employee deleted successfully'
        ]);
    }

    public function employee_excel(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id == 4) {

            $employee = Employee::where('employee_id', $user->employee_id)
                ->where('deleted', 0)
                ->first();

            if (!$employee) {
                return redirect()->back()->with('toast_error','Employee record not found.');
            }

            return Excel::download(new EmployeeExport($employee->employee_id),'employee_details.xlsx');
        }

        return Excel::download( new EmployeeExport(),'employee_details.xlsx');
    }

}