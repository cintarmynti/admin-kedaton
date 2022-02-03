<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseFormatter;
use Validator;


class UserController extends Controller
{

    private function checkEmailExists($email)
    {
        return User::where('email', $email)->first();
    }

    private function checkUsernameExists($name)
    {
        return User::where('name', $name)->first();
    }

    private function checkNikExists($nik)
    {
        return User::where('nik', $nik)->first();
    }

    public function register(Request $request)
    {
      $input = $request->all();

      $validator = Validator::make($input, [
          'nik' => 'required',
          'name' => 'required',
          'alamat' => 'required',
          'phone' => 'required',
          'email' => 'required|email',
          // 'password' => 'required',
          // 'c_password' => 'required|same:password',
      ]);

      if ($validator->fails()) {
          return ResponseFormatter::failed('User Registration Failed!', 401, $validator->errors());
      }

      if ($this->checkNikExists($input['nik'])) {
          return ResponseFormatter::failed('User nik Already Exists!', 409, $validator->errors());
      }

      if ($this->checkUsernameExists($input['name'])) {
          return ResponseFormatter::failed('User name Already Exists!', 409, $validator->errors());
      }

      if ($this->checkEmailExists($input['email'])) {
          return ResponseFormatter::failed('User Email Already Exists!', 409, $validator->errors());
      }


      $input['photo'] = null;
      $input['user_status'] = 'pengguna';
      $user = User::create($input);
    //   $user['token'] =  $user->createToken('nApp')->accessToken;

      return ResponseFormatter::success('User Registration Success!', $user);
    }

  public function index()
  {
      $user = User::all();
      return ResponseFormatter::success('berhasil menyimpan user kelas Success!', $user);
  }

  public function login()
  {

  }



}
