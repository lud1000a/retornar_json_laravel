<?php
namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        
        $user=User::where('email', $request->email)->first(); 
        if(!$user || !Hash::check($request->password, $user->password)){ 
            throw Validator::withMessages([
                'email' => ['The provided credentials are incorrect'],
            ]);
        }

        $user->tokens()->delete();

        $token= $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token, 
        ]);    
    }
}

