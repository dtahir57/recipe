<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use App\Http\Requests\ValidateUser;
class AuthController extends Controller
{
    public function __construct() {
      return $this->middleware('auth:api')
                  ->only('logout');
    }

    public function register(ValidateUser $request) {
      $user = new User($request->all());
      $user->password = bcrypt($request->password);
      $user->save();
      return response()->json([
        'register' => true
      ]);
    }

    public function login(Request $request) {
      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|between:6 ,25'
      ]);
      $user = User::where(['email' => $request->email])->first();
      if ($user AND Hash::check($request->password, $user->password)) {
        $user->api_token = str_random(60);
        $user->save();
        return response()->json([
          'authenticated' => true,
          'api_token' => $user->api_token,
          'user_id' => $user->id
        ]);
      }
      return response()->json([
        'email' => ['Provided email and password does not match!']
      ], 422);
    }

    public function logout(Request $request) {
      $user = $request->user();
      $user->api_token = null;
      $user->save();

      return response()->json([
        'logged_out' => true
      ]);
    }
}
