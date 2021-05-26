<?php

namespace App\Http\Controllers;

use App\Mail\SignupConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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
        if (Cache::has('username') && Cache::has('password')) {
            return redirect('/api/dashboard');
        }
        if ($req->missing('email') && $req->missing('password')) {
            return [['output' => 'email and password is missing.']];
        }
        $email = $req->input('email');
        $password = $req->input('password');

        $user = DB::table('api_datacenter.User')->where([['user_email', "$email"], ['user_password', "$password"]])->get();
        foreach ($user as $i) {
            session(['username' => $i->username, 'password' => $i->user_password], ['user_api_key' => $i->user_api_key]);
        }
        return $user;
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
            ['username' => "$username", 'user_email' => "$email", 'user_password' => "$password", 'reset_password_token' => "$random_str"]
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
        $confirm = DB::table('api_datacenter.User')->where('reset_password_token', "$token")->get();
        if (count($confirm) > 0) {
            foreach($confirm as $i) {
                session(['username' => $i->username, 'password' => $i->user_password]);
                return view('api.signup_succeed', ['username' => "$i->username"]);
            }
        } return [['output' => 'no data found']];
    }

    function signout(Request $req) {
        Cache::flush();
        $req->session()->forget(['username', 'password']);
        return redirect('/api/dashboard');
    }

    function test(Request $req) {
        return Cache::forever('username', 'JohnDoe');
    }

    function dashboard(Request $req) {
        if ($req->session()->has('username')) {
            return view('api.main', ['username' => $req->session()->get('username')]);
        }
        return redirect('/api/dashboard/auth');
    }

    function get_user_api_calls(Request $req) {
        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $previousMonth = (($currMonth - 1) == 0) ? 12 : $currMonth - 1;

        if ($req->missing('accountkey')) {
            return [['output' => 'token is missing']];
        }

        $user_acc_key = $req->session()->get('user_api_key');
        return DB::table('api_datacenter.IP_Address_Calls')->where([['month', $currMonth], ['month', $previousMonth], ['user_api_key', $user_acc_key]])->get();
    }

    function delete_api_calls(Request $req) {
        $password = $req->input('password');
        date_default_timezone_set("Singapore");
        $previousMonth = date('Y-m-d', strtotime(time(), ' -3 month'));

        if ($password == config('private_password')) {
            return DB::table('api_datacenter.IP_Address_Calls')->where('day', '<', "$previousMonth")->delete();
        }
        return [['output' => 'wrong password']];
    }
}
