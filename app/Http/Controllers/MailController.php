<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Mail\ContactConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(Request $req) {
        $details = [
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'subject' => $req->input('subject'),
            'content' => $req->input('content')
        ];

        Mail::to('julong170501@gmail.com')->send(new Contact($details));
        Mail::to($req->input('email'))->send(new ContactConfirmation($details));
        return 'email sent';
    }
}
