<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        // validating if the $search variable is not empty
        if($search){
            $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('role', 'LIKE', "%{$search}%")
            ->get();
        }else{
            $users = User::all();
        }
        return Inertia::render('Users/users', ['users' => $users, 'filter'=>$search]);
    }

    public function create(Request $request){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // creating data
        $user = new User();
        $user->name = $validatedData['name'];
        $user->role = $validatedData['role'];
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];
        $user->save();
        // returning updated data to the form
        return to_route('users.index');
    }

    public function destroy($id){
    // Find the user by id
    $user = User::find($id);

    if (!$user) {
        return to_route('users.index')->with(['message' => 'User not found']);
        // return response()->json(['message' => 'User not found'], 404);
    }
    // Delete the user
    $user->delete();

    return to_route('users.index');
    }
    
    public function update(Request $request, $id){
        // form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);
        // creating data
        $user = User::find($id);
        $user->name = $validatedData['name'];
        $user->role = $validatedData['role'];
        $user->email = $validatedData['email'];
        if($validatedData['password']){
            $user->password = $validatedData['password'];
        }
        $user->save();
        // returning updated data to the form
        return to_route('users.index');
    }

    public function edit($id){
        $user = User::find($id);
        return Inertia::render('Users/edit', ['user' => $user]);
    }
}
