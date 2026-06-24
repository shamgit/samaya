<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequestStatus;
use Illuminate\Support\Facades\Validator;


class PurchaseRequestStatusController extends Controller
{
    
    public function purchase_request_status(Request $request)
    {

        $purchase_request_status = PurchaseRequestStatus::where('deleted', 0)->get();

        return view('PurchaseStatus.purchase_request_status',compact('purchase_request_status'));
    }


    public function purchase_request_status_list_table(Request $request)
    {
        $query = PurchaseRequestStatus::where('purchase_request_status.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'purchase_request_status.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'purchase_request_status.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('purchase_request_status.name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->purchase_request_status_id)) {

            $query->where('purchase_request_status.purchase_request_status_id', $request->purchase_request_status_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('purchase_request_status.name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('purchase_request_status.purchase_request_status_id', 'ASC');

        } else {

            $query->latest('purchase_request_status.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'purchase_request_status.purchase_request_status_id',
                'purchase_request_status.name',
                'created_user.name as created_by',
                'purchase_request_status.created_at',
                'updated_user.name as updated_by',
                'purchase_request_status.updated_at'

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



    public function purchase_request_status_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('purchase_request_status')->with('toast_error', 'Purchase Request Statu not found.');
        }

        $purchase_request_status = new PurchaseRequestStatus(); 

        // Assign other fields
        $purchase_request_status->name = $request->name;
        $purchase_request_status->created_by = Auth::user()->id;

        $purchase_request_status->save();

        // dd($purchase_request_status);

        return redirect()->route('purchase_request_status')->with('toast_success', ' Purchase Request Statu added successfully!');


    }



     public function purchase_request_status_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('purchase_request_status')->with('toast_error', ' Purchase Request Statu not found.');
        }

        $purchase_request_status = PurchaseRequestStatus::find($request->purchase_request_status_id);

        $purchase_request_statu_details = PurchaseRequestStatus::where('purchase_request_status_id',$request->purchase_request_status_id)->first();


       
        $purchase_request_status->name = $request->name;
        $purchase_request_status->updated_by = Auth::user()->id;

        $purchase_request_status->save();

        return redirect()->route('purchase_request_status')->with('toast_success', 'Purchase Request Statu updated successfully!');
    }


     public function purchase_request_status_edit(Request $request)
    {

        
        $purchase_request_statu_details = PurchaseRequestStatus::where('purchase_request_status_id',$request->purchase_request_status_id)->where('deleted', 0)->first();

        // dd($purchase_request_statu_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="purchase_request_status_id" value="'. $purchase_request_statu_details->purchase_request_status_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label"> Purchase Request Statu Name *</label>
                    <input type="text" class="form-input" name="name"  value="' . $purchase_request_statu_details->name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function purchase_request_status_delete(Request $request)
    {
        $purchase_request_status = PurchaseRequestStatus::find($request->purchase_request_status_id);

        if(!$purchase_request_status){

            return response()->json([
                'status' => false,
                'message' => 'Purchase Request Statu not found'
            ]);
        }

        $purchase_request_status->deleted = 1;

        $purchase_request_status->updated_by = Auth::id();

        $purchase_request_status->save();

        return response()->json([

            'status' => true,

            'message' => 'Purchase Request Statu deleted successfully'
        ]);
    }

}
