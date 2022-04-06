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
     * @OA\Get(
     *      path="/profiles",
     *      operationId="getProfilesList",
     *      tags={"Profiles"},
     *      summary="Get list of all profiles",
     *      description="gets paginates list of all profiles in database",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     * )
     */
   function index()
    {
//        $profiles = Profile::with('user')->get();
        return new ProfileCollection(Profile::with('user')->get());
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
     * @OA\Get(
     *      path="/profiles/{id}",
     *      operationId="getSingleProfile",
     *      tags={"Profiles"},
     *      summary="Get single profile",
     *      description="Returns a single profile based on ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Profile id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(),
     *       )
     * )
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
        dd($request->get());
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

        // $profile->user->delete();
        $profile->delete();

        return $profile->delete();
    }
}
