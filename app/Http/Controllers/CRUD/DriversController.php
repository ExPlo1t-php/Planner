<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DriversController extends Controller
{
    public function index(Request $request){
            $search = $request->input('search');
            // validating if the $search variable is not empty
            if($search){
                $drivers = Driver::where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('vehicle_number', 'LIKE', "%{$search}%")
                ->paginate(10);
            }else{
                $drivers = Driver::paginate(10);
            }
            $vehicles = Vehicle::select('id', 'bus_number')->get();
            $filters = $request->all();  
            return Inertia::render('Transport/Drivers/drivers', ['drivers' => $drivers, 'vehicles'=>$vehicles, 'filters'=>$filters]);
        }

        public function create(Request $request){
            // form validation
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'vehicle_number' => 'required|integer|unique:drivers',
            ]);
            // creating data
            $driver = new Driver();
            $driver->first_name = $validatedData['first_name'];
            $driver->last_name = $validatedData['last_name'];
            $driver->vehicle_number = $validatedData['vehicle_number'];
            $driver->save();
            // returning updated data to the form
            return to_route('drivers.index');
        }
    
    public function destroy($id){
        // Find the item by id
        $driver = Driver::find($id);
        
        if (!$driver) {
            return to_route('drivers.index')->with(['message' => 'Driver not found']);
        }
        // Delete the item
        $driver->delete();
    
        return to_route('drivers.index');
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'vehicle_number' => ['required','integer',Rule::unique('drivers')->ignore($id)],
        ]);
        $driver = Driver::find($id);
        $driver->first_name = $validatedData['first_name'];
        $driver->last_name = $validatedData['last_name'];
        $driver->vehicle_number = $validatedData['vehicle_number'];
        $driver->save();
        // returning updated data to the form
        return to_route('drivers.index');
    }
    
    public function edit($id){
        $drivers = Driver::all();
        $driver = Driver::find($id);
        $vehicles = Vehicle::select('id', 'bus_number')->get();
        return Inertia::render('Transport/Drivers/edit', ['driver' => $driver, 'vehicles'=>$vehicles, 'drivers'=>$drivers]);
    }


}
