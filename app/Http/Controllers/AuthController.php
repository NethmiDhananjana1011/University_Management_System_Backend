<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerAdmin(Request $request)
    {
        // 1. එවන Data ටික හරිද කියලා check කිරීම (Validation)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. User ව Database එකට save කිරීම
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Spatie හරහා Admin role එක ලබා දීම
        $user->assignRole('admin');

        // 4. API Token එකක් හැදීම (Frontend එකට Login වෙන්න)
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. සාර්ථකයි කියලා Frontend එකට JSON response එකක් යැවීම
        return response()->json([
            'message' => 'Admin successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}