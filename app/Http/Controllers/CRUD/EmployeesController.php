<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Project;
use App\Models\Station;
use App\Models\Team;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EmployeesController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $items = Employee::where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('last_name', 'LIKE', "%{$search}%")
            ->orWhere('employee_number', 'LIKE', "%{$search}%")
            ->get();
        }else{
            $items = Employee::all();
        }
        // this has to change !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $leaders = Employee::select('id', 'first_name')->get();
        // this has to change
        $departments = Department::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();
        $positions = Position::select('id', 'name')->get();
        $stations = Station::select('id', 'name')->get();
        $teams = Team::select('id', 'name')->get();
        $terminals = Terminal::select('id', 'name')->get();
        return Inertia::render('HumanRessources/Employees/employees',
                                ['employees' => $items,
                                 'leaders' => $leaders,
                                 'departments' => $departments,
                                 'projects' => $projects,
                                 'positions' => $positions,
                                 'stations' => $stations,
                                 'teams' => $teams,
                                 'terminals' => $terminals,
                                ]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'employee_number' => 'required|string|max:255|unique:employees',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'integer',
            'project_id' => 'integer',
            'position_id' => 'integer',
            'station_id' => 'integer',
            'team_leader_manager_id' => 'integer|nullable',
            'team_id' => 'integer|nullable',
            'terminal_id' => 'integer|nullable',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);
        // image validation
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $originalFilename = $request->photo->getClientOriginalName();
        // unused code -----
            // $fileExtension = $request->photo->getClientOriginalExtension();
            // $imagePath = $imageName . '.' . $fileExtension;
            // $imagePath = $request->photo->getClientOriginalName();
        // unused code -----
            $imageName = time() . '_' . str_replace(' ', '_', $originalFilename);
            $request->file('photo')->move(public_path('/employees/'), $imageName);
        } else {
            $imageName = null; // Setting the path to null if no image is uploaded
        }
        // creating data
        $item = new Employee();
        $item->employee_number = $validatedData['employee_number'];
        $item->first_name = $validatedData['first_name'];
        $item->last_name = $validatedData['last_name'];
        $item->department_id = $validatedData['department_id'];
        $item->project_id = $validatedData['project_id'];
        $item->position_id = $validatedData['position_id'];
        $item->station_id = $validatedData['station_id'];
        $item->team_leader_manager_id = $validatedData['team_leader_manager_id'];
        $item->team_id = $validatedData['team_id'];
        $item->terminal_id = $validatedData['terminal_id'];
        $item->photo = $imageName;
        $item->save();
        // returning updated data to the form
        return to_route('employees.index');
    }

    public function destroy($id){
        // Find the item by id
        $item = Employee::find($id);
        if (File::exists(public_path('/employees/'.$item->photo))){
            File::delete(public_path('/employees/'.$item->photo));
        }
        
        if (!$item) {
            return to_route('employees.index')->with(['message' => 'Employee not found']);
        }
        // Delete the item
        $item->delete();
    
        return to_route('employees.index');
    }

    public function edit($id){
        $item = Employee::find($id);
        // this has to change !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $leaders = Employee::select('id', 'first_name')->where('position_id', 'LIKE', 2)->get();
        // this has to change
        $departments = Department::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();
        $positions = Position::select('id', 'name')->get();
        $stations = Station::select('id', 'name')->get();
        $teams = Team::select('id', 'name')->get();
        $terminals = Terminal::select('id', 'name')->get();
        return Inertia::render('HumanRessources/Employees/edit', 
                                ['employee' => $item,
                                'leaders' => $leaders,
                                'departments' => $departments,
                                'projects' => $projects,
                                'positions' => $positions,
                                'stations' => $stations,
                                'teams' => $teams,
                                'terminals' => $terminals,
                            ]);
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
        'employee_number' => ['required','string', 'max:255',Rule::unique('employees')->ignore($id)],
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'department_id' => 'integer',
        'project_id' => 'integer',
        'position_id' => 'integer',
        'station_id' => 'integer',
        'team_leader_manager_id' => 'integer|nullable',
        'team_id' => 'integer|nullable',
        'terminal_id' => 'integer|nullable',
        'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);
        // image validation
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $originalFilename = $request->photo->getClientOriginalName();
            $imageName = time() . '_' . str_replace(' ', '_', $originalFilename);
            $request->file('photo')->move(public_path('/employees/'), $imageName);
        } else {
            $imageName = null; // Setting the path to null if no image is uploaded
        }
        // fetching/updating data
        $item = Employee::find($id);
        $item->employee_number = $validatedData['employee_number'];
        $item->first_name = $validatedData['first_name'];
        $item->last_name = $validatedData['last_name'];
        $item->department_id = $validatedData['department_id'];
        $item->project_id = $validatedData['project_id'];
        $item->position_id = $validatedData['position_id'];
        $item->station_id = $validatedData['station_id'];
        $item->team_leader_manager_id = $validatedData['team_leader_manager_id'];
        $item->team_id = $validatedData['team_id'];
        $item->terminal_id = $validatedData['terminal_id'];
        $item->photo = $imageName;
        $item->save();

        return to_route('employees.index');
    }


}
