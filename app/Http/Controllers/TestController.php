<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class TestController extends Controller
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
        return view('tests.index');
        if (Auth::user()->department_id == 1) {
            $projects = Project::all();
            $departments = Department::all();
            return view('tests.index', compact('projects', 'departments'));
        } else {
            $projects = Project::all();
            $departments = Department::all();
            return view('tests.index', compact('projects', 'departments'));
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
            $users = User::pluck('name', 'name')->all();

            $department = Department::pluck('name', 'id')->all();

            unset($department['1']);
            unset($users['Admin']);

            //test
            $testload = Department::all()->load("users");
            return view('tests.create', compact('department', 'users', 'status', 'testload'));
        } else {
            $users = User::pluck('name', 'name')->all();
            $getDepartmentdeId = User::where('id', Auth::user()->id)->get();
            foreach ($getDepartmentId as $key => $value) {
                $id_department = $value->id;
            }
            $department = Department::where('id', $id_department)->pluck('name', 'name');
            $users = User::where('id', $id_department)->pluck('name', 'name');
            unset($department['Admin']);
            unset($users['Admin']);

            return view('tests.create', compact('department', 'users', 'status'));
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
        request()->validate([
            'name' => 'required',
            'details' => 'required',
            'start' => 'required',
            'end' => 'required',
            'department' => 'required',
            'users' => 'required',
        ]);
        dd($request);
        //luu data
        $input = $request->all();
        $department_id = Department::where('name', $input['department'])->first()->id;
        $assign = User::where('name', $input['users'])->first()->id;
        $input['department_id'] = $department_id;
        $input['assign'] = $assign;
        if (Project::create($input)) {
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
    public function show($id)
    {
        $status = Status::all()->pluck('name', 'name');
        $taskOfProject = Project::find($id)->tasks;

        $show = Project::where('id', $id)->first();
        $getUser = User::where('department_id', $show->department_id)->pluck('name', 'name')->all();
        $getManager = User::where('id', $show->assign)->first();
        return view('projects.show', compact('show', 'getUser', 'getManager', 'taskOfProject', 'status'));
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
            $users = User::pluck('name', 'name')->all();

            $department = Department::pluck('name', 'name')->all();

            //xoa admin
            unset($department['Admin']);
            unset($users['Admin']);

            return view('projects.edit', compact('project', 'department', 'users', 'status'));
        } else {
            $users = User::pluck('name', 'name')->all();
            $getDepartmentId = User::where('id', Auth::user()->id)->first();

            $v = Auth::user()->department->name;
            $department[$v] = $v;

            $users = User::where('id', $getDepartmentId->id)->pluck('name', 'name');

            return view('projects.edit', compact('project', 'department', 'users', 'status'));
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
            'start' => 'required',
            'end' => 'required',
            'status' => 'required',
        ]);

        //data
        $input = $request->all();

        //luu data
        $department_id = Department::where('name', $input['department'])->first()->id;
        $assign = User::where('name', $input['users'])->first()->id;
        $input['department_id'] = $department_id;
        $input['assign'] = $assign;
        // dd($input);
        if ($project->update($input)) {
            return redirect()->route('projects.index')
                ->with('success', 'Product updated successfully');
        } else {
            return redirect()->route('projects.create')->withErrors();
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
