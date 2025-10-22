<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\Websitemail;
use App\Models\Activity;
use Illuminate\Support\Facades\Mail;
use App\Models\users;

class AdminController extends Controller
{
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'Your Logout  Successfully',
            'alert-type' => 'info'
        );

        return redirect('/')->with($notification);
    }
    //end method

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }
    //end method


    public function AdminForgetPassword()
    {
        return view('admin.forget_password');
    }

    public function AdminPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user_data = User::where('email', $request->email)->first();
        if (!$user_data) {
            return redirect()->back()->with('error', 'Email Not Found');
        }
        $token = hash('sha256', time());
        $user_data->token = $token;
        $user_data->update();

        $reset_link = url('admin/reset-password/' . $token . '/' . $request->email);
        $subject = "Reset Password";
        $message = "Please Clink on below link to reset password<br>";
        $message .= "<a href='" . $reset_link . " '> Click Here </a>";

        \Mail::to($request->email)->send(new Websitemail($subject, $message));
        return redirect()->back()->with('success', 'Reset Password Link Send On Your Email');
    }
    // End Method 

    // public function AdminPasswordSubmit(Request $request) {

    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $user_data = User::where('email', $request->email)->first();

    //     if(!$user_data) {

    //         return redirect()->back()->with('error' , 'Email Not Found');

    //     }

    //     $token = Hash::make('jan268' . time());

    //     $user_data->token = $token;
    //     $user_data->update();

    //     $reset_link = url('admin/reset-password/'.$token.'/'.urlencode($request->email));

    // $subject = "Reset Password";
    // $message = "Please click on the link to reset your password <br>";
    // $message .= '<a href="'.$reset_link.'">Click Here</a>';
    //     // $message = "Click on the link to reset your password: <a href='".$reset_link."'>Click Here</a>";

    //     Mail::to($request->email)->send(new Websitemail($subject , $message));

    //     return redirect()->back()->with('success' , 'We have e-mailed your password reset link!');
    // }

    public function AdminResetPassword($token, $email)
    {
        $user_data = User::where('email', urldecode($email))->where('token', $token)->first();

        if (!$user_data) {

            return redirect()->route('login')->with('error', 'Invalid Link');
        } else {

            return view('admin.reset_password', compact('email', 'token'));
        }
    }

    public function AdminResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $user_data = User::where('email', $request->email)->where('token', $request->token)->first();
        $user_data->password = Hash::make($request->password);
        $user_data->token = "";
        $user_data->update();

        return redirect()->route('login')->with('success', 'Password Reset Successfully');
    }
    // End Method 

   public function ProfileStore(Request $request)
{
    $id = Auth::user()->id;
    $data = User::find($id);

    $data->name = $request->name;
    $data->email = $request->email;
    $data->phone = $request->phone;
    $data->address = $request->address;

    $oldPhotoPath = $data->photo;

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/user_images'), $filename);
        $data->photo = $filename;

        if ($oldPhotoPath && $oldPhotoPath !== $filename) {
            $this->deleteOldImage($oldPhotoPath);
        }
    }

    // ✅ Save Profile First
    $data->save();

    // 📝 Now Log Activity AFTER Saving
    Activity::create([
        'user_id'  => auth()->id(),
        'action'   => 'Updated',
        'model'    => 'Profile',
        'model_id' => $data->id,
    ]);

    $notification = [
        'message' => 'Profile Updated Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}


    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/user_images/' . $oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
    // End private Method

    public function AdminPasswordUpdate(Request $request)
    {

        $user = Auth::user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, $user->password)) {

            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        User::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);


        Activity::create([
            'user_id' => $user->id,
            'action'  => 'Updated',
            'model'   => 'Password',
            'model_id' => $user->id,
        ]);


        Auth::logout();

        $notification = array(
            'message' => 'Password Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('login')->with($notification);
    }
    // End Method

}
