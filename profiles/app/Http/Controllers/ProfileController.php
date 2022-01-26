<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProfileRequest;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {    
        $role_filter = $request->get('role');

        $users = User::with('profile')->when($role_filter, function($query, $role_filter) {
            return $query->role($role_filter);
        })->orderBy('name', 'asc')->paginate(5);

        $roles = Role::all();

        return view('profiles.index', [
            'users' => $users, 
            'roles' => $roles,
        ]); 
    }

    public function create()
    {
        $roles = Role::all();

        return view('profiles.create', [
            'roles' => $roles,
        ]);
    }

    public function store(CreateProfileRequest $request)
    {
        Profile::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
        ]);

        return redirect()->route('profiles.index')->with('mssg', 'Profile added to database');
    }
    
    public function edit($id)
    {
        $profile = Profile::with('user')->findOrFail($id);
        $user_role = $profile->user->roles->first();
        $auth_id = Auth::id();
        
        $roles = Role::all();

        return view('profiles.edit', [
            'profile' => $profile,
            'user_role' => $user_role,
            'roles' => $roles,
            'auth_id' => $auth_id,
        ]);
    }
    
    public function update($id)
    {   
        $profile = Profile::findOrFail($id); 

        if ($profile->user_id == Auth::id() && 
            !Auth::user()->hasRole(request('role'))) {
            return redirect()->back()->with('mssg', "Not authorized to change own role");
        }

        $profile
            ->addMediaFromRequest(request('prof-img'))
            ->toMediaCollection(); //The current request does not have a file in a key named `test image.png`

        $profile->name = request('name');
        $profile->email = request('email');
        $profile->phone = request('phone');
        $profile->user->removeRole($profile->user->roles->first());
        $profile->user->assignRole(request('role'));
        
        $profile->save();
        
        return redirect()->route('profiles.index')->with('mssg', 'Profile updated succesfully');
    }

    public function destroy($id)
    {
        $user = User::with('profile')->findOrFail($id);

        if ($user->id == Auth::id()) {
            return redirect()->back()->with('mssg', "Can't delete own profile");
        }   

        $user->profile->delete();
        $user->delete();
    
        return redirect()->route('profiles.index');
    }
}
