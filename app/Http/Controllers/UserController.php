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
            session(['user_id' => $i->user_id, 'username' => $i->username, 'password' => $i->user_password, 'user_api_key' => $i->user_api_key, 'email' => $i->user_email]);
            $datamall_api = DB::table('api_datacenter.User_API_Keys')->where('user_api_key', $i->user_api_key)->get();
            foreach ($datamall_api as $n) {
                session(['datamall_api' => $n->datamall]);
            }
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
            ['username' => "$username", 'user_email' => "$email", 'user_password' => "$password", 'user_role' => 'client', 'reset_password_code' => "$random_str"]
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
        $api_keys =[];
        $new_api_key = random_int(100000, 999999);
        foreach ($list_api_key as $i) {
            array_push($api_keys, $i->user_api_key);
        }
        while(in_array($new_api_key, $api_keys, false)) {
            $new_api_key = random_int(100000, 999999);
        }

        $token = $req->input('token');
        $confirm = DB::table('api_datacenter.User')->where('reset_password_code', "$token")->get();
        
        if (count($confirm) > 0) {
            foreach($confirm as $i) {
                DB::table('api_datacenter.User')->where('username', $i->username)->update(['user_api_key' => $new_api_key, 'reset_password_code' => null]);
                DB::table('api_datacenter.User_API_Keys')->insert(['user_api_key' => $new_api_key]);
                session(['user_id' => $i->user_id, 'username' => $i->username, 'password' => $i->user_password, 'user_api_key' => $i->user_api_key, 'email' => $i->user_email]);
                $datamall_api = DB::table('api_datacenter.User_API_Keys')->where('user_api_key', $i->user_api_key)->get();
                foreach ($datamall_api as $n) {
                    session(['datamall_api' => $n->datamall]);
                }
                return view('api.main', ['username' => $req->session()->get('username'), 'email' => $req->session()->get('email'), 'password' => $req->session()->get('password'), 'user_api_key' => $req->session()->get('user_api_key'), 'datamall_api' => $req->session()->get('datamall_api')]);
            }
        } return [['output' => 'no data found']];
    }

    function signout(Request $req) {
        Cache::flush();
        $req->session()->forget(['username', 'password', 'user_api_key', 'datamall_api', 'user_id']);
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
            return view('api.main', ['username' => $req->session()->get('username'), 'email' => $req->session()->get('email'), 'password' => $req->session()->get('password'), 'user_api_key' => $req->session()->get('user_api_key'), 'datamall_api' => $req->session()->get('datamall_api')]);
        } 
        return redirect('/api/dashboard/auth');
    }

    function get_user_api_calls_by_day(Request $req) {
        date_default_timezone_set("Singapore");
        $date = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ));

        if (!$req->session()->has('user_api_key')) {
            return [['output' => 'session not found']];
        }

        $user_acc_key = $req->session()->get('user_api_key');
        return DB::table(DB::raw('api_datacenter.IP_address_calls IPAC'))->join(DB::raw('api_datacenter.IP_address_call_date IPACD'), 'IPAC.ip_id', '=', 'IPACD.ip_id')->where([['IPAC.user_api_key', $user_acc_key], ['date_of_calling', '>', "$date"]])->select('IPACD.*')->get();
    }

    function get_user_api_calls_by_ip_address(Request $req) {
        date_default_timezone_set("Singapore");
        $date = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ));

        if (!$req->session()->has('user_api_key')) {
            return [['output' => 'session not found']];
        }

        $user_acc_key = $req->session()->get('user_api_key');
        return DB::table(DB::raw('api_datacenter.IP_address_calls IPAC'))->select(DB::raw('ip_address, count(*) as count'))->join(DB::raw('api_datacenter.IP_address_call_date IPACD'), 'IPAC.ip_id', '=', 'IPACD.ip_id')->where([['IPAC.user_api_key', $user_acc_key], ['date_of_calling', '>', "$date"]])->groupBy('IPAC.ip_address')->get();
    }

    function update_user_cred(Request $req) {
        if ($req->has('username')) {
            $username = $req->input('username');

            return DB::table('api_datacenter.User')->where('user_id', $req->session()->get('user_id'))->update(['username' => $username]);
        } else if ($req->has('email')) {
            $email = $req->input('email');

            return DB::table('api_datacenter.User')->where('user_id', $req->session()->get('user_id'))->update(['user_email' => $email]);
        } else if ($req->has('password')) {
            $password = $req->input('password');

            return DB::table('api_datacenter.User')->where('user_id', $req->session()->get('user_id'))->update(['user_password' => $password]);
        } else if ($req->has('datamall')) {
            $datamall = $req->input('datamall');

            return DB::table('api_datacenter.User_API_Keys')->where('user_api_key', $req->session()->get('user_api_key'))->update(['datamall' => $datamall]);
        }
        return [['output' => 'no data entered']];
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
        $url = "";
        $account_key = config("value.private_api_key", '');
        if ($req->missing('type')) {
            return [['output' => 'Invalid Input']];
        }
        $type = $req->input('type');
        switch ($type) {
            case "get_nearest_bus_stop": 
                $lat = $req->input('lat');
                $long = $req->input('long');
                $url = "http://babasama.me/get_nearest_bus_stop/$lat/$long/5";
            case "get_bus_arrival_time":
                $busstopcode = $req->input('BusStopCode', 54201);
                url = "http://babasama.me/get_bus_arrival/$busstopcode";
            case "get_bus_route":
                $busnumber = $req->input('ServiceNo', 88);
                $url = "http://babasama.me/get_bus_route/$busnumber";
            case "get_bus_stop_data":
                $busstopcode = $req->input('BusStopCode', 54201);
                $url = "http://babasama.me/get_bus_stop_data/$busstopcode";
            case "get_bus_data":
                $busnumber = $req->input('ServiceNo', 88);
                $url = "http://babasama.me/get_bus_data/$busnumber";

            default: 
                return [['output' => 'Invalid Input Given']];
        }
        return $url;
        $result = Http::withHeaders([
            'api_key' => $account_key
        ])->get($url);
        return json_decode($result);
    }
}
