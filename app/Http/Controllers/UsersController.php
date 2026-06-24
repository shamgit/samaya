<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{


    public function users(Request $request)
    {
        $roles = Roles::where('role_id', '!=', 3)->where('role_id', '!=', 4)->where('deleted', 0)->get();

        return view('Users.users', compact('roles'));
    }

    public function user_add(Request $request)
    {
        $roles = Roles::where('role_id', '!=', 3)->where('role_id', '!=', 4)->where('deleted', 0)->get();

        return view('Users.user_add', compact('roles'));
    }

     public function user_edit(Request $request,$id)
    {
        $id = base64_decode($id);
        $user_details = User::where('id',$id)->where('deleted', 0)->first();
        $roles = Roles::where('role_id', '!=', 3)->where('role_id', '!=', 4)->where('deleted', 0)->get();

        return view('Users.user_edit', compact('roles','user_details'));
    }

     public function user_view(Request $request,$id)
    {
        $id = base64_decode($id);
        $user_details = User::where('users.id', $id)->where('users.deleted', 0)->leftJoin('roles', 'roles.role_id', '=', 'users.role_id')->select('users.*', 'roles.role_name')->first();
        $roles = Roles::where('deleted', 0)->get();

        return view('Users.user_view', compact('roles','user_details'));
    }


 
    public function users_store(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users,email',

            'phone' => 'required|digits:10',

            'password' => 'required|min:8',

            'role_id' => 'required',

            'status' => 'required',

            'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User();

        $user->name = $request->name;

        $user->email = $request->email;

        $user->phone = $request->phone;

        $user->plain_password = $request->password;

        $user->password = Hash::make($request->password);

        $user->role_id = $request->role_id;

        $user->status = $request->status;

        $user->created_by = Auth::id();

        // Upload Profile
        if($request->hasFile('profile')){

            $file = $request->file('profile');

            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('assets/profile'), $filename);

            $user->profile = $filename;
        }

        $user->save();

        return redirect()->route('users')->with('toast_success', 'User added successfully!');
    }
    

    public function users_list_table(Request $request)
    {
        $query = User::where('users.deleted', 0)->where('users.role_id', '!=', 4)

            ->leftJoin('roles', 'roles.role_id', '=', 'users.role_id')

            ->leftJoin('users as created_user', 'created_user.id', '=', 'users.created_by');

        // Search
        if (!empty($request->search['value'])) {

            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {

                $q->where('users.name', 'LIKE', "%{$search}%")

                ->orWhere('users.email', 'LIKE', "%{$search}%")

                ->orWhere('roles.role_name', 'LIKE', "%{$search}%");
            });
        }

        // Role Filter
        if (!empty($request->role_id)) {

            $query->where('users.role_id', $request->role_id);
        }

         if (!empty($request->status)) {

            $query->where('users.status', $request->status);
        }

        // Sorting
        if ($request->sort == 'name') {

            $query->orderBy('users.name', 'ASC');

        } else {

            $query->latest('users.created_at');
        }

        $totalRecords = $query->count();

        $data = $query->select(

                'users.id',

                'users.name',

                'users.email',

                'users.phone',

                'users.status',

                'roles.role_name',

                'created_user.name as created_by',

                'users.created_at'

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


    public function users_update(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users,email,' . $request->id,

            'role_id' => 'required',
        ]);

        $user = User::findOrFail($request->id);

        $user->name = $request->name;

        $user->email = $request->email;

        $user->phone = $request->phone;

        $user->role_id = $request->role_id;

        $user->status = $request->status;

        // Password Update
        if($request->password){

            $user->plain_password = $request->password;

            $user->password = Hash::make($request->password);
        }

        // Profile Upload
        if($request->hasFile('profile')){

            $file = $request->file('profile');

            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('assets/profile'), $filename);

            $user->profile = $filename;
        }

        $user->updated_by = Auth::id();

        $user->save();

        return redirect()
            ->route('users')
            ->with('toast_success', 'User updated successfully!');
    }


    public function users_delete(Request $request)
    {
        $user = User::find($request->user_id);

        if(!$user){

            return response()->json([

                'status' => false,

                'message' => 'User not found'
            ]);
        }

        $user->deleted = 1;

        $user->updated_by = Auth::id();

        $user->save();

        return response()->json([

            'status' => true,

            'message' => 'User deleted successfully'
        ]);
    }
}