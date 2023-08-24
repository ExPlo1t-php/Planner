<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Station;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HRController extends Controller
{
    public function index(Request $request){
        $items = Employee::get();
        return Inertia::render('Plannings/HR/index', ['items'=>$items]);
    }
}
