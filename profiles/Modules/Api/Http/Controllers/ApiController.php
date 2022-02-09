<?php

namespace Modules\Api\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ProfileManagement\Entities\Profile;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return Profile::all();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('api::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $profile = Profile::with('user')->findOrFail($id);

        return $profile;
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('api::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id)
            ->update([
                'profile_pic_id' => $request->select_pic,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

        return $profile;
        // $profile = Profile::findOrFail($id);

        // $profile->profile_pic_id = $request->select_pic;
        // $profile->name = $request->name;
        // $profile->email = $request->email;
        // $profile->phone = $request->phone;

        // $profile->save();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $user = User::with('profile')->findOrFail($id);

        if ($user->id == Auth::id() &&
            !Auth::user()->hasRole('admin')) {
            return redirect()->back()->with('mssg', "Can't delete own profile");
        }   

        $user->profile->delete();
        $user->delete();

        return $user;
    }
}
