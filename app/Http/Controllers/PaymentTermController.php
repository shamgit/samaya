<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\PaymentTerm;

class PaymentTermController extends Controller
{
    
    public function payment_terms(Request $request)
    {

        $payment_terms = PaymentTerm::where('deleted', 0)->get();
        return view('PaymentTerms.payment_terms',compact('payment_terms'));
    }

     public function payment_term_list_table(Request $request)
    {
        $query = PaymentTerm::where('payment_terms.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'payment_terms.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'payment_terms.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('payment_terms.name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->payment_term_id)) {

            $query->where('payment_terms.payment_term_id', $request->payment_term_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('payment_terms.name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('payment_terms.payment_term_id', 'ASC');

        } else {

            $query->latest('payment_terms.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'payment_terms.payment_term_id',
                'payment_terms.name',
                'created_user.name as created_by',
                'payment_terms.created_at',
                'updated_user.name as updated_by',
                'payment_terms.updated_at'

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



    public function payment_term_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('payment_terms')->with('toast_error', 'Payment Terms not found.');
        }

        $payment_terms = new PaymentTerm(); 

        // Assign other fields
        $payment_terms->name = $request->name;
        $payment_terms->created_by = Auth::user()->id;

        $payment_terms->save();

        // dd($payment_terms);

        return redirect()->route('payment_terms')->with('toast_success', 'Payment Terms added successfully!');


    }



     public function payment_term_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('payment_terms')->with('toast_error', 'Payment Term not found.');
        }

        $payment_terms = PaymentTerm::find($request->payment_term_id);

        $department_details = PaymentTerm::where('payment_term_id',$request->payment_term_id)->first();


        // Update project fields
        $payment_terms->name = $request->name;
        $payment_terms->updated_by = Auth::user()->id;

        $payment_terms->save();

        return redirect()->route('payment_terms')->with('toast_success', 'Payment Term updated successfully!');
    }


     public function payment_term_edit(Request $request)
    {

        
        $payment_term_details = PaymentTerm::where('payment_term_id',$request->payment_term_id)->where('deleted', 0)->first();

        // dd($payment_term_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="payment_term_id" value="'. $payment_term_details->payment_term_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Payment Term Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" name="name"  value="' . $payment_term_details->name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function payment_term_delete(Request $request)
    {
        $payment_terms = PaymentTerm::find($request->payment_term_id);

        if(!$payment_terms){

            return response()->json([
                'status' => false,
                'message' => 'Payment Term not found'
            ]);
        }

        $payment_terms->deleted = 1;

        $payment_terms->updated_by = Auth::id();

        $payment_terms->save();

        return response()->json([

            'status' => true,

            'message' => 'Payment Term deleted successfully'
        ]);
    }
}