<?php

namespace App\Http\Controllers;

use App\Mail\SignupConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function random_str(
        $length,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    function login(Request $req) {
        if ($req->missing('username') && $req->missing('password')) {
            return [['output' => 'username and password is missing.']];
        }
        $username = $req->input('username');
        $password = $req->input('password');
        
        return DB::table('api_datacenter.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
    }

    function signup(Request $req) {
        if ($req->missing('username') && $req->missing('email') && $req->missing('password')) {
            return [['output' => 'username, email or password is missing']];
        }
        $username = $req->input('username');
        $email = $req->input('email');
        $password = $req->input('password');
        
        $random_str = $this->random_str(20);
        $create_user = DB::table('api_datacenter.User')->insertOrIgnore([
            ['username' => "$username", 'user_email' => "$email", 'password' => "$password", 'reset_password_token' => "$random_str"]
        ]);
        if ($create_user > 0) {
            Mail::to("$email")->send(new SignupConfirmation($random_str));
            return [['output' => 'new user created']];
        }
        return [['output' => 'fail to create user']];
    }

    function signup_confirmation(Request $req) {
        if ($req->missing('token')) {
            return [['output' => 'token is missing']];
        }
        $token = $req->input('token');
        $confirm = DB::table('api_datacenter.User')->where('reset_password_token', "$token");
        if (count($confirm) > 0) {
            foreach($confirm as $i) {
                return view('api.signup_succeed', ['username' => "$i->username"]);
            }
        } return [['output' => 'no data found']];
    }
}
