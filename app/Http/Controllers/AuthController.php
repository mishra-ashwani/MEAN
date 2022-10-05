<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(LoginFormRequest $request)
    {
        $request->validated($request->all()); 
        
        if(!Auth::attempt($request->only('email','password'))){
            return $this->fail('','Invalid Credentials',401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Demo App')->plainTextToken
        ], 'Logged In Successfully');
    }
    public function register(StoreUserRequest $request)
    {

        $request->validated($request->all());

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Demo App')->plainTextToken
        ],'User Created Successfully');
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

    }
}
