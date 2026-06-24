<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Roles;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


      public function my_profile(Request $request,$id)
    {
        $id = base64_decode($id);
        $user_details = User::where('users.id', $id)->where('users.deleted', 0)->leftJoin('roles', 'roles.role_id', '=', 'users.role_id')->select('users.*', 'roles.role_name')->first();
        $roles = Roles::where('deleted', 0)->get();

        return view('my_profile', compact('roles','user_details'));
    }


    public function change_password(Request $request){

        $user = Auth::user();
        $user_details = User::where('id', $user->id)->where('deleted', 0)->first();

	  return view('change_password',compact('user_details'));
    
	}



    public function update_password(Request $request)
    {
        $request->validate([
            'old_password'     => 'required',
            'new_password'     => 'required|string|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = Auth::user();

        // Check old password
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        // Prevent using the same password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('error', 'New password must be different from the old password.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
            'plain_password' => $request->new_password,
        ]);

        // Logout user after password change
        Auth::logout();

        return redirect()->route('login')->with('toast_success', 'Password updated successfully. Please login again.');
    }
}
