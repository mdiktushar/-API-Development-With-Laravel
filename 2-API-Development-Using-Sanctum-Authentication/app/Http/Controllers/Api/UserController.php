<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Model
use App\Models\User;
use App\Models\UserInformation;

class UserController extends Controller
{
    // Registration API
    public function register(Request $request)
    {
        # validation...

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        User::create($request->all());

        // # Response
        return response()->json(
            ["message" => "Registration Successfull"],
            200
        );
    }

    // Login API
    public function login(Request $request)
    {
        # Validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        $user = User::where('email', "=", $request->email)->first();
        
        if (isset($user->id)) {
            # code...
            if (Hash::check($request->password, $user->password)) {
                # code...
                $token = $user->createToken('auth_token')->plainTextToken;
                
                # response
                return response()->json(
                    [
                        'message'=> 'login successful',
                        'access token' => $token
                    ],
                    200
                );
            } else {
                # password doesnot match
                return response()->json(
                    [
                        'message' => 'password didn\'t match'
                    ],
                    406
                );
            }
        } else {
            # email not found
            return response()->json(
                [
                "message" => "The Email is Not Found"
            ],
                404
            );
        }
    }

    // profile API
    public function profile(Type $var = null)
    {
        # code...
        return response()->json(
            [
                "message" => "Student Profile",
                "data" => auth()->user()
            ],
            200
        );
    }

    // logout API
    public function logout(Type $var = null)
    {
        # code...
        auth()->user()->tokens()->delete();
        return response()->json(
            [
                "message"=>"Logged Out"
            ],
            200
        );
    }
}
