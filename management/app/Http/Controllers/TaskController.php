<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DateTime;
use Illuminate\Support\Facades\DateInterval;
use Illuminate\Support\Facades\DatePeriod;

use Carbon\Carbon;
use App\Models\Task;
use GuzzleHttp\Psr7\Message;

use function GuzzleHttp\Promise\task;

class TaskController extends Controller
{
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
                    $user = User::where('is_admin', '=', 0)->get();
                    return view('admin', compact('user', 'admin'));
                } else {
                    return redirect()->route('task');
                }

            } else {
                return redirect()->back()->withErrors(['message' => 'incorrect password']);
            }

        }
    }
    // -----------------------------------Admin----------------------------------------------
    public function showAll()
    {
        $admin = new Task();
        $admin = Task::orderBy('done_at', 'asc')->get();
        $user = User::where('is_admin', '=', 0)->get();
        return view('admin', compact('admin', 'user'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'task' => 'required',
            'done_at' => 'required',
        ]);

        $admin = new Task();
        $admin->user_id = $request->staff_id;
        $admin->staff_id = $request->staff_id;
        $admin->task = $request->get('task');
        $admin->done_at = Carbon::parse($request->get('done_at'))->format('Y-m-d\TH:i');
        $admin->save();
        $admin = Task::orderBy('done_at', 'asc')->get();
        $user = User::where('is_admin', '=', 0)->get();

        return view('admin', compact('admin', 'user'));

    }

    public function adminDel($id)
    {
        $admin = Task::find($id);
        $admin->delete();
        $admin = Task::orderBy('done_at', 'asc')->get();
        $user = User::where('is_admin', '=', 0)->get();
        return view('admin', compact('admin', 'user'));

    }


    public function adminEdit($id)
    {
        $admin = Task::find($id);
        $user = User::where('is_admin', '=', 0)->get();
        return view('adminshow', compact('admin', 'user'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $admin = Task::find($id);
        $admin->task = $request->get('task');
        $admin->done_at = $request->get('done_at');
        $admin->update();
        $admin = Task::orderBy('done_at', 'asc')->get();
        return redirect()->route('showall')->with('message', 'Task is updated');
    }

    public function status(Request $request, $id)
    {
        $admin = Task::find($id);
        if ($admin->status == 1)
        {
            Db::table('tasks')->where('id', $id)->update(['status' => 0]);
        }
        elseif($admin->status == 0)
        {
            DB::table('tasks')->where('id', $id)->update(['status' => 1]);
        } else {
            echo 'Not Completed!';
        }

        $admin->status = $request->get('status');
        $admin->update();
        return redirect()->back()->with('message', 'Status changed!');





    }


    // --------------------------------Task Management ------------------------------------------------------

    public function task()
    {
        $task = new Task();
        $task = Task::all();
        $user_id = Auth::user()->id;
        $task = Task::orderBy('done_at', 'asc')->where('staff_id', '=', $user_id)->get();

        return view('dashboard', compact('task'));


    }
    public function taskStore(Request $request)
    {
        $request->validate([
            'task' => 'required',
            'done_at' => 'required',
        ]);

        $task = new Task();
        $user_id = Auth::user()->id;
        $task->user_id = $user_id;
        $task->staff_id = $request->staff_id;
        $task->task = $request->get('task');
        $task->done_at = Carbon::parse($request->get('done_at'))->format('Y-m-d\TH:i');
        $task->save();
        $task = Task::get();
        $task = Task::orderBy('done_at', 'asc')->where('staff_id', '=', $user_id)->get();
        // return redirect()->back()->with('message','Task is save','task');
        return view('dashboard', compact('task'));

    }


    public function delete($id)
    {
        $user_id = Auth::user()->id;
        $task = Task::find($id);
        $task->delete();
        $task = Task::all();
        $task = Task::where('staff_id', '=', $user_id)->paginate(4);
        // return redirect()->back()->with('message','Task is deleted');
        return view('dashboard', compact('task'));

    }
    public function edit($id)
    {
        $task = Task::find($id);
        return view('show', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->task = $request->get('task');
        $task->done_at = $request->get('done_at');
        $task->update();
        $task = Task::all();
        return redirect()->route('task')->with('message', 'Task is updated');
    }






































    public function date()
    {
        $task = Task::all();

        User::select(DB::raw("(COUNT(*)) as count"), DB::raw("DAYNAME(done_at) as done_at"))
            ->whereBetween('done_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->whereYear('done_at', date('Y'))
            ->groupBy('task')
            ->get();
        return redirect()->back()->with('task', $task);

        // --

        //     Task::select('task','done_at',DB::raw("DAYNAME(done_at) as dayname"))

        //     ->whereBetween('done_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        //    ->whereYear('done_at', date('Y'))
        //    ->groupBy('dayname','task','done_at')
        //    ->get(['task','done_at','dayname']);

        // for($i = 1; $i < 7; $i++) {
        //     $day[] = Carbon::now()->subDays($i)->format('l');
        // }
        // $name=json_encode($day);
        // echo $name;

        // select ID, Date from table where Date < DATE_ADD(CURDATE(), INTERVAL 7 DAY)
    }
}