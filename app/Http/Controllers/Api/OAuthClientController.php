<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;
use Illuminate\Support\Str;

class OAuthClientController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required',
            'redirect' => 'required|url',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $client = new Client();
            $client->user_id = null;
            $client->name = $request->input('name');
            $client->secret = Str::random(40);
            $client->redirect = $request->input('redirect');
            $client->personal_access_client = false;
            $client->password_client = false;
            $client->revoked = false;
            $client->save();
    
            return response()->json([
                'status' => true,
                'client_id' => $client->id,
                'client_secret' => $client->secret,
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong!',
            ], 401);
        }

    }
}