<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TeamsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $items = Team::where('name', 'LIKE', "%{$search}%")
            ->orWhere('shift', 'LIKE', "%{$search}%")
            ->paginate(10);
        }else{
            $items = Team::paginate(10);
        }
        $projects = Project::all();
            return Inertia::render('HumanRessources/Teams/teams', 
            ['teams' => $items, 'projects'=>$projects]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:teams',
            'shift' => 'required|string',
            // change this later
            'project_id' => 'integer',
        ]);
        // creating data
        $item = new Team();
        $item->name = $validatedData['name'];
        $item->shift = $validatedData['shift'];
        $item->project_id = $validatedData['project_id'];
        $item->save();
        // returning updated data to the form
        return to_route('teams.index');
    }

    public function destroy($id){
        // Find the item by id
        $item = Team::find($id);
        
        if (!$item) {
            return to_route('teams.index')->with(['message' => 'Team not found']);
        }
        // Delete the item
        $item->delete();
    
        return to_route('teams.index');
    }

    public function edit($id){
        $item = Team::find($id);
        $projects = Project::all();
        return Inertia::render('HumanRessources/Teams/edit', ['team' => $item, 'projects'=>$projects]);
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'name' => ['required','string', 'max:255',Rule::unique('teams')->ignore($id)],
            'shift' => 'required|string',
            // change this later
            'project_id' => 'integer',
        ]);
        $item = Team::find($id);
        $item->name = $validatedData['name'];
        $item->shift = $validatedData['shift'];
        $item->project_id = $validatedData['project_id'];
        $item->save();
        // returning updated data to the form
        return to_route('teams.index');
    }
}
