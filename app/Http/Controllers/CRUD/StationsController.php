<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class StationsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $items = Station::where('name', 'LIKE', "%{$search}%")
            ->paginate(10);
        }else{
            $items = Station::paginate(10);
        }
        $projects = Project::all();
            return Inertia::render('HumanRessources/Stations/stations', ['stations' => $items, 'projects'=>$projects]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:stations',
            'project_id' => 'integer',
        ]);
        // creating data
        $item = new Station();
        $item->name = $validatedData['name'];
        $item->project_id = $validatedData['project_id'];
        $item->save();
        // returning updated data to the form
        return to_route('stations.index');
    }

    public function destroy($id){
        // Find the item by id
        $item = Station::find($id);
        
        if (!$item) {
            return to_route('stations.index')->with(['message' => 'Station not found']);
        }
        // Delete the item
        $item->delete();
    
        return to_route('stations.index');
    }

    public function edit($id){
        $item = Station::find($id);
        $projects = Project::all();
        return Inertia::render('HumanRessources/Stations/edit', ['station' => $item, 'projects'=>$projects]);
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'name' => ['required','string', 'max:255',Rule::unique('stations')->ignore($id)],
            'project_id' => 'integer',
        ]);
        $item = Station::find($id);
        $item->name = $validatedData['name'];
        $item->project_id = $validatedData['project_id'];
        $item->save();
        // returning updated data to the form
        return to_route('stations.index');
    }
}
