<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class UserController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
{
    // ตรวจสอบความถูกต้องของข้อมูล
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:8',
        'email'    => 'required|email|unique:users',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // บันทึกข้อมูลลงในฐานข้อมูล
    $user = User::create([
        'username' => $request->input('username'),
        'password' => Hash::make($request->input('password')),
        'email'    => $request->input('email'),
    ]);

    // เตรียมข้อมูลเพื่อบันทึกในไฟล์ JSON
    $result = [
        'message' => 'User registered successfully',
        'user' => [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ],
    ];

    // บันทึกผลลัพธ์ลงในไฟล์ JSON
    $jsonFilePath = storage_path('app/registered_users.json');

    // อ่านไฟล์เก่าและเพิ่มข้อมูลใหม่
    $existingData = [];
    if (File::exists($jsonFilePath)) {
        $existingData = json_decode(File::get($jsonFilePath), true);
    }

    // เพิ่มข้อมูลใหม่ลงในอาเรย์
    $existingData[] = $result;

    // บันทึกไฟล์ JSON
    File::put($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

    return response()->json($result, 201);
}

}

