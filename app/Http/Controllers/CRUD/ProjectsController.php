<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $items = Project::where('name', 'LIKE', "%{$search}%")
            ->paginate(10);
        }else{
            $items = Project::paginate(10);
        }
        $filters = $request->all();  
        return Inertia::render('HumanRessources/Projects/projects', ['projects' => $items, 'filters'=>$filters]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:projects',
            'details' => 'string|nullable',
        ]);
        // creating data
        $item = new Project();
        $item->name = $validatedData['name'];
        $item->details = $validatedData['details'];
        $item->save();
        // returning updated data to the form
        return to_route('projects.index');
    }

    public function destroy($id){
        // Find the item by id
        $item = Project::find($id);
        
        if (!$item) {
            return to_route('projects.index')->with(['message' => 'Project not found']);
        }
        // Delete the item
        $item->delete();
    
        return to_route('projects.index');
    }

    public function edit($id){
        $item = Project::find($id);
        return Inertia::render('HumanRessources/Projects/edit', ['project' => $item]);
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'name' => ['required','string', 'max:255',Rule::unique('projects')->ignore($id)],
            'details' => 'string|nullable',
        ]);
        $item = Project::find($id);
        $item->name = $validatedData['name'];
        $item->details = $validatedData['details'];
        $item->save();
        // returning updated data to the form
        return to_route('projects.index');
    }
}
