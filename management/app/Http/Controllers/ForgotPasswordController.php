<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
       return view('forgot.forgot');
    }
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
            // dd($request);
        $token = Str::random(64);

        DB::table('forgots')->update([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        Mail::send('forgot.linkmail', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    // 
    public function showResetPasswordForm($token) { 
        return view('forgot.resetpass', ['token' => $token]);
     }
    //  
    public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('users')
                              ->where([
                                'email' => $request->email, 
                                // 'token' => $request->token
                              ])  
                              ->first();
  
          if(!$updatePassword){
            //   return back()->withInput()->with('error', 'Invalid token!');
              return redirect()->back()->with("error",'Invalid token!');
          }
  
          $auth = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('forgots')->where(['email'=> $request->email])->delete();
  
          return view('sign-in')->with('message', 'Your password has been changed!');
      }
}
