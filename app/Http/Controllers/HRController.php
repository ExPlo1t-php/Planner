<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Department;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\History;
use App\Models\Station;
use App\Models\Terminal;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HRController extends Controller
{
    public function index(Request $request){
        $items = History::get();
        $employees = Employee::whereNot('position_id', 1)
        ->orWhereNot('position_id', 2)
        ->get();
        $absences = Absence::get();
        $departments = Department::get();
        $drivers = Driver::get();
        $terminals = Terminal::get();
        $vehicles = Vehicle::get();

        return Inertia::render(
            'Plannings/HR/index',
             ['items'=>$items,
            'employees'=>$employees,
            'absences'=>$absences,
            'departments'=>$departments,
            'drivers'=>$drivers,
            'terminals'=>$terminals,
            'vehicles'=>$vehicles
            ]);
    }
}
