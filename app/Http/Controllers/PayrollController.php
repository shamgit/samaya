<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Designations;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PayslipMail;
use Illuminate\Support\Facades\Mail;
use App\Exports\PayrollExport;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
    
    public function payroll_management(Request $request)
    {

        $departments = Department::where('deleted', 0)->get();

        $employee_count = Employee::where('deleted', 0)->count();

        $payslips_generated_count = Payroll::where('payroll_status', 2)->where('deleted', 0)->count();

        $total_payroll_amount = Payroll::where('deleted', 0)->sum('net_salary');

        $total_deductions = Payroll::where('deleted', 0)->sum('net_deduction');

        return view('Payroll.payroll_management',compact('employee_count','payslips_generated_count','total_payroll_amount','total_deductions','departments'));
    }

     public function process_payroll(Request $request)
    {
        $employees = Employee::where('deleted', 0)->get();


        return view('Payroll.process_payroll',compact('employees'));
    }

        public function payroll_list_table(Request $request)
    {
        $query = Payroll::query()->where('payrolls.deleted', 0)->leftJoin('employees','employees.employee_id','=','payrolls.employee_id')
                ->leftJoin('departments','departments.department_id','=','payrolls.department_id' )
                ->leftJoin('users as created_user','created_user.id','=','payrolls.created_by');

        $totalRecords = Payroll::where('deleted', 0)->count();


        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->where('payrolls.employee_code', 'LIKE', "%{$search}%")

                    ->orWhere('employees.employee_name', 'LIKE', "%{$search}%")

                    ->orWhere('departments.name', 'LIKE', "%{$search}%")

                    ->orWhere('payrolls.basic_salary', 'LIKE', "%{$search}%")

                    ->orWhere('payrolls.net_allowance', 'LIKE', "%{$search}%")
                    
                    ->orWhere('payrolls.net_deduction', 'LIKE', "%{$search}%")

                    ->orWhere('payrolls.net_salary', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->department_id)) {

            $query->where('payrolls.department_id', $request->department_id);
        }

    
        if ($request->payroll_status != '') {

            $query->where('payrolls.payroll_status', $request->payroll_status);
        }

    
        $filteredRecords = $query->count();


        if ($request->sort == 'name') {

            $query->orderBy('employees.employee_name', 'ASC');

        } elseif ($request->sort == 'created_at') {

            $query->orderBy('payrolls.created_at', 'DESC');

        } else {

            $query->latest('payrolls.created_at');
        }


        $data = $query->select(

                'payrolls.payroll_id',

                'payrolls.employee_code',

                'employees.employee_name',

                'departments.name as department_name',

                'payrolls.basic_salary',

                'payrolls.net_allowance',

                'payrolls.net_deduction',

                'payrolls.net_salary',

                'payrolls.payroll_status',

                'created_user.name as created_by',

                'payrolls.created_at'
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


        public function save_payroll(Request $request)
    {

        $payroll = Payroll::create([

            'employee_id'          => $request->employee_id,

            'employee_code'        => $request->employee_code,

            'designation_id'       => $request->designation_id,

            'department_id'        => $request->department_id,

            'pay_period_start_date'=> $request->pay_period_start_date,

            'pay_period_end_date'  => $request->pay_period_end_date,

            'pay_date'             => $request->pay_date,

            'basic_salary'         => $request->basic_salary,

            'hra'                  => $request->hra,

            'transport_allowance'  => $request->transport_allowance,

            'other_allowance'      => $request->other_allowance,

            'total_allowance'      => $request->total_allowance,

            'pf'                   => $request->pf,

            'professional_tax'     => $request->professional_tax,

            'other_deduction'      => $request->other_deduction,

            'total_deduction'      => $request->total_deduction,

            'income_tax'           => $request->income_tax,

            'net_basic_salary'           => $request->net_basic_salary,

            'net_allowance'           => $request->net_allowance,

            'net_deduction'           => $request->net_deduction,

            'net_salary'           => $request->net_salary,

            'payroll_status'       => 1,

            'created_by'           => Auth::id()

        ]);

        return redirect()->route('payroll_management')->with('toast_success','Payroll Saved Successfully');

    }

        public function update_payroll(Request $request)
    {

        $payroll = Payroll::where('payroll_id', $request->payroll_id)->first();

        if (!$payroll) {

            return redirect()->back()->with('toast_error', 'Payroll not found');

        }

      

     if ($request->action == 'save') {
         $payroll->update([

            'employee_id'           => $request->employee_id,

            'employee_code'         => $request->employee_code,

            'designation_id'        => $request->designation_id,

            'department_id'         => $request->department_id,

            'pay_period_start_date' => $request->pay_period_start_date,

            'pay_period_end_date'   => $request->pay_period_end_date,

            'pay_date'              => $request->pay_date,

            'basic_salary'          => $request->basic_salary,

            'hra'                   => $request->hra,

            'transport_allowance'   => $request->transport_allowance,

            'other_allowance'       => $request->other_allowance,

            'total_allowance'       => $request->total_allowance,

            'pf'                    => $request->pf,

            'professional_tax'      => $request->professional_tax,

            'other_deduction'       => $request->other_deduction,

            'total_deduction'       => $request->total_deduction,

            'income_tax'            => $request->income_tax,

            'net_basic_salary'      => $request->net_basic_salary,

            'net_allowance'         => $request->net_allowance,

            'net_deduction'         => $request->net_deduction,

            'net_salary'            => $request->net_salary,

            'updated_by'            => Auth::id()

        ]);

      return redirect()->route('payroll_management')->with('toast_success', 'Payroll Updated Successfully');

    } elseif ($request->action == 'process') {
        $payroll->update([

            'employee_id'           => $request->employee_id,

            'employee_code'         => $request->employee_code,

            'designation_id'        => $request->designation_id,

            'department_id'         => $request->department_id,

            'pay_period_start_date' => $request->pay_period_start_date,

            'pay_period_end_date'   => $request->pay_period_end_date,

            'pay_date'              => $request->pay_date,

            'basic_salary'          => $request->basic_salary,

            'hra'                   => $request->hra,

            'transport_allowance'   => $request->transport_allowance,

            'other_allowance'       => $request->other_allowance,

            'total_allowance'       => $request->total_allowance,

            'pf'                    => $request->pf,

            'professional_tax'      => $request->professional_tax,

            'other_deduction'       => $request->other_deduction,

            'total_deduction'       => $request->total_deduction,

            'income_tax'            => $request->income_tax,

            'net_basic_salary'      => $request->net_basic_salary,

            'net_allowance'         => $request->net_allowance,

            'net_deduction'         => $request->net_deduction,

            'net_salary'            => $request->net_salary,

            'payroll_status'       => 2,

            'updated_by'            => Auth::id()

        ]);

         return redirect()->route('payroll_management')->with('toast_success', 'Processed Payroll Successfully');
    }
    
  
    }

      public function process_payroll_edit(Request $request,$payroll_id)
    {
        $payroll_id = base64_decode($payroll_id);
       
        $payroll_details = Payroll::where('payroll_id',$payroll_id)->where('deleted', 0)->first();
    
        $employees = Employee::where('employee_id',$payroll_details->employee_id)->where('deleted', 0)->get();

        $departments = Department::where('department_id',$payroll_details->department_id)->where('deleted', 0)->get();

        $designations = Designations::where('designation_id',$payroll_details->designation_id)->where('deleted', 0)->get();
       
        return view('Payroll.process_payroll_edit',compact('payroll_details','employees','departments','designations'));
    }

    public function generate_payslip(Request $request,$payroll_id)
    {
        $payroll_id = base64_decode($payroll_id);

        $payroll = Payroll::leftJoin(
                'employees',
                'employees.employee_id',
                '=',
                'payrolls.employee_id'
            )

            ->leftJoin(
                'designations',
                'designations.designation_id',
                '=',
                'payrolls.designation_id'
            )

            ->leftJoin(
                'departments',
                'departments.department_id',
                '=',
                'payrolls.department_id'
            )

            ->where('payrolls.payroll_id', $payroll_id)
            ->where('payrolls.deleted', 0)
            ->select(

                'payrolls.*',

                'employees.employee_name',

                'employees.joining_date',

                'employees.pf_number',

                'employees.company_name',

                'designations.name as designation_name',

                'departments.name as department_name'

            )

            ->first();

        return view('Payroll.generate_payslip',compact('payroll'));
    }



        public function download_payslip_pdf(Request $request)
        {
            $payroll = DB::table('payrolls')
                ->where('payrolls.deleted', 0)
                ->leftJoin('employees', 'employees.employee_id', '=', 'payrolls.employee_id')
                ->leftJoin('departments', 'departments.department_id', '=', 'employees.department_id')
                ->leftJoin('designations', 'designations.designation_id', '=', 'employees.designation_id')
                ->where('payrolls.payroll_id', $request->payroll_id)
                ->select(
                    'payrolls.*',
                    'employees.employee_name',
                    'employees.employee_code',
                    'employees.joining_date',
                    'employees.pf_number',
                    'designations.name as designation_name',
                    'departments.name as department_name'
                )
                ->first();

            $pdf = Pdf::loadView('payroll.payslip_pdf',compact('payroll'));

            $fileName = $payroll->employee_name . '_Payslip_' .
                        date('F_Y', strtotime($payroll->pay_date)) . '.pdf';

            return $pdf->download($fileName);
        }


        public function send_email(Request $request)
    {
        try {

            $payroll_id = $request->payroll_id;

            $payroll = Payroll::leftJoin(
                    'employees',
                    'employees.employee_id',
                    '=',
                    'payrolls.employee_id'
                )
                ->leftJoin(
                    'designations',
                    'designations.designation_id',
                    '=',
                    'payrolls.designation_id'
                )
                ->leftJoin(
                    'departments',
                    'departments.department_id',
                    '=',
                    'payrolls.department_id'
                )
                ->where('payrolls.payroll_id', $payroll_id)
                ->where('payrolls.deleted', 0)
                ->select(
                    'payrolls.*',
                    'employees.employee_name',
                    'employees.email as employee_email', 
                    'employees.joining_date',
                    'employees.pf_number',
                    'employees.company_name',
                    'designations.name as designation_name',
                    'departments.name as department_name'
                )
                ->first();

            if (!$payroll) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payroll not found'
                ]);
            }

            $employeeEmail = $payroll->employee_email;
            $employeeName  = $payroll->employee_name;

            if (empty($employeeEmail)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Employee email not found'
                ]);
            }

            // Generate PDF
            $pdf = Pdf::loadView('payroll.payslip_pdf', [
                'payroll' => $payroll
            ]);

            // Send Email
            Mail::to($employeeEmail)->send(
                new PayslipMail(
                    $payroll,
                    $employeeName,
                    $pdf->output()
                )
            );

            return response()->json([
                'status' => true,
                'message' => 'Payslip sent successfully to ' . $employeeEmail
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);

        }
    }


      public function payroll_excel(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id == 4) {

            $payroll = Payroll::where('employee_id', $user->employee_id)->where('deleted', 0)->first();

            if (!$payroll) {
                return redirect()->back()->with('toast_error','Payroll record not found.');
            }

            return Excel::download(new PayrollExport($payroll->employee_id),'payroll_details.xlsx');
        }

        return Excel::download( new PayrollExport(),'payroll_details.xlsx');
    }

}