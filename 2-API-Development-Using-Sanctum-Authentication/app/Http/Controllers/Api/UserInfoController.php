<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model
use App\Models\User;
use App\Models\UserInformation;

// Request
use App\Http\Requests\UserInfoRequest;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return response()->json(
            [
                "message" => "List of Users",
                "users" => $users
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserInfoRequest $request)
    {
        // Findeing user
        $user = User::findOrFail(auth()->user()->id);
        try {
            //code...
            $user->userInformation()->create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(
                [
                    "message" => $th
                ],
                406
            );
        }
        #Response
        return response()->json(
            [
                'massage'=>'Information Saved'
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::findOrFail($id);
        $user->userInformation;
        return response()->json(
            [
                "message" => "user profile",
                "data" => $user
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserInfoRequest $request)
    {
        User::findOrFail(auth()->user()->id)
            ->userInformation()
            ->update($request->all());
    
        return response()->json(
            [
                "message" => "information updated"
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        UserInformation::where("user_id", auth()->user()->id)->delete();
        return response()->json(
            [
                "message"=>"user info deleted"
            ],
            200
        );
    }
}
