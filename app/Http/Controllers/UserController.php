<?php

namespace App\Http\Controllers;

use App\Mail\CreateUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryChecks;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $histories = User::find(2);
        // dd(($histories));
        //Hien Thi
        $department = Department::all();
        // $data = User::orderBy('id','DESC')->paginate(5);
        $data = User::getBYDepartment(auth()->user()->department_id);
        $allUsers = User::latest()->paginate(6);
        // dd($allUser);
        return view('users.index',compact('data','department','allUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::pluck('name','name')->all();
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles', 'department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'department' => 'required',
            'roles' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        if($input['department'][0]==null){
            dd('oke');
        };
        $department_name = $input['department'][0];
        $role_name = $input['roles'][0];
        $department_id = Department::where('name', $department_name)->first()->id;
        $input['department_id'] = $department_id;
        unset($input['department']);
        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->department_id = $input['department_id'];
        $user->assignRole($request->input('roles'));
        if($user->save()){
            // Mail::to($request->email)->send(new CreateUserMail($request));
            $detailUser = new UserDetail;
            $detailUser->Name = $input['name'];
            $detailUser->Email = $input['email'];
            $detailUser->Department = $department_name;
            $detailUser->Role = $role_name;

            $detailUser->Work_start = now();
            $userId = User::all()->max('id');
            $detailUser->user_id = $userId;
            $detailUser->save();
            return redirect()->route('users.index')
                        ->with('success','User created successfully and send email success');
        }
        return redirect()->back()->withErrors($validator)->withInput();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $detailUser = UserDetail::where('user_id',$id)->get();
        $histories = $user->history()->paginate(10);
        // $luong = $user->history()->where('created_at',date('Y:m:d H:i:s',strtotime('2021-02-01 10:52:28')))->get();
        // dd($luong,date('d:m:Y',strtotime('01:02:2021')));
        return view('users.show',compact('user','histories','detailUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $getDepartment = Department::where('id',$user->department_id)->first();
        $department = Department::pluck('name','name');
        $departmentName = [$getDepartment->name => $getDepartment->name ];
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole','department','departmentName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        //cap nhat du lieu
        $user = User::find($id);
        $department_name = $input['department'][0];
        $department_id = Department::where('name', $department_name)->first()->id;
        $input['department_id'] = $department_id;
        unset($input['department']);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->department_id = $input['department_id'];



        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        if($user->save()){
            return redirect()->route('users.index')
                        ->with('success','User updated successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    /**
     * Auth : Trung Truc
     *
     * History log
     *
     */
    public function logUser($id)
    {
        $user = User::find($id);
        $userDetail = $user->detailUser()->first();
        // dd($userDetail );
        $histories = $user->history()->paginate(10);
        return view('users.log',compact('user', 'histories','userDetail'))->with('totalWork',0); //compact('user','histories')
    }

    /**
     * Auth : Trung Truc
     * sort date the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storelog(Request $request, $id)
    {
        $this->validate($request, [
            'date_start' => 'required',
            'date_end' => 'required',

        ]);
            // dd($request);
        $input = $request->all();
        $date_start = $input['date_start'];
        $date_end = $input['date_end'];

        $fromDate = $input['date_start'];
        $toDate   = $input['date_end'];
        $user = User::find($id);
        $userDetail = $user->detailUser()->first();
        $histories = HistoryChecks::whereRaw(
        "(created_at >= ? AND created_at <= ? AND model_id = ?)",
        [$fromDate." 00:00:00", $toDate." 23:59:59", $id]
        )->paginate(10);

        return view('users.log',compact('user','histories','userDetail'))->with('totalWork',0);
    }
}
