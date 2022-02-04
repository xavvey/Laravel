<?php

namespace Modules\ProfileManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\ProfileManagement\Entities\Profile;
use App\User;
use Modules\ProfileManagement\Http\Requests\CreateProfileRequest;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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

        return view('profilemanagement::profiles.index', [
            'users' => $users, 
            'roles' => $roles,
        ]); 
    }

    public function create()
    {
        $roles = Role::all();

        return view('profilemanagement::profiles.create', [
            'roles' => $roles,
        ]);
    }

    public function store(CreateProfileRequest $request)
    {
        Profile::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'profile_pic_id' => null,
        ]);

        return redirect()->route('profiles.index')->with('mssg', 'Profile added to database');
    }
    
    public function edit($id)
    {
        $profile = Profile::with('user')->findOrFail($id);
    
        if ((Auth::user()->hasRole('user') && Auth::id() != $profile->user_id)) {
            return redirect()->back()->with('mssg', "Not authorized to edit other profiles");
        }

        $user_role = $profile->user->roles->first();
        $profile_imgs = $profile->getMedia();

        $auth_id = Auth::id();    
        $roles = Role::all();

        return view('profilemanagement::profiles.edit', [
            'profile' => $profile,
            'user_role' => $user_role,
            'profile_imgs' => $profile_imgs,
            'roles' => $roles,
            'auth_id' => $auth_id,
        ]);
    }
    
    public function update(Request $request, $id)
    {   
        $profile = Profile::findOrFail($id); 

        if ($profile->user_id == Auth::id() && 
            !Auth::user()->hasRole(request('role'))) {
            return redirect()->back()->with('mssg', "Not authorized to change own role");
        }

        if ($request->image) {
            $profile->addMediaFromRequest('image')->toMediaCollection(); 
        }
        
        if ($request->role) {
            $profile->user->removeRole($profile->user->roles->first());
            $profile->user->assignRole(request('role'));
        }
            
        if ($request->select_pic) {
            $profile->profile_pic_id = $request->select_pic;
        }
        
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        
        $profile->save();
        
        return redirect()->route('profiles.edit', $profile->id)->with('mssg', 'Profile updated succesfully');
    }

    public function destroy($id)
    {
        $user = User::with('profile')->findOrFail($id);

        if ($user->id == Auth::id() &&
            !Auth::user()->hasRole('admin')) {
            return redirect()->back()->with('mssg', "Can't delete own profile");
        }   

        $user->profile->delete();
        $user->delete();
    
        return redirect()->route('profiles.index');
    }
}
