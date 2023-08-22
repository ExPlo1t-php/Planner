<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Absence;
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
        // filter query
        $query = Employee::query();
        $teamsQ = Team::query();
        // filtering with search
        if($request->has('search')){
            $search = $request->query('search');
            $query->where(function ($q) use ($search){
                $q->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('employee_number', 'LIKE', "%{$search}%");
            });
            // other filters
        }
        // adding department filter
        if ($request->has('department')) {
            $department = $request->query('department');
            $query->where('department_id', $department);
        }
        // adding project filter
        if ($request->has('project')) {
            $project = $request->query('project');
            $query->where('project_id', $project);
        }
        // adding team filter
        if ($request->has('team')) {
            $team = $request->query('team');
            $query->where('team_id', $team);
        }
        // adding position filter
        if ($request->has('position')) {
            $position = $request->query('position');
            $query->where('position_id', $position);
        }
        $items = $query->paginate(10);
        // end of employee filtering
        // filtering modal data -------------
        $filtered_teams = $teamsQ->get();
        
        $stationsQM = Station::query();
        $teamsQM = Team::query();
        if ($request->has('projectM')){
            $projectM = $request->query('projectM');
            // Query Modal
            $stationsQM->where('project_id', $projectM);
            $teamsQM->where('project_id', $projectM);
        }
        $filtered_stations_modal = $stationsQM->get();
        $filtered_teams_modal = $teamsQM->get();
        
        // filtering for leaders (Team leaders, shift leaders, manager)
        $leadersQM = Employee::query();
        if ($request->has('positionM')){
            // fetching selected id from request
            $positionM = $request->query('positionM');
            // comparing id  to position 1=operator < 2=teamleader < 3=shiftleader < 4=manager
            if($positionM == 1){
                $leadersQM->where('position_id',2);
            }elseif($positionM == 2){
                $leadersQM->where('position_id', 3);
            }else{
                $leadersQM->where('position_id', 4);
            }
        }
        $leaders = $leadersQM->select('id', 'first_name', 'last_name')->get();
        // other data fetching
        

        $departments = Department::select('id', 'name', 'positions')->get();
        $projects = Project::select('id', 'name')->get();
        $positions = Position::select('id', 'name')->get();
        $teams = Team::select('id', 'name')->get();
        $terminals = Terminal::select('id', 'name')->get();
        $stations = Station::select('id', 'name')->get(); 
        $filters = $request->all();  

        return Inertia::render('HumanRessources/Employees/employees',
        ['employees' => $items,
            'leaders' => $leaders,
            'departments' => $departments,
            'projects' => $projects,
            'positions' => $positions,
            'stations' => $stations,
            'teams' => $teams,
            'terminals' => $terminals,
        //  filtered data
            'filters'=>$filters,
            'teamsF'=>$filtered_teams,
            'stationsFM'=>$filtered_stations_modal,
            'teamsFM'=>$filtered_teams_modal,
        ]);
    }


    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'employee_number' => 'required|string|max:255|unique:employees',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'integer|nullable',
            'project_id' => 'integer|nullable',
            'position_id' => 'integer|nullable',
            'station_id' => 'integer|nullable',
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

    public function edit(Request $request, $id){
        $item = Employee::find($id);
        // filtering modal data -------------
        // leaders filtering 
        $leadersQM = Employee::query();
        if ($request->has('positionM')){
            // fetching selected id from request
            $positionM = $request->query('positionM');
            // fetching position id and name for comparison
            // comparing id  to position 1=operator < 2=teamleader < 3=shiftleader < 4=manager
            if($positionM == 1){
                $leadersQM->where('position_id',2);
            }elseif($positionM == 2){
                $leadersQM->where('position_id', 3);
            }else{
                $leadersQM->where('position_id', 4);
            }
        }
        $stationsQM = Station::query();
        $teamsQM = Team::query();
        if ($request->has('projectM')){
            $projectM = $request->query('projectM');
            // Query Modal
            $stationsQM->where('project_id', $projectM);
            $teamsQM->where('project_id', $projectM);
        }
        $filtered_stations_modal = $stationsQM->get();
        $filtered_teams_modal = $teamsQM->get();
        $leaders =  $leadersQM->select('id', 'first_name', 'last_name')->get();

        $departments = Department::select('id', 'name', 'positions')->get();
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
                                //  filtered data
                                'stationsFM'=>$filtered_stations_modal,
                                'teamsFM'=>$filtered_teams_modal,
                            ]);
    }

    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
        'employee_number' => ['required','string', 'max:255',Rule::unique('employees')->ignore($id)],
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'department_id' => 'integer|nullable',
        'project_id' => 'integer|nullable',
        'position_id' => 'integer|nullable',
        'station_id' => 'integer|nullable',
        'team_leader_manager_id' => 'integer|nullable',
        'team_id' => 'integer|nullable',
        'terminal_id' => 'integer|nullable',
        'photo' => 'nullable']);
        // image validation
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $originalFilename = $request->photo->getClientOriginalName();
            $imageName = time() . '_' . str_replace(' ', '_', $originalFilename);
            $request->file('photo')->move(public_path('/employees/'), $imageName);
        } else {
            $imageName = $request->input('photo'); // if no image is uploaded keep the current imagename; 
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

    // absence management

    public function new_absence(Request $request, $id){
        $item = Employee::find($id);
        return Inertia::render('HumanRessources/Employees/absence', 
        ['employee' => $item]);
    }

    public function post_absence(Request $request, $id){
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'start_date' => 'required|date|max:255|after_or_equal:01/01/2022',
            'reason' => 'string|nullable',
            'end_date' => 'required|date|max:255',
        ]);

        $item = new Absence();
        $item->employee_id = $validatedData['id'];
        $item->reason = $validatedData['reason'];
        $item->start_date = $validatedData['start_date'];
        $item->end_date = $validatedData['end_date'];
        $item->save();
        return to_route('employees.show_absences');
    }

    public function show_absences(Request $request){
        $employees = Employee::get();
        $search = $request->input('search');
        $query = Absence::query();
        if($search){
            $employeeId = Employee::where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('last_name', 'LIKE', "%{$search}%")
            ->orWhere('employee_number', 'LIKE', "%{$search}%")->select('id')->first();
            if($employeeId){
                $query->where('employee_id', 'LIKE', "%{$employeeId->id}%");
            }
            $query->orWhere('reason', 'Like', "%{$search}%");
        }
        $items = $query->paginate(10);
        $filters = $request->all();  
        return Inertia::render('HumanRessources/Employees/showAbsence', 
        [
        'employees' => $employees,
        'absences' => $items,
        'filters' => $filters,
        ]);
    }
}
