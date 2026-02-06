<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthTokensController extends Controller
{

    //this function is using to showing how may devices is use logined by this account
    public function index(Request $request)
    {
        return $request->user()->tokens;
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
            'device_name' => ['required'],
            // 'permissions' => 'array',
            'fcm_token' => 'nullable'
        ]);

        // check if the data is true
        // Auth::validate($request->only('email', 'password'));
        $user = User::where('email', '=', $request->email)->first();
        if ($user && Hash::check(value: $request->password, hashedValue: $user->password)) {
            // [*] : that mean the token have all permissions
            $token = $user->createToken($request->device_name, ['project.create', 'project.update'], $request->fcm_token);
            return Response::json([
                'token' => $token->plainTextToken,
                'user' => $user
            ], 201);
        }

        return Response::json([
            'message' => 'Invalied Credentials'
        ], 401);
    }
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();

        // return $user->currentAccessToken(); // return the token is used to execute this route/operation
        // $user->currentAccessToken()->delete(); // logout from current token is used

        $user->tokens()->findOrFail($id)->delete();

        // $user->tokens()->delete(); // Logout From All Device!

        return Response::json(['message' => 'Token is Deleted']);
    }
}
