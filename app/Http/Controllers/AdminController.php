<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

use App\Models\User;

class AdminController extends Controller
{
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notifications = [
            "message" => "You have logged out successfully",
            "alert-type" => "success"
        ];

        return redirect('/login')->with($notifications);
    }

    /**
     * Profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profile(Request $request)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        $id = Auth::user()->id;

        $adminData = User::find($id);

        return view('admin.admin_profile_view', compact('adminData'));
    }

    /**
     * Edit Profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editProfile(Request $request)
    {
        $id = Auth::user()->id;

        $editData = User::find($id);

        return view('admin.admin_profile_edit', compact('editData'));
    }

    /**
     * Save Profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProfile(Request $request) : RedirectResponse
    {
        $id = Auth::user()->id;

        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')){
            $file = $request->file('profile_image');
            $filename = date("YmdHi") . $file->getClientOriginalName();
            $file->move(public_path("upload/admin_images"), $filename);

            $data->profile_image = $filename;
        }

        $data->save();

        $notifications = [
            "message" => "Admin Profile Updated Successfully",
            "alert-type" => "success"
        ];

        return redirect()->route("admin.profile")->with($notifications);
    }


    /**
     * Display Update Password page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function updatePassword()
    {
        return view("admin.admin_update_password");
    }

    /**
     * Save Profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePassword(Request $request) : RedirectResponse
    {

        $validateData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);

        $hashedPassword = Auth::user()->password;

        if (Hash::check($request->old_password, $hashedPassword)){
            $user = User::find(Auth::id());
            $user->password = bcrypt($request->new_password);
            $user->save();

            session()->flash("message", "Password Updated Successfully");
            return redirect()->back();
        }
        else {
            session()->flash("message", "Old password is not correct");
            return redirect()->back();
        }
    }
}
