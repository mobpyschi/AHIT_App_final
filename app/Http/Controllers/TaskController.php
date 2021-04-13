<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response

     */
    public function taskStore($id, Request $request)
    {
        // dd($request);
        $validate = request()->validate([
            'name' => 'required',
            'details' => 'required',
            'start' => 'after:today',
            'end' => 'after:start',
            'assign' => 'required',
        ]);
        $project = Project::where('id', $id)->first();
        if($validate['end'] >= $project->end){
            return redirect()->back()->withErrors('The end date must not be greater than the end date of the project');
        }
        if($validate['start'] >= $project->start){
            return redirect()->back()->withErrors('The start date must not be greater than the project start date');
        }

        $input = $request->all();
        // $input['status_id']= 1;
        $input['project_id'] = $id;
        $input['creator'] = Auth::user()->id;
        $taskStore = Task::create($input);
        //create event
        Task::noteCalendar($taskStore);
        return redirect()->route('projects.show', $id);
    }

    /**
     * Day la phan edit task..........
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response

     */
    public function taskUpdate($id, Request $request)
    {
        request()->validate([
            'name' => 'required|max:50',
            'details' => 'required|max:150',
            'start' => 'required',
            'end' => 'after:start',
            'assign' => 'required',
            'project_id' => 'required',
        ]);
        $input = $request->all();
        // dd($input);
        $tasks = Task::find($id)->update($input);
        return redirect()->route('projects.show', $input['project_id']);

    }

    /**
     * Day la phan edit task..........
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response

     */
    public function taskSubmit($id, Request $request)
    {
        $validate = $request->validate([
            'note' => 'required',
            'progress' => 'required',
        ]);
        $input = $request->all();
        if ($input['filesubmit'] == null && $input['note'] == null) {
            return redirect()->back()->with('errors' , 'no input in note and progress');
        }
        $input['filesubmit'] = null;
        $input['status_id'] = 3;
        $tasks = Task::find($id);
        $tasks->update($input);

        //make notification
        $projId = Project::where('id', $tasks->project_id)->first()->assign;
        Task::sendNotify($projId, $tasks);

        // $tasks->update(['status_id' => 3]);
        return redirect()->route('projects.show',$tasks->project_id)->with('taskSubmit', 'You already submited ');
    }

    /**
     * update status tasks
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response

     */
    public function updateStatus($id, $status_id)
    {
        $tasks = Task::find($id);
        $id_pro = $tasks->project_id;

        //pending only process > 0
        if ($status_id == "5" && $tasks->progress <= 0) {//dd($id_pro,$id,$status_id);
            return redirect()->back()->with('errors', 'work progress has not been reported yet');
        }

        //pending only process > 0
        if ($status_id == 3 && $tasks->progress <= 0) {
            return redirect()->route('projects.show',$id_pro)->with('errors', 'work progress has not been reported yet');
        }

        //new ---to--- inprocess
        if ($tasks->status_id == 1 && $status_id == 2) {
            $tasks->update(['status_id' => $status_id, 'start' => now()]);
            return redirect()->route('projects.show',$id_pro)->with('success', 'Inprocess');
        }

        $tasks->update(['status_id' => $status_id]);
        $tasks = Task::find($id)->update(['status_id' => $status_id]);
        return redirect()->route('projects.show',$id_pro)->with('updateStatus', 'You already update Task');
    }

    public function detailTask($id,$statusTask)
    {
        if($statusTask === '4'){
            return redirect()->back()->withErrors('RENEWED TO CONTINUE !!');
        }
        //Task User
        $tasksUser = Task::where('id', $id)->first();
        return view('projects.tasks.detailsTask', compact('tasksUser'));
    }

    /**
     * delete task
     *
     * task_id $id
     */
    public function deleteTask($id)
    {
        Task::find($id)->delete();
        return redirect()->back()->with('success','delete success');
    }

}
