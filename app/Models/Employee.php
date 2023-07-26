<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'department_id',
        'project_id',
        'position_id',
        'station_id',
        'team_leader_manager_id',
        'team_id',
        'terminal_id',
        'photo',
    ];
}
