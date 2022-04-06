<?php

namespace Modules\Api\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Api\Transformers\User as UserResource;
use Modules\Api\Transformers\UserCollection;

class UserTestController extends Controller
{
    /**
     * @OA\Get(
     *      path="/usersprofiles",
     *      operationId="getUsersWithProfilesList",
     *      tags={"Users"},
     *      summary="Get list of all users with corresponding profile",
     *      description="gets paginates list of all users in database with corresponding profile",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     * )
     */
    public function index()
    {
//        $users = User::with('profile')->get();
        return new UserCollection(User::with('profile'));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $userProfiles = $user->with('profile')->get();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
