<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register-admin', [AuthController::class, 'registerAdmin']);

Route::post('/login', function (Request $request) {
    // 1. User ව ඊමේල් එකෙන් හොයනවා
    $user = User::where('email', $request->email)->first();

    // 2. User කෙනෙක් නැත්නම් හෝ Password වැරදිනම් Error එකක් දෙනවා
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid email or password.'], 401);
    }

    // 3. Login සාර්ථක නම් Token එක හදනවා
    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ], 200);
});
