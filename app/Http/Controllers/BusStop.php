<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BusStop extends Controller
{

    private $account_key = "We/4SNhISV+moxrLY/BVrw==";

    function get_nearest_bus_stop(Request $req) {
        $user_acc_key = $req->input('accountkey', 0);
        $username = $req->input('username', '');
        $client_ip = $req->ip();
        $lat = $req->input('Latitude', '');
        $long = $req->input('Longitude', '');
        $amountReturned = $req->input('amount', 10);

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        if (!($lat && $long && $amountReturned > 1)) {
            return [['output' => "Invalid params"]];}

        $url = "http://babasama.me/get_nearest_bus_stop/$lat/$long/$amountReturned";

        if (!($user_acc_key && $username)) {
            $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_a_day > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_Address_Calls')
            ->updateOrInsert(
                ['IP_address' => "$client_ip", 'month' => $currMonth, 'user_api_key' => $user_acc_key, 'day' => "$currDay"],
                ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

            $result = Http::withHeaders([
                'api_key' => $this->account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();
            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', $currDay], ['user_api_key', $user_acc_key]])->get();
                    foreach($datas as $i) {
                        if ($i->times_a_day > 300) {
                            return [['output' => 'You use this IP address to call the data too many times for today, please come again another day']];}}}
                            
                DB::table('api_datacenter.IP_Address_Calls')
                ->updateOrInsert(
                    ['IP_address' => "$client_ip", 'month'=> $currMonth, 'user_api_key' => $i->user_api_key, 'day' => "$currDay"],
                    ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $i) {
                    
                    $result = Http::withHeaders([
                        'api_key' => $i->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }} 

        } return [['output' => 'no value found']]; }

    function get_bus_arrival_timing(Request $req) {
        $user_acc_key = $req->input('accountkey', 0);
        $username = $req->input('username', '');
        $client_ip = $req->ip();
        $busstopcode = $req->input('BusStopCode', '');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        if (!$busstopcode) {
            return [['output' => "Invalid params"]];}

        $url = "http://babasama.me/get_bus_arrival/$busstopcode";

        if (!($user_acc_key || $username)) {
            $datas = DB::table('api_datacenter.IP_Address_Calls')->where([['IP_address', "$client_ip"], ['day', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_a_day > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}
            DB::table('api_datacenter.IP_Address_Calls')
            ->updateOrInsert(
                ['IP_address' => "$client_ip", 'month' => $currMonth, 'user_api_key' => $user_acc_key, 'day' => "$currDay"],
                ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

            $result = Http::withHeaders([
                'api_key' => $this->account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', $currDay], ['user_api_key', $user_acc_key]])->get();
                    foreach($datas as $i) {
                        if ($i->times_a_day > 300) {
                            return [['output' => 'You use this IP address to call the data too many times for today, please come again another day']];}}}

                DB::table('api_datacenter.IP_Address_Calls')
                ->updateOrInsert(
                    ['IP_address' => "$client_ip", 'month'=> $currMonth, 'user_api_key' => $i->user_api_key, 'day' => "$currDay"],
                    ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $i) {
                    $result = Http::withHeaders([
                        'api_key' => $i->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }} 

        } return [['output' => 'no value found']]; }

    function get_bus_route(Request $req) {
        $user_acc_key = $req->input('accountkey', 0);
        $username = $req->input('username', '');
        $client_ip = $req->ip();
        $serviceno = $req->input('ServiceNo', '');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        if (!$serviceno) {
            return [['output' => "Invalid params"]];}

        $url = "http://babasama.me/get_bus_route/$serviceno";

        if (!($user_acc_key || $username)) {
            $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_a_day > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_Address_Calls')
            ->updateOrInsert(
                ['IP_address' => "$client_ip", 'month' => $currMonth, 'user_api_key' => $user_acc_key, 'day' => "$currDay"],
                ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

            $result = Http::withHeaders([
                'api_key' => $this->account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', $currDay], ['user_api_key', $user_acc_key]])->get();
                    foreach($datas as $i) {
                        if ($i->times_a_day > 300) {
                            return [['output' => 'You use this IP address to call the data too many times for today, please come again another day']];}}}

                DB::table('api_datacenter.IP_Address_Calls')
                ->updateOrInsert(
                    ['IP_address' => "$client_ip", 'month'=> $currMonth, 'user_api_key' => $i->user_api_key, 'day' => "$currDay"],
                    ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $i) {
                    $result = Http::withHeaders([
                        'api_key' => $i->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }} 

        } return [['output' => 'no value found']]; }

    function search_bus(Request $req) {
        $user_acc_key = $req->input('accountkey', 0);
        $username = $req->input('username', '');
        $client_ip = $req->ip();
        $serviceno = $req->input('ServiceNo', '');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        if (!$serviceno) {
            return [['output' => "Invalid params"]];}

        $url = "http://babasama.me/get_bus_data/$serviceno";

        if (!($user_acc_key || $username)) {
            $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_a_day > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_Address_Calls')
            ->updateOrInsert(
                ['IP_address' => "$client_ip", 'month' => $currMonth, 'user_api_key' => $user_acc_key, 'day' => "$currDay"],
                ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

            $result = Http::withHeaders([
                'api_key' => $this->account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', $currDay], ['user_api_key', $user_acc_key]])->get();
                    foreach($datas as $i) {
                        if ($i->times_a_day > 300) {
                            return [['output' => 'You use this IP address to call the data too many times for today, please come again another day']];}}}

                DB::table('api_datacenter.IP_Address_Calls')
                ->updateOrInsert(
                    ['IP_address' => "$client_ip", 'month'=> $currMonth, 'user_api_key' => $i->user_api_key, 'day' => "$currDay"],
                    ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $i) {
                    
                    $result = Http::withHeaders([
                        'api_key' => $i->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }} 

        } return [['output' => 'no value found']]; }

    function get_bus_stop(Request $req) {
        if ($req->missing('BusStopCode')) {
            return [['output' => 'Invalid Parameters']];
        }

        $user_acc_key = $req->input('accountkey', 0);
        $username = $req->input('username', '');
        $client_ip = $req->ip();
        $busstopcode = $req->input('BusStopCode', '');

        date_default_timezone_set("Singapore");
        $currMonth = date('m', time());
        $currDay = date('Y-m-d', time());

        $url = "http://babasama.me/get_bus_stop_data/$busstopcode";

        if (!($user_acc_key || $username)) {
            $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', "$currDay"]])->get();
            foreach($datas as $i) {
                if ($i->times_a_day > 30) {
                    return [['output' => 'You use this IP address to call the data too many times anonymously, please register an account if you would like to call more times']];
                }}

            DB::table('api_datacenter.IP_Address_Calls')
            ->updateOrInsert(
                ['IP_address' => "$client_ip", 'month' => $currMonth, 'user_api_key' => $user_acc_key, 'day' => "$currDay"],
                ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

            $result = Http::withHeaders([
                'api_key' => $this->account_key
            ])->get($url);

            if ($result->serverError()) {
                return [['output' => "Server Error"]];
            } else if ($result->clientError()) {
                return [['output' => "Client Error"]];}

            return json_decode($result);
        } else {
            $API_Key = DB::table('api_datacenter.User')->select('user_api_key', 'user_role')->where([['user_api_key', $user_acc_key], ['username', "$username"]])->get();

            foreach ($API_Key as $i) {
                if ($i->user_role == "client") {
                    $datas = DB::table('api_datacenter.IP_Address_Calls')->select('times_a_day')->where([['IP_address', "$client_ip"], ['day', $currDay], ['user_api_key', $user_acc_key]])->get();
                    foreach($datas as $i) {
                        if ($i->times_a_day > 300) {
                            return [['output' => 'You use this IP address to call the data too many times for today, please come again another day']];}}}

                DB::table('api_datacenter.IP_Address_Calls')
                ->updateOrInsert(
                    ['IP_address' => "$client_ip", 'month'=> $currMonth, 'user_api_key' => $i->user_api_key, 'day' => "$currDay"],
                    ['times_a_month' => DB::raw('times_a_month + 1'), 'times_a_day' => DB::raw('times_a_day + 1')]);

                $datamall_key = DB::table('api_datacenter.User_API_Keys')->select('datamall')->where('user_api_key', $i->user_api_key)->get();
                foreach($datamall_key as $i) {
                    
                    $result = Http::withHeaders([
                        'api_key' => $i->datamall
                    ])->get($url);

                    if ($result->serverError()) {
                        return [['output' => "Server Error"]];
                    } else if ($result->clientError()) {
                        return [['output' => "Client Error"]];}

                    return json_decode($result); }} 

        } return [['output' => 'no value found']]; }
}
