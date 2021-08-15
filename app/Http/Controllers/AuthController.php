<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register
    public function register(Request $request) {
        // Validate Field
        $fields = $request -> validate([
            'fullname'=> 'required|string',
            'username'=> 'required|string',
            'email'=> 'required|string|unique:users,email',  //แปลว่าให้ unique จากตาราง users ห้ามemail ซ้ำ
            'password'=> 'required|string|confirmed', // แปล confirmed คือ ให้กรอก email 2 ครั้ง
            'tel'=> 'required|string',
            'role'=> 'required|integer',
        ]);

        $user = User::create([
            'fullname'=> $fields['fullname'],
            'username'=> $fields['username'],
            'email'=> $fields['email'],
            'password'=> bcrypt($fields['password']),
            'tel'=> $fields['tel'],
            'role'=> $fields['role'],
        ]);

        // Create token ต้องระบุว่าอุปกรณ์อะไร device-name และ role 
        // $token = $user->createToken('device-name','role');
        // $token = $user->createToken('my-device')->plainTextToken;
        $token = $user->createToken($request->userAgent(), ["$user->role"])->plainTextToken; 

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    // Login
    public function login(Request $request) {

        // Validate field
        $fields = $request->validate([
            'email'=> 'required|string',
            'password'=>'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid login'
            ]);
        }else{
            
            // ลบ token เก่าออกแล้วต่อยสร้างใหม่
            $user->tokens()->delete();

            // Create token
            // $token = $user->createToken('my-device')->plainTextToken;
            $token = $user->createToken($request->userAgent(), ["$user->role"])->plainTextToken;  //ตรวจสอบชื่อ
    
            $response = [
                'user' => $user,
                'token' => $token
            ];
    
            return response($response, 201);
        }
    }

    // Logout
    public function logout(Request $request) {
        auth()->user()->tokens()->delete(); // ทำการลบ tokens ใน table user 
        return [
            'message' => 'Logged out'
        ];
    }
}
