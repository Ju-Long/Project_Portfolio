<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuoteApiController extends Controller
{
    function getQuote(Request $req) {
        $quote_number = isset($req['quote_number']) ? $req['quote_number'] : rand(0, 1643);
        if ($quote_number > 1643) {
            return "the number u enter is too big. please enter a number between 0 and 1643";
        }
        $url = "http://babasama.me/quotes/data_num/$quote_number";
        $json = json_decode(file_get_contents($url), true);
        return $json;
    }
}
