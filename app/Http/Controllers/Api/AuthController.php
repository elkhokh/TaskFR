<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(LoginRequest $request)
    {
    //dd(sanctum());
// attemp method to check if the user is logged in it depende on credentials like email and password 
// if the user is logged in it will return true else false 
        try {

            $request->validate([
                'email' => "required|email",
                "password" => "required"
            ]);

        //    $user = User::where('email', $request->email)->first();
        // // dd($user);
        //     if (!$user || !Hash::check($request->password, $user->password)) {
        //         return ApiResponse::error('credentials error', [], 401);
        //     }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ApiResponse::error('credentials error', [], 401);
            }
            $user = Auth::user();
            $token = $user->createToken("api-token")->plainTextToken; //HasApiTokens
            return ApiResponse::success([
                'token' => $token,
                'user' => [
                    // 'id' => $user->id,
                    'name' => $user->name,
                ],
            ], 'login successfuly');
        } catch (\Throwable $th) {
            Log::channel("Posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("login failed  ", [], 500);
        }
    }
    
    // ************************ logout api *****************************

    public function logout(Request $request)
    {
        try {
            // dd($request->user);
            $request->user()->tokens()->delete();                  //delete from all browser
            // $request->user()->currentAccessToken()->delete();   //delete form one browser
            return ApiResponse::success([], "logged out successfully ");
        } catch (\Throwable $th) {
            Log::channel("Posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("login failed  ", [], 500);
        }
    }
    
    // ************************ register api *****************************

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken("api-token")->plainTextToken;

            return ApiResponse::success([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 'User registered successfully', 201);

        } catch (\Throwable $th) {
            Log::channel("Posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("Registration failed", [], 500);
        }
    }

}
