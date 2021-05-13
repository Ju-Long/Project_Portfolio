<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function login(Request $req) {
        $username = $req->input('username');
        $password = $req->input('password');

        if (!($username || $password)) {
            return [['output' => "Invalid params"]];}
        
        return DB::table('api_datacenter.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
    }

    function signup(Request $req) {
        return $req;
    }
}
