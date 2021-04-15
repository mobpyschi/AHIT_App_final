<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'details', 'start', 'end', 'status', 'department_id', 'assign', 'creator', 'description'];

    /**
     *
     *  The Project that belong to the User.
     *
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id', 'assign');
    }

    /**
     *
     *  The Project that belong to the User.
     *
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    /**
     * Count Process
     * member $id
     */
    public static function isSameDepartment($id)
    {
        $getDepartment = User::where('id', $id)->first()->department_id;
        return $getDepartment;
    }

    /**
     * Project
     *
     * review status project ( Done -> 1.Early 2.OnTime, late +(day) , )
     */
    public static function statusProject($project)
    {
        if (count($project->tasks) > 0) {
            $sumProgress = 0;
            $count = count($project->tasks) > 0 ? count($project->tasks) : 1;
            if (!empty($project->tasks)) {
                $allProjectTask = $project->tasks;
                foreach ($allProjectTask as $task) {
                    $sumProgress += $task->progress;
                }
            }
            $result = $sumProgress / $count;
            if ($result == 100) {
                return $project->update(['status' => 'Done']);
            }
        }
        //check done
        if ($project->status !== 'done') {
            // inprocess
            {
                if ($project->end >= now()) {
                    return $project->update(['status' => 'InProgress']);
                }
            }

            // late
            if ($project->end < now()) {

                //if done in time
                // if(done){}

                return $project->update(['status' => 'late ' . now()->diffForHumans($project->end)]); //$project->end .' late '.
            }
        }

        return \redirect()->route('projects.index');
    }

}
