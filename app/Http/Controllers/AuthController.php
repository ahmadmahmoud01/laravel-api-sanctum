<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $token = $user->createToken('myapptoken')->plainTextToken;

        if($user){

            return response()->json(['status' => 'succes', 'user' => $user, 'token' => $token]);
        }

    }

    public function login(Request $request) {

        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        

        $user = User::where('email', $data['email'])->first();



        $token = $user->createToken('myapptoken')->plainTextToken;

        if($user && Hash::check($data['password'], $user->password)){

            return response()->json(['status' => 'login successfully', 'user' => $user, 'token' => $token]);

        } else {

        }


    }

    public function logout(Request $request) {

        $request->user()->tokens()->delete();

        return ['message' => 'logged out'];

    }
}
