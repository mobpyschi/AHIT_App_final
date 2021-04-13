<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;
    protected $fillable = ['ipDefaut','name','timeStartCheckin','timeEndCheckin','timeStartCheckout','timeEndCheckout'];
}
