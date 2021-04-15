<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Email',
        'Sex',
        'Date_of_birth',
        'Work_start',
        'Work_end',
        'Department',
        'Role',
        'Certificate',
        'Address',
        'Residence_Address',
        'Phone',
        'user_id'
    ];
}
