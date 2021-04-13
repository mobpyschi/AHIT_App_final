<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    /**
     *
     *  The Task that belong to the status.
     *
     */
    public function tasks(){
        return $this->has(Status::class,'id','status_id');
    }


}
