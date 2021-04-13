<?php

namespace App\Models;

use App\Models\User;
use App\Notifications\MakeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'details', 'start', 'end', 'status_id', 'assign', 'project_id', 'creator', 'description', 'filesubmit', 'note', 'progress'];

    public function users()
    {
        return $this->belongsTo(User::class, 'assign', 'id');
    }

    /**
     * setup status by time
     *
     */
    public static function setupStatusByTime(Task $task)
    {
        if ($task->status_id !== 5) {
            //overDue
            if ($task->end <= now()) {
                return 4;
            }
            // new
            if ($task->start >= now()) {
                return 1;
            }
            //inprocess
            if ($task->start <= now()) {
                return 2;
            }
        }
    }

    /**
     * send notification
     *
     */
    public static function sendNotify($projId, $tasks)
    {
        $assignName = User::where('id', $tasks->assign)->first()->name;
        $data = ([
            'title' => 'You just had task-submit',
            'content' => $assignName . " has been submit task",
        ]);
        User::where('id', $projId)->first()->notify(new MakeNotification($data));
    }

    /**
     * ghi len calendar
     *
     * Task #task
     */
    public static function  noteCalendar($task){
        Event::create([
            'title' => $task->name,
            'start' => $task->start,
            'end' => $task->end,
            'description' => $task->details,
            'model_id' => $task->assign,
            'task_id' => $task->id
        ]);
    }

}
