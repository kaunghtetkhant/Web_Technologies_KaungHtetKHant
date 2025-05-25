<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Classes\ApiResponseClass;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request){

         $registerUserData = $request->validate([
            'name'=>'required|string',
            'username'=>'required|string|unique:customers,username',
            'password'=>'required|min:8',
             'address' => 'required|min:10|max:100'
        ]);


        $user = Customer::create([
            'name' => $registerUserData['name'],
            'username' => $registerUserData['username'],
            'password' => Hash::make($registerUserData['password']),
            'address' => $registerUserData['address'],
        ]);

        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return ApiResponseClass::sendResponse(['user' => [
            'name' => $user->name,
            'username' => $user->username,
            'address' => $user->address
        ], 'token' => $token], 'User created successfully');


    }

    public function login(Request $request){
        $registerUserData = $request->validate([
            'username'=>'required|exists:customers,username',
            'password'=>'required|min:8'
        ]);
        try{
            $credientails = $request->only('username', 'password');
            if(Auth::guard('customer')->attempt($credientails)){
            $user = Auth::guard('customer')->user();
            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
            return ApiResponseClass::sendResponse(['user' => [
                'name' => $user->name,
                'username' => $user->name,
            ], 'token' => $token], 'Login is successful!');
        }

        }catch(\Exception $e){

            return response()->json(['error'=>'Email or password incorrect'], 401);

        }


    }

    public  function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message"=>"logged out"
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $user = \Auth::user();
        if($request->password)
        {
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name ?? $user->name;
        $user->username = $request->username ?? $user->username;
        $user->address = $request->address ?? $user->password;

        $user->save();

        return ApiResponseClass::sendResponse([
            'name' => $user->name,
            'username' => $user->username,
            'address' => $user->address
        ], 'User Profile Updated!');

    }
}
