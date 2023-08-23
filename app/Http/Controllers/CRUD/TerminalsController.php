<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Terminal;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TerminalsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $terminals = Terminal::where('name', 'LIKE', "%{$search}%")
            ->orWhere('address', 'LIKE', "%{$search}%")
            ->orWhere('trajet', 'LIKE', "%{$search}%")
            ->orWhere('vehicle_number', 'LIKE', "%{$search}%")
            ->paginate(10)->withquerystring();
        }else{
            $terminals = Terminal::paginate(10);
        }
        $vehicles = Vehicle::select('id', 'bus_number')->get();
        $filters = $request->all();  
        return Inertia::render('Transport/Terminals/terminals', ['terminals' => $terminals, 'vehicles'=>$vehicles, 'filters'=>$filters]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'trajet' => 'required|string|max:255',
            'vehicle_number' => 'required|integer|max:20',
        ]);
    // creating data
    $terminal = new Terminal();
    $terminal->name = $validatedData['name'];
    $terminal->address = $validatedData['address'];
    $terminal->trajet = $validatedData['trajet'];
    $terminal->vehicle_number = $validatedData['vehicle_number'];
    $terminal->save();
    // returning updated data to the form
    return to_route('terminals.index');
}

public function destroy($id){
    // Find the vehicle by id
    $terminal = Terminal::find($id);
    
    if (!$terminal) {
        return to_route('terminals.index')->with(['message' => 'Terminal not found']);
    }
    // Delete the vehicle
    $terminal->delete();

    return to_route('terminals.index');
}

public function update(Request $request, $id){
    // form validation
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'trajet' => 'required|string|max:255',
        'vehicle_number' => ['required','integer','max:20'],
    ]);
    $terminal = Terminal::find($id);
    $terminal->name = $validatedData['name'];
    $terminal->address = $validatedData['address'];
    $terminal->trajet = $validatedData['trajet'];
    $terminal->vehicle_number = $validatedData['vehicle_number'];
    $terminal->save();
    // returning updated data to the form
    return to_route('terminals.index');
}

public function edit($id){
    $terminal = Terminal::find($id);
    $vehicles = Vehicle::select('id', 'bus_number')->get();
    return Inertia::render('Transport/Terminals/edit', ['terminal'=>$terminal, 'vehicles'=>$vehicles]);
}
}
