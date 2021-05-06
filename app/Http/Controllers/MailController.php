<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(Request $req) {
        $details = [
            'name' => $req['name'],
            'email' => $req['email'],
            'subject' => $req['subject'],
            'content' => $req['content']
        ];

        Mail::to('julong170501@gmail.com')->send(new Contact($details));
        Mail::to($req['email'])->send(new Contact($details));
        return 'email sent';
    }
}
