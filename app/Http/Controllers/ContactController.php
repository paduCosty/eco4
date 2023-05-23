<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $company_name = $request->input('company_name');
        $contact_name = $request->input('contact_person_name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $contact_message = $request->input('message');
        Mail::to(env('MAIL_FROM_ADDRESS'))
            ->send(new ContactMail(
                $company_name,
                $contact_name,
                $phone,
                $email,
                $contact_message
            ));


        return redirect()->back()->with('success', 'Emailul a fost trimis cu succes!');
    }
}
