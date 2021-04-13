<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Department;
use App\Models\Project;
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
                        ->where('assign', $id)
                        ->select('tasks.*','statuses.name AS namestatus')
                        ->get();

            $checklog = Auth::user()->history()->latest()->paginate(5);
            $configs = Configuration::first();
            $projectUsers = DB::table('project_users')->where('user_id', $id)->get();
            foreach ($projectUsers as $key => $value) {
                $idPorjects = $value->project_id;
            }
            // $projects = DB::table('projects')->where('id', $idPorjects)->get();
            $projects = DB::table('projects')
                                    ->join('users', 'projects.assign' , '=' , 'users.id' )
                                    ->select('projects.*' , 'users.name AS nameassign')
                                    ->get();
            $projectsTest = Project::join('users', 'projects.assign' , '=' , 'users.id')
                                    ->select('projects.*','users.name as test')
                                    ->with('tasks')
                                    ->get();
            $users = User::All();
            $countDepartment = Department::pluck('name')->count();
            $countRole = Role::pluck('name')->count();
            $countUserNames = User::pluck('name')->count() - 1;
            $countProjectNames = Project::pluck('name')->count();
            $countProjectUnfinished = Project::all('status')->where('status', '=', 'unfinished')->count();
            $countProjectProgress = Project::all('status')->where('status', '=', 'progress')->count();
            $countProjectDone = Project::all('status')->where('status', '=', 'done')->count();

            //$countUserName = (User::pluck('name','name')->count()) - 1;//trừ user admin
            return view('home', compact('countRole', 'checkTask', 'countDepartment', 'checklog', 'configs', 'projects', 'users', 'countUserNames', 'countProjectNames', 'countProjectUnfinished', 'countProjectProgress', 'countProjectDone'));
        } else {
            $checklog = Auth::user()->history()->latest()->paginate(5);

            $checkTask = DB::table('tasks')->get();
            $configs = Configuration::first();
            $projects = Project::all();
            $users = User::All();
            $countDepartment = Department::pluck('name')->count();
            $countRole = Role::pluck('name')->count();
            $countUserNames = User::pluck('name')->count() - 1;
            $countProjectNames = Project::pluck('name')->count();
            $countProjectUnfinished = Project::all('status')->where('status', '=', 'unfinished')->count();
            $countProjectProgress = Project::all('status')->where('status', '=', 'progress')->count();
            $countProjectDone = Project::all('status')->where('status', '=', 'done')->count();

            //$countUserName = (User::pluck('name','name')->count()) - 1;//trừ user admin
            return view('home', compact('countRole', 'checkTask', 'countDepartment', 'checklog', 'configs', 'projects', 'users', 'countUserNames', 'countProjectNames', 'countProjectUnfinished', 'countProjectProgress', 'countProjectDone'));
        }

    }

}
