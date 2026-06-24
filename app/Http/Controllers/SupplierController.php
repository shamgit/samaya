<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\PaymentTerm;
use App\Models\Category;
use App\Models\Supplier;
use App\Exports\SupplierExport;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{


    
    public function supplier(Request $request)
    {

        $categorys = Category::where('deleted', 0)->get();

        return view('Supplier.supplier',compact('categorys'));
    }

        public function suppliers_list_table(Request $request)
    {
        $query = Supplier::query()->where('suppliers.deleted', 0)->leftJoin('category','category.category_id','=','suppliers.category_id')
                ->leftJoin('payment_terms','payment_terms.payment_term_id','=','suppliers.payment_term_id' )
                ->leftJoin('users as created_user','created_user.id','=','suppliers.created_by');

        $totalRecords = Supplier::where('deleted', 0)->count();


        if (!empty($request->search['value'])) {

            $search = trim($request->search['value']);

            $query->where(function ($q) use ($search) {

                $q->where('suppliers.supplier_name', 'LIKE', "%{$search}%")

                    ->orWhere('suppliers.contact_person_name', 'LIKE', "%{$search}%")

                    ->orWhere('suppliers.phone', 'LIKE', "%{$search}%")

                    ->orWhere('category.category_name', 'LIKE', "%{$search}%")

                    ->orWhere('payment_terms.name', 'LIKE', "%{$search}%");
            });
        }


        if (!empty($request->category_id)) {

            $query->where('suppliers.category_id', $request->category_id);
        }

    
        if ($request->status != '') {

            $query->where('suppliers.status', $request->status);
        }

    
        $filteredRecords = $query->count();


        if ($request->sort == 'name') {

            $query->orderBy('suppliers.supplier_name', 'ASC');

        } elseif ($request->sort == 'created_at') {

            $query->orderBy('suppliers.created_at', 'DESC');

        } else {

            $query->latest('suppliers.created_at');
        }


        $data = $query->select(

                'suppliers.supplier_id',

                'suppliers.supplier_name',

                'suppliers.contact_person_name',

                'suppliers.phone',

                'category.category_name',

                'payment_terms.name as payment_term_name',

                'suppliers.status',

                'created_user.name as created_by',

                'suppliers.created_at'
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

     public function supplier_add(Request $request)
    {

        $categorys = Category::where('deleted', 0)->get();
        $payment_terms = PaymentTerm::where('deleted', 0)->get();

        return view('Supplier.supplier_add',compact('categorys','payment_terms'));
    }

      public function supplier_edit(Request $request,$supplier_id)
    {
        $supplier_id = base64_decode($supplier_id);
        $supplier_details = Supplier::where('supplier_id',$supplier_id)->where('deleted', 0)->first();
        $categorys = Category::where('deleted', 0)->get();
        $payment_terms = PaymentTerm::where('deleted', 0)->get();
       
        return view('Supplier.supplier_edit',compact('supplier_details','categorys','payment_terms'));
    }

     public function supplier_view(Request $request,$supplier_id)
    {
        $supplier_id = base64_decode($supplier_id);
        $supplier_details = Supplier::where('suppliers.supplier_id', $supplier_id)->leftJoin('category', 'category.category_id', '=', 'suppliers.category_id')->leftJoin('payment_terms', 'payment_terms.payment_term_id', '=', 'suppliers.payment_term_id')->select('suppliers.*', 'category.category_name','payment_terms.name')->where('suppliers.deleted', 0)->first();
       

        return view('Supplier.supplier_view',compact('supplier_details'));
    }


      public function suppliers_store(Request $request)
    {

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'supplier_name' => 'required',
            'contact_person_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'category_id' => 'required',
            'gst_tex' => 'required',  
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('supplier')->with('toast_error', 'Supplier not found.');
        }

        $supplier = new Supplier(); 

        // Assign other fields
        $supplier->supplier_name = $request->supplier_name;
        $supplier->contact_person_name = $request->contact_person_name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->city = $request->city;
        $supplier->state = $request->state;
        $supplier->zip_code = $request->zip_code;
        $supplier->category_id = $request->category_id;
        $supplier->gst_tex = $request->gst_tex;
        $supplier->bank_name = $request->bank_name;
        $supplier->account_number = $request->account_number;
        $supplier->ifsc_code = $request->ifsc_code;
        $supplier->status = $request->status;
        $supplier->payment_term_id = $request->payment_term_id;
        $supplier->created_by = Auth::user()->id;

        $supplier->save();

        // dd($supplier);

        return redirect()->route('supplier')->with('toast_success', 'Supplier added successfully!');

       
    }

      public function suppliers_update(Request $request)
    {

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'supplier_name' => 'required',
            'contact_person_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'category_id' => 'required',
            'gst_tex' => 'required',  
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('supplier')->with('toast_error', 'Supplier not found.');
        }

        $supplier = Supplier::find($request->supplier_id);

        $supplier_details = Supplier::where('supplier_id',$request->supplier_id)->first();

        // Assign other fields
        $supplier->supplier_name = $request->supplier_name;
        $supplier->contact_person_name = $request->contact_person_name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->city = $request->city;
        $supplier->state = $request->state;
        $supplier->zip_code = $request->zip_code;
        $supplier->category_id = $request->category_id;
        $supplier->gst_tex = $request->gst_tex;
        $supplier->bank_name = $request->bank_name;
        $supplier->account_number = $request->account_number;
        $supplier->ifsc_code = $request->ifsc_code;
        $supplier->status = $request->status;
        $supplier->payment_term_id = $request->payment_term_id;
        $supplier->updated_by = Auth::user()->id;

        $supplier->save();

        // dd($supplier);

        return redirect()->route('supplier')->with('toast_success', 'Supplier updated successfully!');

       
    }

     public function suppliers_delete(Request $request)
    {
        $supplier = Supplier::find($request->supplier_id);

        if(!$supplier){

            return response()->json([

                'status' => false,

                'message' => 'Supplier not found'
            ]);
        }

        $supplier->deleted = 1;

        $supplier->updated_by = Auth::id();

        $supplier->save();

        return response()->json([

            'status' => true,

            'message' => 'Supplier deleted successfully'
        ]);
    }


    public function supplier_excel(Request $request)
    {
        return Excel::download(new SupplierExport(),'supplier_details.xlsx');
    }
}