<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DepartmentsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $items = Department::where('name', 'LIKE', "%{$search}%")
            ->orWhere('info', 'Like', "%{$search}%")
            ->get();
        }else{
            $items = Department::all();
        }
            return Inertia::render('HumanRessources/Departments/departments', ['departments' => $items]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'info' => 'string|nullable',
        ]);
        // creating data
        $item = new Department();
        $item->name = $validatedData['name'];
        $item->info = $validatedData['info'];
        $item->save();
        // returning updated data to the form
        return to_route('departments.index');
    }

    public function destroy($id){
        // Find the item by id
        $item = Department::find($id);
        
        if (!$item) {
            return to_route('departments.index')->with(['message' => 'Department not found']);
        }
        // Delete the item
        $item->delete();
    
        return to_route('departments.index');
    }

    public function edit($id){
        $item = Department::find($id);
        return Inertia::render('HumanRessources/Departments/edit', ['department' => $item]);
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'name' => ['required','string', 'max:255',Rule::unique('departments')->ignore($id)],
            'info' => 'string|nullable',
        ]);
        $item = Department::find($id);
        $item->name = $validatedData['name'];
        $item->info = $validatedData['info'];
        $item->save();
        // returning updated data to the form
        return to_route('departments.index');
    }
}
