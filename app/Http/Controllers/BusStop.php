<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Config;

class BusStop extends Controller
{
    function get_nearest_bus_stop(Request $req) {
        $account_key = config("value.private_api_key", '');
        if ($req->missing('Latitude') && $req->missing('Longitude') && $req->input('amount') < 1) {
            return [['output' => 'Invalid Parameters']];
        }
        $client_ip = $req->ip();
        $lat = $req->input('Latitude');
        $long = $req->input('Longitude');
        $amountReturned = $req->input('amount');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        $url = "http://babasama.me/get_nearest_bus_stop/$lat/$long/$amountReturned";

        if ($req->missing('username') && $req->missing('accountkey')) {
            $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => null]])->get();
            if (empty($ip_data)) {
                $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => null]);
                DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
            } else {
                foreach($ip_data as $i) {
                    $id = $i->ip_id;
                }
            }
            $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_called > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', $currDay]])->increment('times_called', 1);

            $result = Http::withHeaders([
                'api_key' => $account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            error_log($result);
            return json_decode($result);
        } else {
            $user_acc_key = $req->input('accountkey');
            $username = $req->input('username');
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();
            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => $user_acc_key]])->get();
                    if (empty($ip_data)) {
                        $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => $user_acc_key]);
                        DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
                    } else {
                        foreach($ip_data as $i) {
                            $id = $i->ip_id;
                        }
                    }
                    $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
                    foreach($datas as $i) {
                        if ($i->times_called > 300) {
                            return [['output' => 'You use this IP address to call the data too many times, please call again another day']];
                        }}}

                    DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->increment('times_called', 1);

                    $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                    foreach($datamall_key as $n) {

                        $result = Http::withHeaders([
                            'api_key' => $n->datamall
                        ])->get($url);

                        if ($result->serverError()) {
                            return [['output' => "Server Error"]];
                        } else if ($result->clientError()) {
                            return [['output' => "Client Error"]];}

                    return json_decode($result); }}

        } return [['output' => 'no value found']]; }

    function get_bus_arrival_timing(Request $req) {
        $account_key = config("value.private_api_key", '');
        if ($req->missing('BusStopCode')) {
            return [['output' => 'Invalid Parameters']];
        }
        $client_ip = $req->ip();
        $busstopcode = $req->input('BusStopCode');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        $url = "http://babasama.me/get_bus_arrival/$busstopcode";

        if ($req->missing('username') && $req->missing('accountkey')) {
            $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => null]])->get();
            if (empty($ip_data)) {
                $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => null]);
                DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
            } else {
                foreach($ip_data as $i) {
                    $id = $i->ip_id;
                }
            }
            $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_called > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', $currDay]])->increment('times_called', 1);

            $result = Http::withHeaders([
                'api_key' => $account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $user_acc_key = $req->input('accountkey');
            $username = $req->input('username');
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $$ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => $user_acc_key]])->get();
                    if (empty($ip_data)) {
                        $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => $user_acc_key]);
                        DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
                    } else {
                        foreach($ip_data as $i) {
                            $id = $i->ip_id;
                        }
                    }
                    $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
                    foreach($datas as $i) {
                        if ($i->times_called > 300) {
                            return [['output' => 'You use this IP address to call the data too many times, please call again another day']];
                        }}}

                    DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->increment('times_called', 1);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $n) {
                    $result = Http::withHeaders([
                        'api_key' => $n->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }}

        } return [['output' => 'no value found']]; }

    function get_bus_route(Request $req) {
        $account_key = config("value.private_api_key", '');
        if ($req->missing('ServiceNo')) {
            return [['output' => 'Invalid Paramters']];
        }
        $client_ip = $req->ip();
        $serviceno = $req->input('ServiceNo');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        $url = "http://babasama.me/get_bus_route/$serviceno";

        if ($req->missing('username') && $req->missing('accountkey')) {
            $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => null]])->get();
            if (empty($ip_data)) {
                $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => null]);
                DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
            } else {
                foreach($ip_data as $i) {
                    $id = $i->ip_id;
                }
            }
            $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_called > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', $currDay]])->increment('times_called', 1);

            $result = Http::withHeaders([
                'api_key' => $account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $user_acc_key = $req->input('accountkey');
            $username = $req->input('username');
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => $user_acc_key]])->get();
                    if (empty($ip_data)) {
                        $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => $user_acc_key]);
                        DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
                    } else {
                        foreach($ip_data as $i) {
                            $id = $i->ip_id;
                        }
                    }
                    $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
                    foreach($datas as $i) {
                        if ($i->times_called > 300) {
                            return [['output' => 'You use this IP address to call the data too many times, please call again another day']];
                        }}}

                    DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->increment('times_called', 1);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $n) {
                    $result = Http::withHeaders([
                        'api_key' => $n->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }}

        } return [['output' => 'no value found']]; }

    function search_bus(Request $req) {
        $account_key = config("value.private_api_key", '');
        if ($req->missing('ServiceNo')) {
            return [['output' => 'Invalid Parameters']];
        }
        $client_ip = $req->ip();
        $serviceno = $req->input('ServiceNo');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        $url = "http://babasama.me/get_bus_data/$serviceno";

        if ($req->missing('username') && $req->missing('accountkey')) {
            $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => null]])->get();
            if (empty($ip_data)) {
                $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => null]);
                DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
            } else {
                foreach($ip_data as $i) {
                    $id = $i->ip_id;
                }
            }
            $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_called > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', $currDay]])->increment('times_called', 1);

            $result = Http::withHeaders([
                'api_key' => $account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $user_acc_key = $req->input('accountkey');
            $username = $req->input('username');
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => $user_acc_key]])->get();
                    if (empty($ip_data)) {
                        $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => $user_acc_key]);
                        DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
                    } else {
                        foreach($ip_data as $i) {
                            $id = $i->ip_id;
                        }
                    }
                    $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
                    foreach($datas as $i) {
                        if ($i->times_called > 300) {
                            return [['output' => 'You use this IP address to call the data too many times, please call again another day']];
                        }}}

                    DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->increment('times_called', 1);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $n) {

                    $result = Http::withHeaders([
                        'api_key' => $n->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }}

        } return [['output' => 'no value found']]; }

    function get_bus_stop(Request $req) {
        $account_key = config("value.private_api_key", '');
        if ($req->missing('BusStopCode')) {
            return [['output' => 'Invalid Parameters']];
        }
        $client_ip = $req->ip();
        $busstopcode = $req->input('BusStopCode');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        $url = "http://babasama.me/get_bus_stop_data/$busstopcode";

        if ($req->missing('username') && $req->missing('accountkey')) {
            $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => null]])->get();
            if (empty($ip_data)) {
                $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => null]);
                DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
            } else {
                foreach($ip_data as $i) {
                    $id = $i->ip_id;
                }
            }
            $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_called > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', $currDay]])->increment('times_called', 1);

            $result = Http::withHeaders([
                'api_key' => $account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $user_acc_key = $req->input('accountkey');
            $username = $req->input('username');
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $ip_data = DB::table('api_datacenter.IP_address_calls')->where([['ip_address', "$client_ip"], ['user_api_key' => $user_acc_key]])->get();
                    if (empty($ip_data)) {
                        $id = DB::table('api_datacenter.IP_address_calls')->insertGetId(['ip_address' => "$client_ip", 'user_api_key' => $user_acc_key]);
                        DB::table('api_datacenter.IP_address_call_date')->insert(['ip_id' => $id, 'date_of_calling' => "$currDay"]);
                    } else {
                        foreach($ip_data as $i) {
                            $id = $i->ip_id;
                        }
                    }
                    $datas = DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->get();
                    foreach($datas as $i) {
                        if ($i->times_called > 300) {
                            return [['output' => 'You use this IP address to call the data too many times, please call again another day']];
                        }}}

                    DB::table('api_datacenter.IP_address_call_date')->where([['ip_id', $id], ['date_of_calling', "$currDay"]])->increment('times_called', 1);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $n) {

                    $result = Http::withHeaders([
                        'api_key' => $n->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }}

        } return [['output' => 'no value found']]; }
}
