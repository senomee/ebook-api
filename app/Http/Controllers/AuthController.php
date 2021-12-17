<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function me() {
    return ['NIS' => 3103119040,
        'name' => 'Bakti Surya Atmaja',
        'gender' => 'Sigma Male',
        'phone' => '182345678',
        'class' => 'XII RPL 2'];
  }

  // R E G I S T E R
  public function register(Request $request) {
    $fields = $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|unique:users,email',
        'password' => 'required|string|confirmed'
    ]);
    $user = User::create([
        'name' => $fields['name'],
        'email' => $fields['email'],
        'password' => bcrypt($fields['password'])
    ]);
    $token = $user->createToken('myapptoken')->plainTextToken;
    $response = [
        'user' => $user,
        'token' => $token
    ];
    return response($response, 201);
  }

  // L O G I N
  public function login(Request $request) {
      $fields = $request->validate([
          'email' => 'required|string',
          'password' => 'required|string'
      ]);
      $user = User::where('email', $fields['email'])->first();
      if(!$user || !Hash::check($fields['password'], $user->password)) {
          return response([
              'message' => 'Bad creds'
          ], 401);
      }
      $token = $user->createToken('myapptoken')->plainTextToken;
      $response = [
          'user' => $user,
          'token' => $token
      ];
      return response($response, 201);
  }

  // L O G O U T
  public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}