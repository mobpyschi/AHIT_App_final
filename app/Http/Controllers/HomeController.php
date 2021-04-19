<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Department;
use App\Models\UserDetail;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->getRoleNames()[0] != 'Admin') {
            $getUser = DB::table('users')->where('id', Auth::user()->id)->get();
            
            
            foreach ($getUser as $key => $value) {
                $id = $value->id;
            }
            $checkTask = DB::table('tasks')
                        ->join('statuses','tasks.status_id','=','statuses.id')
                        ->where('status_id',2)
                        ->where('assign', $id)
                        ->select('tasks.*','statuses.name AS namestatus')
                        ->get();
            $taskDone = DB::table('tasks')
                        ->join('statuses','tasks.status_id','=','statuses.id')
                        ->where('status_id',5)
                        ->where('assign',Auth::user()->id)
                        ->select('tasks.*','statuses.name AS namestatus')
                        ->paginate(5);
            $taskDue = DB::table('tasks')
                        ->join('statuses','tasks.status_id','=','statuses.id')
                        ->where('status_id',4)
                        ->where('assign',Auth::user()->id)
                        ->select('tasks.*','statuses.name AS namestatus')
                        ->paginate(5);
            $checklog = Auth::user()->history()->latest()->paginate(5);
            $configs = Configuration::first();
            $projectUsers = DB::table('project_users')->where('user_id', $id)->get();
            foreach ($projectUsers as $key => $value) {
                $idPorjects = $value->project_id;
            }
            // $projects = DB::table('projects')->where('id', $idPorjects)->get();
            $projects = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->join('project_users','projects.id','=','project_users.project_id')
                                    ->where('project_users.user_id', Auth::user()->id)
                                    ->select('projects.*' ,'users.name AS nameassign')
                                    ->get();

            $users = User::where('id',$id)->first();
            $detailUsers = UserDetail::where('user_id', Auth::user()->id)->first();
            
            // $countWorkday = $users->workday;
            $countDepartment = Department::pluck('name')->count();
            $countRole = Role::pluck('name')->count();
            $countUserNames = User::pluck('name')->count() - 1;
            $countProjectNames = ProjectUser::where('user_id',Auth::user()->id)->pluck('name')->count();
            // $countProjectUnfinished = Project::all('status')
            // ->where('status', '!=', 'InProgress')
            // ->Where('status', '!=', 'Done')->count();
            $countProjectUnfinished = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->join('project_users','projects.id','=','project_users.project_id')
                                    ->where('project_users.user_id', Auth::user()->id)
                                    ->where('projects.status','!=', 'InProgress')
                                    ->where('projects.status','!=', 'Done')
                                    ->count();
            $countProjectProgress = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->join('project_users','projects.id','=','project_users.project_id')
                                    ->where('project_users.user_id', Auth::user()->id)
                                    ->where('projects.status','=', 'InProgress')
                                    ->count();
            $countProjectDone = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->join('project_users','projects.id','=','project_users.project_id')
                                    ->where('project_users.user_id', Auth::user()->id)
                                    ->where('projects.status','=', 'Done')
                                    ->count();

            // dd($countProjectUnfinished);
            //$countUserName = (User::pluck('name','name')->count()) - 1;//trừ user admin
            return view('home', compact('countRole', 'checkTask', 'countDepartment', 'checklog', 'configs', 'projects', 'users', 'countUserNames',
             'countProjectNames', 'countProjectUnfinished', 'countProjectProgress', 'countProjectDone','detailUsers','taskDone','taskDue'));

        
        } 
        elseif (Auth::user()->getRoleNames()[0] == 'Manager' || Auth::user()->getRoleNames()[0] == 'Leader') {
            $getUser = DB::table('users')->where('id', Auth::user()->id)->get();
            foreach ($getUser as $key => $value) {
                $id = $value->id;
            }
            $getFormatDate = Configuration::all();
            foreach ($getFormatDate as $key => $value) {
                $formatDates = $value->formatDate;
            }
            $checkTask = DB::table('tasks')
                        ->join('statuses','tasks.status_id','=','statuses.id')
                        ->select('tasks.*','statuses.name AS namestatus')
                        ->get();
            $taskDone = DB::table('tasks')
            ->where('status_id',2)
            ->paginate(5);
            $taskDue = DB::table('tasks')
            ->where('status_id',4)
            ->paginate(5);
            $checklog = Auth::user()->history()->latest()->paginate(5);
            $configs = Configuration::first();
            $projectUsers = DB::table('project_users')->where('user_id', $id)->get();
            foreach ($projectUsers as $key => $value) {
                $idPorjects = $value->project_id;
            }
            // $projects = DB::table('projects')->where('id', $idPorjects)->get();
            $projects = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->select('projects.*' ,'users.name AS nameassign')
                                    ->get();
            $users = User::where('id',$id)->first();
            $detailUsers = UserDetail::where('user_id', Auth::user()->id)->first();
            
            // $countWorkday = $users->workday;
            $countDepartment = Department::pluck('name')->count();
            $countRole = Role::pluck('name')->count();
            $countUserNames = User::pluck('name')->count() - 1;
            $countProjectNames = Project::pluck('name')->count();
            $countProjectUnfinished = DB::table('projects')
            ->join('users', 'projects.assign' , '=' , 'users.id' )
            ->join('project_users','projects.id','=','project_users.project_id')
            ->where('project_users.user_id', Auth::user()->id)
            ->where('projects.status','!=', 'InProgress')
            ->where('projects.status','!=', 'Done')
            ->count();
            
            $countProjectProgress = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->join('project_users','projects.id','=','project_users.project_id')
                                    // ->where('project_users.user_id', Auth::user()->id)
                                    ->where('projects.status','=', 'InProgress')
                                    ->where('projects.assign','=', Auth::user()->id)
                                    ->count();
            $countProjectDone = Project::all('status')
            ->where('assign',$id)
            ->where('status', '=', 'Done')->count();
            dd($countProjectUnfinished);
            //$countUserName = (User::pluck('name','name')->count()) - 1;//trừ user admin
            return view('home', compact('countRole', 'checkTask', 'countDepartment', 'checklog', 'configs', 'projects', 'users', 'countUserNames',
             'countProjectNames', 'countProjectUnfinished', 'countProjectProgress', 'countProjectDone','detailUsers','taskDone','taskDue','formatDates'));

        
        }
        else {
            $checklog = Auth::user()->history()->latest()->paginate(5);
            $getFormatDate = Configuration::all();
            foreach ($getFormatDate as $key => $value) {
                $formatDates = $value->formatDate;
            }
            $checkTask = DB::table('tasks')->get();
            $configs = Configuration::first();
            $projects = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->select('projects.*' ,'users.name AS nameassign')
                                    ->get();
            $taskDone = DB::table('tasks')
                                    ->join('projects', 'tasks.project_id' , '=' , 'projects.id' )
                                    ->join('statuses','tasks.status_id','=','statuses.id')
                                    ->join('users','tasks.assign','=','users.id')
                                    ->where('tasks.status_id',5)
                                    ->select('tasks.*','projects.name as nameProject','statuses.name as status','users.name as nameuser')
                                    ->paginate(5);
        
            $taskDue = DB::table('tasks')
            ->where('status_id',4)
            ->paginate(5);
            $users = User::All();
            $detailUsers = UserDetail::where('user_id', Auth::user()->id)->get();
            $countDepartment = Department::pluck('name')->count();
            $countRole = Role::pluck('name')->count();
            $countUserNames = User::pluck('name')->count() - 1;
            $countProjectNames = Project::pluck('name')->count();
            $countProjectUnfinished = Project::all('status')
            ->where('status', '!=', 'InProgress')
            ->Where('status', '!=', 'Done')->count();
            $countProjectProgress = Project::all('status')->where('status', '=', 'InProgress')->count();
            $countProjectDone = Project::all('status')->where('status', '=', 'Done')->count();

            //$countUserName = (User::pluck('name','name')->count()) - 1;//trừ user admin
            return view('home', compact('countRole', 'checkTask', 'countDepartment', 'checklog', 'configs', 'projects', 'users', 'countUserNames',
             'countProjectNames', 'countProjectUnfinished', 'countProjectProgress', 'countProjectDone','detailUsers','taskDone','taskDue','formatDates'));
        }

    }

}