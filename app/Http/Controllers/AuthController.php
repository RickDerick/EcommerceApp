<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For handling authentication


class AuthController extends Controller
{
    public function register(Request $request){
       $request->validate([
        'name'=>'required|string|max:255',
        'email'=>'required|string|max:255|unique:users',
        'password'=>'required|string|min:8',
       ]);
    
     $user = User::create([
        'name'=> $request->name,
        'email'=> $request->email,
        'password'=>bcrypt($request->name)
     ]);

    return response()->json(['user'=>$user],201);

}
 public function login(Request $request){
    $request->validate([
        'email' => 'required|string|email', // Email must be a string, a valid email and it is required
        'password' => 'required|string', // Password must be a string and it is required
    ]);
    if(!Auth::attempt($request->only('email', 'password'))){
        return response()->json(['message'=>'Invalid login details'], 401);
    }
    $user=$request->user();
    $token= $user->createToken('authToken')->plainTextToken;
    return response()->json(['user'=>$user,'token'=>$token]);
 }

 public function logout(Request $request){
    $request->user()->tokens()->delete();
    return response()->json(['message'=>'Logged out']);

 }

}
