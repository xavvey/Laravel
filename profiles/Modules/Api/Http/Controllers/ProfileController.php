<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ProfileManagement\Entities\Profile;
use Modules\Api\Transformers\ProfileCollection;
use Modules\Api\Transformers\Profile as ProfileResource;

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
        //
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
    public function update(Profile $profile, Request $request)
    {
        $profile = Profile::update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile_pic_id' => $request->select_pic,
        ]);

        return $profile;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
