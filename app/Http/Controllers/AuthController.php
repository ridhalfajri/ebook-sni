<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index_login(){
        return view('frontend.auth.login');
    }
    public function index_register(){
        return view('frontend.auth.register');
    }
    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        flash()->success('User registered successfully.');
        return response()->json(['message' => 'User registered successfully.'], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        if (Auth::user()->role == User::USER){
            $redirect = route('home');
        }elseif(Auth::user()->role == User::ADMIN){
            $redirect = route('dashboard.index');
        }
        return response()->json(['message' => 'Login successful','redirect'=>$redirect], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        flash()->success('Logged out successfully.');
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
