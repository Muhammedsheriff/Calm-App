<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    $token = auth()->login($user);

    return $user;
  }
  public function login(Request $request)
  {
    $email = $request->input('email');
    $password = $request->input('password');
    if (Auth::attempt(['email' => $email, 'password' => $password])){
      $user =  User::where('email', $email)->first();
      return response()->json([
                'data' => $user,
                'status' => 200]
             , 200);
    }
    return response()->json([
              'data' => "Wrong Email or Password",
              'status' => 200]
           , 200);

  }
}
