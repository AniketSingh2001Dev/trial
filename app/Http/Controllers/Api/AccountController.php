<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function signup(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error!',
                'errors' => $validator->errors()->all(),
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully.',
            'user' => $user,
        ], 201);
    }

    public function signin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials!',
                'errors' => $validator->errors()->all(),
            ], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully.',
                'token' => Auth::user()->createToken('auth_token')->accessToken,
                'token_type' => 'bearer',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials!',
            ], 401);
        }
    }

    public function signout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully',
            'user' => $user,
        ], 200);
    }
}