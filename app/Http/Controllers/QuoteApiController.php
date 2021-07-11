<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuoteApiController extends Controller
{
    function get_quote(Request $req) {
        $number = $req->number ?? -1;
        $url = "http://babasama.me/get_random_quote/$number";
        $return = json_decode(file_get_contents($url), true);
        return $return;
    }
}
