<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class VehiclesController extends Controller
{
    
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $vehicles = Vehicle::where('registration_number', 'LIKE', "%{$search}%")
            ->orWhere('entree_date', 'LIKE', "%{$search}%")
            ->orWhere('bus_number', 'LIKE', "%{$search}%")
            ->paginate(10);
        }else{
            $vehicles = Vehicle::paginate(10);
        }
        $filters = $request->all();  
        return Inertia::render('Transport/Vehicles/vehicles', ['vehicles' => $vehicles, 'filter'=>$search, 'filters'=>$filters]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'registration_number' => 'required|string|max:255|unique:vehicles',
            'bus_number' => 'required|integer|max:20|unique:vehicles',
            'entree_date' => 'required|date|max:255',
        ]);
        // creating data
        $vehicle = new Vehicle();
        $vehicle->registration_number = $validatedData['registration_number'];
        $vehicle->bus_number = $validatedData['bus_number'];
        $vehicle->entree_date = $validatedData['entree_date'];
        $vehicle->save();
        // returning updated data to the form
        return to_route('vehicles.index');
    }

    public function destroy($id){
    // Find the vehicle by id
    $vehicle = Vehicle::find($id);

    if (!$vehicle) {
        return to_route('vehicles.index')->with(['message' => 'Vehicle not found']);
    }
    // Delete the vehicle
    $vehicle->delete();

    return to_route('vehicles.index');
    }
    
    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'registration_number' => ['required','string','max:255', Rule::unique('vehicles')->ignore($id)],
            'bus_number' => ['required','integer','max:20', Rule::unique('vehicles')->ignore($id)],
            'entree_date' => 'required|date|max:255',
        ]);
        // creating data
        $vehicle = Vehicle::find($id);
        $vehicle->registration_number = $validatedData['registration_number'];
        $vehicle->bus_number = $validatedData['bus_number'];
        $vehicle->entree_date = $validatedData['entree_date'];
        $vehicle->save();
        // returning updated data to the form
        return to_route('vehicles.index');
    }

    public function edit($id){
        $vehicle = Vehicle::find($id);
        return Inertia::render('Transport/Vehicles/edit', ['vehicle' => $vehicle]);
    }
}
