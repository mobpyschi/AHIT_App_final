<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Function get user By Department
     *
     *
     */
    public static function getBYDepartment($department_id)
    {
        $userByDepartment = User::where('department_id', $department_id)->get();

        return $userByDepartment;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function history()
    {
        return $this->hasMany(HistoryChecks::class, 'model_id', 'id');
    }

    public function detailUser()
    {
        return $this->hasMany(UserDetail::class, 'user_id', 'id');
    }
    /**
     * The Project that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hasProjects()
    {
        return $this->hasMany(Project::class, 'assign', 'id');
    }

    /**
     * The Project that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasmany
     */
    public function hasTasks()
    {
        return $this->hasMany(Task::class, 'assign', 'id');
    }

}
