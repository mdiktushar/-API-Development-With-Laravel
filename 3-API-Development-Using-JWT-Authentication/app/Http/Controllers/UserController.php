<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    //POOST
    public function register(UserRequest $request)
    {
        # code...
        $user = $request->all();
        User::create($user);
        $headers = ["Success"];
        return response()->json(['User Created'], 200, $headers);
    }
    // POST
    public function login(Request $request)
    {
        # Validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        
        # Verify user + token
        if ($token = auth()->attempt(['email' => $request->email, "password" => $request->password])) {
            # Loged in Successful
            return response()->json([
                'message' => "Successfully Loged in",
                'access_token' => $token
            ], 200);
        } else {
            # If User is unable to signin
            return response()->json([
                'Invalide Email or Passowrd'
            ], 406);
        }
    }
    // GET
    public function profile(Type $var = null)
    {
        # code...
        $user = auth()->user();
        $data = [
            "message" => "User Profile Data",
            "data" => $user
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        # code...
        $request->validate([
            'name' => "required",
            'email' => "required|email",
            'password' => "required|confirmed"
        ]);
        $data = $request->all();
        User::findOrFail(auth()->user()->id)->update($data);

        return response()->json(['Profile Updated'], 200);
    }
    // GET
    public function logout(Type $var = null)
    {
        # code...
        auth()->logout();
        return response()->json(
            [
                "message"=>"Logged Out"
            ],
            200
        );
    }
}
