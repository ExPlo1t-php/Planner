<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PositionsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $items = Position::where('name', 'LIKE', "%{$search}%")
            ->paginate(10);
        }else{
            $items = Position::paginate(10);
        }
        $filters = $request->all();  
        return Inertia::render('HumanRessources/Positions/positions', ['positions' => $items, 'filters'=>$filters]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:positions',
        ]);
        // creating data
        $item = new Position();
        $item->name = $validatedData['name'];
        $item->save();
        // returning updated data to the form
        return to_route('positions.index');
    }

    public function destroy($id){
        // Find the item by id
        $item = Position::find($id);
        
        if (!$item) {
            return to_route('positions.index')->with(['message' => 'Driver not found']);
        }
        // Delete the item
        $item->delete();
    
        return to_route('positions.index');
    }

    public function edit($id){
        $item = Position::find($id);
        return Inertia::render('HumanRessources/Positions/edit', ['position' => $item]);
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'name' => ['required','string', 'max:255',Rule::unique('positions')->ignore($id)],
        ]);
        $item = Position::find($id);
        $item->name = $validatedData['name'];
        $item->save();
        // returning updated data to the form
        return to_route('positions.index');
    }
}
