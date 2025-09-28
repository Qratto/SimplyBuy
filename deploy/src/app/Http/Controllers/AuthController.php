<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function register(Request $request){
        
        $validator = Validator::make($request->all(),[
            "fio" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:5|confirmed",
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $errors[$field] = $messages[0]; // Берем первую ошибку для каждого поля
            }

            return response()->json([
                "message" => "Validation error",
                "field" => $errors[$field]
            ], 422);
        }

        $user = User::create([
            "fio" => $request->fio,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "user_token" => $token  
        ], 201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $errors[$field] = $messages[0]; 
            }

            return response()->json([
                "message" => "Validation error",
                "field" => $errors[$field]
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Email not found'
            ], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Incorrect password'
            ], 401);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "user_token" => $token    
        ],200);
    }

    public function profile(Request $request){
        $user = $request->user();

        return response()->json([
            "user" => [
                "id" => $user->id,
                "avatar" => $user->avatar,
                "fio" => $user->fio,
                "email" => $user->email
            ]
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout'
        ], 200);
    }
}
