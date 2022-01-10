<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\Http\Requests\CreateProfileRequest;
// use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // dump(); -> like var_dump()
        // dd( ); -> stops when this hits

        $role = $request->get('role');

        $profiles = Profile::when($role, function($query, $role) {
            return $query->where('role', '=', $role);
        })->paginate(5);

        return view('profiles.index', ['profiles' => $profiles]);
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(CreateProfileRequest $request)
    {
        Profile::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'role' => $request->get('role'),
        ]);

        return redirect()->route('profiles.index')->with('mssg', 'Profile added to database');
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profiles.index');
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);

        return view('profiles.edit', ['profile' => $profile]);
    }

    public function update(Request $request ,$id)
    {   
        // $new_data = $request->all();
        
        // $profile = Profile::find($id)->update($new_profile_data);

        $profile = Profile::findOrFail($id);

        $profile->name = request('name');
        $profile->email = request('email');
        $profile->phone = request('phone');
        // $profile->role = request('role');

        $profile->save();

        return redirect()->route('profiles.index')->with('mssg', 'Profile updated succesfully');
    }
}
