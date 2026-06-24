<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;


class UnitOfMeasureController extends Controller
{
    
    public function unit_of_measure(Request $request)
    {

        $units = Unit::where('deleted', 0)->get();

        return view('Units.unit_of_measure',compact('units'));
    }


    public function unit_list_table(Request $request)
    {
        $query = Unit::where('unit_of_measure.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'unit_of_measure.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'unit_of_measure.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('unit_of_measure.name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->unit_id)) {

            $query->where('unit_of_measure.unit_id', $request->unit_id);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('unit_of_measure.name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('unit_of_measure.unit_id', 'ASC');

        } else {

            $query->latest('unit_of_measure.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'unit_of_measure.unit_id',
                'unit_of_measure.name',
                'created_user.name as created_by',
                'unit_of_measure.created_at',
                'updated_user.name as updated_by',
                'unit_of_measure.updated_at'

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



    public function unit_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('unit_of_measure')->with('toast_error', 'Unit of Measure not found.');
        }

        $unit = new Unit(); 

        // Assign other fields
        $unit->name = $request->name;
        $unit->created_by = Auth::user()->id;

        $unit->save();

        // dd($unit);

        return redirect()->route('unit_of_measure')->with('toast_success', ' Unit of Measure added successfully!');


    }



     public function unit_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('unit_of_measure')->with('toast_error', ' Unit of Measure not found.');
        }

        $unit = Unit::find($request->unit_id);

        $unit_details = Unit::where('unit_id',$request->unit_id)->first();


       
        $unit->name = $request->name;
        $unit->updated_by = Auth::user()->id;

        $unit->save();

        return redirect()->route('unit_of_measure')->with('toast_success', 'Unit of Measure updated successfully!');
    }


     public function unit_edit(Request $request)
    {

        
        $unit_details = Unit::where('unit_id',$request->unit_id)->where('deleted', 0)->first();

        // dd($unit_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="unit_id" value="'. $unit_details->unit_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label"> Unit of Measure Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" name="name"  value="' . $unit_details->name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function unit_delete(Request $request)
    {
        $unit = Unit::find($request->unit_id);

        if(!$unit){

            return response()->json([
                'status' => false,
                'message' => 'Unit of Measure not found'
            ]);
        }

        $unit->deleted = 1;

        $unit->updated_by = Auth::id();

        $unit->save();

        return response()->json([

            'status' => true,

            'message' => 'Unit of Measure deleted successfully'
        ]);
    }

}
