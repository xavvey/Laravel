<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();

        return view('profiles.index', ['profiles' => $profiles]);
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store()
    {
        Profile::create([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'role' => request('role')
        ]);

        return redirect("/profiles")->with('mssg', 'Profile added to database');
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect('profiles');
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);

        return view('/profiles/edit', ['profile' => $profile]);
    }

    public function update($id)
    {   
        $profile = Profile::findOrFail($id);

        $profile->name = request('name');
        $profile->email = request('email');
        $profile->phone = request('phone');
        $profile->role = request('role');

        $profile->save();

        return redirect('profiles')->with('mssg', 'Profile updated succesfully');
    }
}
