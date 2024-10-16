<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    //Register Api - POST (name , email , password)
    public function register(Request $request){
        // Validation
        $request->validate([
            "username" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users" ,
            "password"=> "required|string|confirmed|min:8" , # must have in the send massage in html    must have   password_confirmation
            "typer_user_id" => "required|nullable|integer" ,
        ]);

        // User model to save user in database
        User::create([
            "username" => $request->username,
            "email" => $request->email ,
            "password" => bcrypt($request->password),  # bcrypt ไว้ เเบบบส่งไปอ่านไม่ออก store hash password
            "typer_user_id" =>  $request->typer_user_id ?? 4 , # Assuming 1 as default or coming from request

        ]);

        return response() -> json([
            "status" => true ,
            "message" => "User registered successful!!" ,
            "data" => []
        ]);

    }

    //Login Api - POST (email , password)
    public function login(Request $request){

    }

    //Pofile Api  - GET (JWT Auth Token)
    public function profile(){

    }

    //Refresh Token Api - GET (JWT Auth Token)
    public function refreshToken() {

    }

    //Logout API - GET (JWT Auth Token)
    public function logout() {

    }
}
