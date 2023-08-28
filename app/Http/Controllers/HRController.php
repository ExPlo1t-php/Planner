<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\History;
use App\Models\Station;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HRController extends Controller
{
    public function index(Request $request){
        $items = History::get();
        $employees = Employee::get();
        return Inertia::render(
            'Plannings/HR/index',
             ['items'=>$items,
            'employees'=>$employees]);
    }
}
