<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryChecks extends Model
{
    use HasFactory;
    protected $fillable = ['model_id','checkin_time','checkout_time','description','OT_time'];
}
