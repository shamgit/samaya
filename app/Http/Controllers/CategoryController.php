<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    
    public function category(Request $request)
    {

        $categorys = Category::where('deleted', 0)->get();

        return view('Category.category',compact('categorys'));
    }


    public function category_list_table(Request $request)
    {
        $query = Category::where('category.deleted', 0)

            ->leftJoin('users as created_user', 'created_user.id', '=', 'category.created_by')

            ->leftJoin('users as updated_user', 'updated_user.id', '=', 'category.updated_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('category.category_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter Role
        if (!empty($request->category_id)) {

            $query->where('category.category_id', $request->category_id);
        }

        // Sorting
        if ($request->sort == 'category_name') {

            $query->orderBy('category.category_name', 'ASC');

        } elseif ($request->sort == 'sno') {

            $query->orderBy('category.category_id', 'ASC');

        } else {

            $query->latest('category.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'category.category_id',
                'category.category_name',
                'created_user.name as created_by',
                'category.created_at',
                'updated_user.name as updated_by',
                'category.updated_at'

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



    public function category_store (Request $request){

        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('category')->with('toast_error', 'Category not found.');
        }

        $category = new Category(); 

        $category->category_name = $request->category_name;
        $category->created_by = Auth::user()->id;

        $category->save();

        // dd($category);

        return redirect()->route('category')->with('toast_success', 'Category added successfully!');


    }



     public function category_updated(Request $request)
    {
       
        // dd($request->all());

        // Validate the request data
         $validator = Validator::make($request->all(), [
            'category_name' => 'required',

        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->route('category')->with('toast_error', 'Category not found.');
        }

        $category = Category::find($request->category_id);

        $category_details = Category::where('category_id',$request->category_id)->first();


        // Update project fields
        $category->category_name = $request->category_name;
        $category->updated_by = Auth::user()->id;

        $category->save();

        return redirect()->route('category')->with('toast_success', 'Category updated successfully!');
    }


     public function category_edit(Request $request)
    {

        
        $category_details = Category::where('category_id',$request->category_id)->where('deleted', 0)->first();

        // dd($category_details);

       $model ='<div class="modal-body">
            <input type="hidden" name="category_id" value="'. $category_details->category_id .'">
            <div class="section-block p-2"> 
              <div class="form-group">
                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" name="category_name"  value="' . $category_details->category_name .'"  required>
                </div>
            

            <div class="text-end">
                <button class="btn-save">Update</button>
            </div>
             </div>';
        echo $model;
    }

        public function category_delete(Request $request)
    {
        $category = Category::find($request->category_id);

        if(!$category){

            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        $category->deleted = 1;

        $category->updated_by = Auth::id();

        $category->save();

        return response()->json([

            'status' => true,

            'message' => 'Category deleted successfully'
        ]);
    }

}
