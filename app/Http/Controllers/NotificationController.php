<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use App\Notifications\MakeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if((Auth::user()->getRoleNames())[0] == 'Admin'){
            $alluser = User::all();
            $allnotifications = null;
            foreach($alluser as $item){
                foreach ($item->notifications as $notification) {
                    $allnotifications[] = [$notification,$item->name];
                    // $counttitle[] = $notification->data['title'];
                }
            }
            return view('notifications.index', compact('allnotifications'));
        }

        /**
         *
         *  xu ly dieu kien lay notiification cua department
         *  chua xai den
         *  sua 'manager vs 'leader' to 'Manager' vs 'Leader' de xai`
         *
         * */
        if((Auth::user()->getRoleNames())[0] == 'Manager' || (Auth::user()->getRoleNames())[0] == 'Leader'){
            //user->notification of department
            $users = User::where('department_id',Auth::user()->department_id)->get();
            $notificationsdepartment = null;
            foreach($users as $user){
                if($user->notifications != null){
                    foreach($user->notifications as $item){
                        $notificationsdepartment[] = $item;
                    }
                }
            }
            return view('notifications.index', compact('notificationsdepartment'));
        }
        //user->notification
        $user = User::find(Auth::user()->id);
        $usernotifications = null;
        if($user->notifications != null){
            foreach($user->notifications as $item){
                $usernotifications[] = $item;
            }
        }
        // dd(Auth::user()->unreadNotifications);
        return view('notifications.index', compact('usernotifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->getRoleNames()[0] == 'Admin'){
            $getalluser = User::all();
            $user = $getalluser->pluck('name','name');
            unset($user[Auth::user()->name]);
            $getAllDepartment = Department::where('id','!=',Auth::user()->id)->get();
            $department = $getAllDepartment->pluck('name','name');
            unset($department[Auth::user()->name]);
            return view('notifications.create',compact('user','department'));

        }else{
            $department = Department::where('id',Auth::user()->id)->pluck('name','name');
            $departmentUser = User::where('department_id', Auth::user()->department_id)->get();
            $user = $departmentUser->pluck('name','name');
            unset($user[Auth::user()->name]);
            return view('notifications.create',compact('user','department'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'content'=>'required',
            'user' => 'nullable',
            'alluser' => 'nullable',
            'department' => 'nullable',
        ]);

        $allUser = $request['alluser'];
        if($allUser === '1'){
            $data = $request->only([
                'title',
                'content'
            ]);
                $getuser = User::where('id','!=',auth()->user()->id)->get();
                foreach ($getuser as $key => $value) {
                    $value->notify(new MakeNotification($data));
                }
        }
        else{

            $data = $request->only([
                'title',
                'content'
            ]);

            if($request->user == null){
                foreach ($request->department as $item) {
                    $getDepartment = Department::where('name', $item)->get();
                    foreach ($getDepartment as $key => $value) {
                        $id = $value->id;
                        $getuser = User::where('department_id' ,$id)->get();
                        foreach ($getuser as $key => $value) {
                            $value->notify(new MakeNotification($data));
                        }
                    }

                }
            }
            else{
                if($request->department ==null && $request->user != null){
                    foreach ($request->user as $item){
                        $getUser = User::where('name',$item)->get();
                        foreach ($getUser as $key => $value) {
                            $value->notify(new MakeNotification($data));
                        }
                    }
                }
                else{
                    foreach ($request->department as $item) {
                        $getDepartment = Department::where('name', $item)->get();
                        foreach ($getDepartment as $key => $value) {
                            $id= $value->id;
                            $getuser = User::whereRaw(
                                "(department_id = ? AND id <> ?)",
                                [$id,auth()->user()->id ]
                                )->get();
                            foreach ($getuser as $key => $value) {
                                $value->notify(new MakeNotification($data));
                            }
                            foreach($request->user as $item1){

                                $getUserdifferent = User::whereRaw(
                                    "(name = ? AND department_id <> ? AND id <> ?)",
                                    [$item1,$id,auth()->user()->id ]
                                    )->get();
                                foreach ($getUserdifferent as $key => $value) {
                                    $value->notify(new MakeNotification($data));
                                    }
                            }
                        }
                    }
                }
                }

        }
        return redirect('notifications');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idnotifi)
    {
        $users = User::all();
        foreach($users as $user){
            foreach($user->notifications as $notifi){
                if($notifi->id == $idnotifi){
                    $notifi->delete();
                    return redirect('/notifications')->with('status','delete succes');
                }
            }
        }

    }

}
