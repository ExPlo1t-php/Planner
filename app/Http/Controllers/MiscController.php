<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MiscController extends Controller
{
    public function index(){
        return Inertia::render('Help/index');
    }
}
