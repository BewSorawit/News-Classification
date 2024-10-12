<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //Register Api - POST (name , email , password)
    public function register(Request $request){

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
