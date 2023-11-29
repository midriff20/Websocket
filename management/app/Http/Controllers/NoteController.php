<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return view('login');

    }
    public function LoginForm(Request $request)
    {
        
    }
    public function index()
    {
        return view('sign-up');
    }


    public function store(Request $request)
    {
        $messages = [
            "name.required" => "Name is required",
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "email.unique" => "Email already exists",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 8 characters",

        ];


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',


        ], $messages);
        if ($validator->fails()) {
            return redirect('sign-up')->withErrors($validator->messages())->withInput();
        } else {

            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->save();
            return redirect()->route('user.login');
        }
    }
    // --------------Login-----------------------
    public function login()
    {
        return view('sign-in');
    }
    public function loginForm(Request $request)
    {


        $messages = [
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "email.exists" => "User already exists !",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 8 characters"
        ];


        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ], $messages);
        // If(Auth:: user()) 
        // {
        //   If(Auth::user()->email === $request->email)
        // {
        // return redirect()->back()->withErrors(['message'=>'User already login'])->withInput();
        // }
        // }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages())->withInput();
        } else {
            $user = $request->all();


            if ($user = $request->remember_token === null) {

                setcookie('email', $request->email, 100);
                setcookie('password', $request->password, 100);
            } else {
                setcookie('email', $request->email, time() + 60 * 60 * 24 * 100);
                setcookie('password', $request->password, time() + 60 * 60 * 24 * 100);
            }

            $user_data = array(
                'email' => $request->get('email'),
                'password' => $request->get('password')
            );

            if (Auth::attempt($user_data)) {
                if ($user = auth()->user()->is_admin > 0) {
                    $user = User::all();
                    $admin = Task::all();
                  
                    return view('admin', compact('user', 'admin'));
                } else {
                    return redirect()->route('task');
                }

            } else {
                return redirect()->back()->withErrors(['message' => 'incorrect password']);
            }

        }
    }

}
