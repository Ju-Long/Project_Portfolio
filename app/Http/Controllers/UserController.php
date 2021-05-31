<?php

namespace App\Http\Controllers;

use App\Mail\SignupConfirmation;
use App\Mail\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Config;

class UserController extends Controller
{
    public function random_str( $length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
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
        if ($req->missing('email') && $req->missing('password')) {
            return [['output' => 'email and password is missing.']];
        }
        $email = $req->input('email');
        $password = $req->input('password');

        $user = DB::table('api_datacenter.User')->where([['user_email', "$email"], ['user_password', "$password"]])->get();
        foreach ($user as $i) {
            session(['username' => $i->username, 'password' => $i->user_password, 'user_api_key' => $i->user_api_key]);
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
            ['username' => "$username", 'user_email' => "$email", 'user_password' => "$password", 'reset_password_code' => "$random_str"]
        ]);
        if ($create_user > 0) {
            Mail::to("$email")->send(new SignupConfirmation($random_str));
            return [['output' => 'new user created']];
        }
        return [['output' => 'fail to create user due to username/email already exist']];
    }

    function signup_confirmation(Request $req) {
        if ($req->missing('token')) {
            return [['output' => 'token is missing']];
        }

        $list_api_key = DB::table('api_datacenter.User')->select('user_api_key')->get();
        $new_api_key = random_int(1000000, 9999999);
        while(in_array($new_api_key, $list_api_key, false)) {
            $new_api_key = random_int(1000000, 9999999);
        }

        $token = $req->input('token');
        $confirm = DB::table('api_datacenter.User')->where('reset_password_code', "$token")->get();
        
        if (count($confirm) > 0) {
            foreach($confirm as $i) {
                DB::table('api_datacenter.User')->where('username', $i->username)->update(['user_api_key' => $new_api_key, 'reset_password_code' => null]);
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

    function generate_code(Request $req) {
        $six_digit_random_number = random_int(100000, 999999);
        Mail::to($req->email)->send(new ForgetPassword($six_digit_random_number));
        session(['pin' => $six_digit_random_number]);
        return;
    }

    function confirm_pin(Request $req) {
        if (!$req->session()->has('pin')) {
            return [['output' => 'pin is not generated']];
        }
        $pin = $req->session()->get('pin');
        $enteredpin = $req->input('pin');
        if ($pin == $enteredpin) {
            return [['output' => 'same']];
        }
        return [['output' => 'not same']];
    }

    function update_password(Request $req) {
        if ($req->missing('email') && $req->missing('password') && $req->missing('pin')) {
            return [['output' => 'email and password is missing']];
        }
        $email = $req->input('email');
        $password = $req->input('password');

        if ($req->input('pin') != $req->session()->get('pin')) {
            return 2;
        }

        return DB::table('api_datacenter.User')->where('user_email', "$email")->update(['user_password' => "$password"]);
    }

    function dashboard(Request $req) {
        if ($req->session()->has('username')) {
            return view('api.main', ['username' => $req->session()->get('username')]);
        } 
        return redirect('/api/dashboard/auth');
    }

    function get_user_api_calls(Request $req) {
        date_default_timezone_set("Singapore");
        $date = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );

        if (!$req->session()->has('user_api_key')) {
            return [['output' => 'session not found']];
        }

        $user_acc_key = $req->session()->get('user_api_key');
        return DB::table('api_datacenter.IP_Address_Calls')->where([['day', '>', $date], ['user_api_key', $user_acc_key]])->get();
    }

    // function delete_api_calls(Request $req) {
    //     $password = $req->input('password');
    //     date_default_timezone_set("Singapore");
    //     $previousMonth = date('Y-m-d', strtotime(time(), ' -3 month'));

    //     if ($password == config('private_password')) {
    //         return DB::table('api_datacenter.IP_Address_Calls')->where('day', '<', "$previousMonth")->delete();
    //     }
    //     return [['output' => 'wrong password']];
    // }

    function website(Request $req) {
        $acc_key = config("value.website_acc_key", '');
        $username = config("value.website_username", '');
        if ($req->missing('type')) {
            return [['output' => 'Invalid Input Given']];
        }
        $type = $req->input('type');
        switch ($type) {
            case "get_nearest_bus_stop": 
                $lat = $req->input('lat');
                $long = $req->input('long');
                $url = "https://babasama.com/api/get_nearest_bus_stop?accountkey=$acc_key&username=$username&Latitude=$lat&Longitude=$long&amount=5";
                return json_decode(file_get_contents($url), true);
            case "get_bus_arrival_time":
                $busstopcode = $req->input('BusStopCode', 54201);
                $url = "https://babasama.com/api/get_bus_arrival_timing?BusStopCode=$busstopcode&accountkey=$acc_key&username=$username";
                return json_decode(file_get_contents($url), true);
            case "get_bus_route":
                $busnumber = $req->input('ServiceNo', 88);
                $url = "https://babasama.com/api/get_bus_route?ServiceNo=$busnumber&accountkey=$acc_key&username=$username";
                return json_decode(file_get_contents($url), true);
            case "get_bus_stop_data":
                $busstopcode = $req->input('BusStopCode', 54201);
                $url = "https://babasama.com/api/get_bus_stop_data?BusStopCode=$busstopcode&username=$username&accountkey=$acc_key";
                return json_decode(file_get_contents($url), true);
            case "get_bus_data":
                $busnumber = $req->input('ServiceNo', 88);
                $url = "https://babasama.com/api/get_bus_data?ServiceNo=$busnumber&username=$username&accountkey=$acc_key";
                return json_decode(file_get_contents($url), true);

            default: 
                return [['output' => 'Invalid Input Given']];
        }
    }
}
