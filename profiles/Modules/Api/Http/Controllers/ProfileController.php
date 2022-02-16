<?php

namespace Modules\Api\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Api\Transformers\Profile as ProfileResource;
use Modules\Api\Transformers\ProfileCollection;
use Modules\ProfileManagement\Entities\Profile;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     *
     */
    public function index()
    {
        $profiles = Profile::with('user')->get();
        return new ProfileCollection($profiles);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::select("id")->where("name", "user")->first();
        $user->roles()->attach($role);

        $user->profile()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        if ($request->profile_pic) {
            $image = $user->profile->addMediaFromRequest('profile_pic')->toMediaCollection();
            $user->profile->profile_pic_id = $image->id;
        }
        
        $user->profile->save();

        return new ProfileResource($user->profile);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Profile $profile) //implicit route model binding
    {
        return new ProfileResource($profile);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $profile->update($request->all());

        return new ProfileResource($profile);
    }



    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        $profile->user->delete();

        return $profile->delete();
    }
}
