<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rumah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Listing;
use Hash;

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

      //   $user->user_status = 'pengguna';
          if($request->hasFile('photo_identitas'))
          {
              $file = $request->file('photo_identitas');
              $extention = $file->getClientOriginalExtension();
              $filename=time().'.'.$extention;
              $file->move('user_photo',$filename);
              $input['photo_identitas']=$filename;
          }


        $input['user_status'] = 'pengguna';
        $user = User::create($input);
        // $user['token'] =  $user->createToken('nApp')->accessToken;


        return ResponseFormatter::success('User Registration Success!', $user);
    }


    public function login(Request $request)
    {
        $no_rumah = Listing::where('no_rumah', $request->no_rumah)->first()->id;
        $rumah = Rumah::where('id', $no_rumah)->first()->id;
        $user = Rumah::where('no_rumah', $no_rumah)->first()->user_id;
        $password_user = User::where('id', $user)->first()->password;
        $pw = Hash::check(request('password'), $password_user);

        if($no_rumah == $rumah && $pw){
            $user_login = User::where('id', $user)->first();
            return ResponseFormatter::success('User Login Success!', $user_login);
        }
        else {
            return ResponseFormatter::failed('User Login Failed!', 401, ['Unauthorized']);
        }
    }


    public function profile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        // dd($user);
        return ResponseFormatter::success('get user profile!', $user);
    }


}
