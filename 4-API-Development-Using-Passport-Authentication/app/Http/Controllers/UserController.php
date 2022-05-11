<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        # code...
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed'
        ]);

        User::create($request->all());

        return response()->json(
            [
                'massage' => 'User Created'
            ],
            200
        );
    }
    
    public function login(Request $request)
    {
        # code...
        $request->validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(
                [
                    "message" => "Failed"
                ],
                406
            );
        }
        $token = auth()->user()->createToken('auth_token');

        return response()->json(
            [
                "message" => "Loged in Successfully",
                "token" => $token,
            ],
            200
        );
    }
    public function profile(Type $var = null)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);

        return response()->json(
            [
                "message" => "user profile",
                "data" => $user
            ],
            200
        );
    }
    public function logout(Request $request)
    {
        # get token value
        $token = $request->user()->token();

        # revoke this token value
        $token->revoke();

        return response()->json(
            [
                'message' => 'logout successful'
            ],
            200
        );
    }
}
