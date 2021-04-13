<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use App\Notifications\MakeNotification;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:project-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('users', 'tasks')->get();
        foreach ($projects as $key => $value) {
            Project::statusProject($value);
        }
        // dd($projects);

        if (Auth::user()->department_id === 1) {
            $projects = Project::with('users', 'tasks')->get();
            $departments = Department::all();
            return view('projects.index', compact('projects', 'departments'));
        } else {
            $projects = Project::where('department_id', Auth::user()->department_id)->with('users', 'tasks')->get();
            $departments = Department::all(); //dd($projects);
            return view('projects.index', compact('projects', 'departments'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ------------TẠO DỰ ÁN---------------
    public function create()
    {
        $status = Status::pluck('name', 'name')->all();
        if (Auth()->user()->getRoleNames()[0] == 'Admin') {
            //list manager
            $getMember = Department::where('id', '!=', 1)->with('users')->get();
            foreach ($getMember as $key => $value) {

                //delete item not manager and Leader
                foreach ($value->users as $key => $item) {
                    if ($item->getRoleNames()[0] === 'Manager' || $item->getRoleNames()[0] === 'Leader') {
                        continue;
                    }
                    unset($value->users[$key]);
                }

                $users[$value->name] = $value->users->pluck('name', 'id');
            }

            //list Department
            $department = Department::pluck('name', 'id')->all();
            unset($department['1']);

            // member of all Department
            $getMember = Department::where('id', '!=', 1)->with('users')->get();
            foreach ($getMember as $key => $value) {
                // dd(count($value->users));
                //delete item not manager and Leader
                foreach ($value->users as $key => $item) {
                    if ($item->getRoleNames()[0] === 'Manager' || $item->getRoleNames()[0] === 'Leader') {
                        unset($value->users[$key]);
                        continue;
                    }
                }
                $member[$value->name] = $value->users->pluck('name', 'id');
            }
            // dd($member);

            return view('projects.create', compact('department', 'users', 'status', 'member'));
        }

        if (Auth()->user()->getRoleNames()[0] == 'Manager' || Auth()->user()->getRoleNames()[0] == 'Leader') {
            //list manager
            $users = [];
            if (Auth::user()->getRoleNames()[0] === "Manager") {
                $getusers = User::where('department_id', Auth::user()->department_id)->get();
                foreach ($getusers as $key => $item) {
                    if (($item->getRoleNames()[0] === "Manager") || ($item->getRoleNames()[0] === "Leader")) {
                        $users[$item->id] = $item->name;
                    }
                }
            }

            if (Auth::user()->getRoleNames()[0] === "Leader") {
                $getusers = User::where('department_id', Auth::user()->department_id)->get();
                foreach ($getusers as $key => $item) {
                    if (($item->getRoleNames()[0] === "Leader")) {
                        $users[$item->id] = $item->name;
                    }
                }
            }

            //list Department
            $department = Department::pluck('name', 'id')->all();
            unset($department['1']);

            // member of all Department
            $getMember = Department::where('id', Auth::user()->department_id)->with('users')->first();
            foreach ($getMember->users as $key => $item) {
                if ($item->getRoleNames()[0] === 'Manager' || $item->getRoleNames()[0] === 'Leader') {
                    unset($getMember->users[$key]);
                    continue;
                }
                $member[$item->id] = $item->name;
            }

            return view('projects.create', compact('department', 'users', 'status', 'member'));
        } else {
            $users = User::pluck('name', 'name')->all();
            $getDepartmentId = User::where('id', Auth::user()->id)->get();
            foreach ($getDepartmentId as $key => $value) {
                $id_department = $value->id;
            }
            $department = Department::where('id', $id_department)->pluck('name', 'id');
            $users = User::where('id', $id_department)->pluck('name', 'id');
            unset($department['id']);
            unset($users['id']);

            return view('projects.create', compact('department', 'users', 'status'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ------------XỬ LÝ TẠO DỰ ÁN---------------
    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => 'required',
            'details' => 'required',
            'start' => 'after:today',
            'end' => 'after:start',
            'assign' => 'required',
            'member' => 'required',
        ]);
        foreach ($request->member as $key => $value) {
            if (Project::isSameDepartment($request->assign) !== Project::isSameDepartment($value)) {
                return redirect()->back()->withInput()->with('errorsMem', 'Member different to leader');
            }
        }

        //luu data
        $input = $request->all();
        $input['member'][] = $input['assign'];
        $input['department_id'] = User::where('id', $input['assign'])->first()->department_id;
        $input['creator'] = Auth::user()->id;
        //data Notification
        $data = ([
            'title' => User::where('id', $input['creator'])->first()->name . ' Create New Project',
            'content' => 'You have just been added to a project with manager of project is' . User::where('id', $input['assign'])->first()->name,
        ]);

        $project = Project::create($input);
        if ($project) {
            //luu Project - User
            if ($input['member'] !== []) {
                foreach ($input['member'] as $item) {
                    $data['user_id'] = $item;
                    $data['project_id'] = $project->id;
                    $data['name'] = User::where('id', $data['user_id'])->first()->name;
                    ProjectUser::create($data);

                    //Send Notification
                    User::where('id', $item)->first()->notify(new MakeNotification($data));
                }
            }

            //Send Notification

            return redirect()->route('projects.index')
                ->with('success', 'Projects created successfully.');
        } else {
            return redirect()->route('projects.create')->withErrors();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    // ------------HIỆN THỊ DỰ ÁN---------------
    public function show(Project $project)
    {
        $status = Status::all()->pluck('name', 'name');
        $taskOfProject = Project::where('id', $project->id)->with('users')->first();
        $getUser = ProjectUser::where('project_id', $project->id)->get()->pluck('name', 'user_id');
        $getManager = User::where('id', $project->assign)->first();

        // tasks cotroll\
        $s = Task::all();
        foreach ($s as $value) {
            //pending
            if ($value->progress > 0) {
                continue;
            }
            $t = Task::setupStatusByTime($value);
            // dd($t);
            $value->update(['status_id' => $t]);
        }

        //Status has Task
        $getAllStatus = Status::all();
        foreach ($getAllStatus as $key => $value) {
            $taskOfStatus[] = Task::where('status_id', $value->id)->where('project_id', $project->id)->with('users')->get();
        }
        $getStatusTask = $getAllStatus->pluck('name', 'id');

        //Task User
        $tasksUser = Task::where('assign', Auth::user()->id)->join('statuses', 'statuses.id', '=', 'tasks.status_id' )
                                                        ->select('tasks.*','statuses.name as statusName')
                                                        ->get();

        return view('projects.show', compact('project', 'getUser', 'getManager', 'taskOfProject', 'status', 'getAllStatus', 'taskOfStatus', 'getStatusTask', 'tasksUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    // ------------CẬP NHẬT DỰ ÁN---------------
    public function edit(Project $project)
    {
        // if(Auth::user()->getRoleNames()[0] == 'Admin'){
        //     $department = Department::all()->pluck('name');
        //     // dd($department);
        // }
        // return view('projects.edit',compact('project','department'));

        $status = Status::pluck('name', 'name')->all();
        if (Auth()->user()->getRoleNames()[0] == 'Admin') {
            $getMember = Department::where('id', '!=', 1)->with('users')->get();
            foreach ($getMember as $key => $value) {

                //delete item not manager and Leader
                foreach ($value->users as $key => $item) {
                    if ($item->getRoleNames()[0] === 'Manager' || $item->getRoleNames()[0] === 'Leader') {
                        continue;
                    }
                    unset($value->users[$key]);
                }

                $users[$value->name] = $value->users->pluck('name', 'id');
            }

            $department = Department::pluck('name', 'id')->all();

            //xoa admin
            unset($department['1']);
            unset($users['1']);

            // member of all Department
            $getMember = Department::where('id', '!=', 1)->with('users')->get();
            foreach ($getMember as $key => $value) {
                // dd(count($value->users));
                //delete item not manager and Leader
                foreach ($value->users as $key => $item) {
                    if ($item->getRoleNames()[0] === 'Manager' || $item->getRoleNames()[0] === 'Leader') {
                        unset($value->users[$key]);
                        continue;
                    }
                }
                $member[$value->name] = $value->users->pluck('name', 'id');
            }
            // dd($member);

            return view('projects.edit', compact('project', 'department', 'users', 'status', 'member'));
        } else {
            $getDepartmentId = User::where('id', Auth::user()->id)->first();
            $department[Auth::user()->department->id] = Auth::user()->department->name;
            $users = User::where('id', $getDepartmentId->id)->pluck('name', 'id');

            // member of all Department
            $getMember = Department::where('id', Auth::user()->department_id)->with('users')->first();
            foreach ($getMember->users as $key => $item) {
                if ($item->getRoleNames()[0] === 'Manager' || $item->getRoleNames()[0] === 'Leader') {
                    unset($getMember->users[$key]);
                    continue;
                }
                $member[$item->id] = $item->name;
            }

            return view('projects.edit', compact('project', 'department', 'users', 'status', 'member'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    // ------------XỬ LÝ CẬP NHẬT DỰ ÁN---------------
    public function update(Request $request, Project $project)
    {
        request()->validate([
            'name' => 'required',
            'details' => 'required',
            // 'start' => 'required',
            'end' => 'after:start',
            // 'status' => 'required',
        ]);

        //data
        $input = $request->all();
        if (empty($input['start'])) {
            $input = Arr::except($input, array('start'));
        }

        //luu data
        if ($project->update($input)) {
            return redirect()->route('projects.index')
                ->with('success', 'Product updated successfully');
        } else {
            return redirect()->back()->withErrors($validated)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    // ------------XOÁ DỰ ÁN---------------
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')
            ->with('success', 'Product deleted successfully');
    }
}
