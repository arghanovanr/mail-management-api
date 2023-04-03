<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    function SendEmail(Request $request)
    {
        //Validate request data
        $request->validate(
            [
                'recipient' => 'required',
                'sender' => 'required',
                'content' => 'required',
            ],
            [
                'recipient.required' => 'recipient field is required',
                'sender.required' => 'sender field is required',
                'content.required' => 'content field is required',
            ]
        );

        // Declaring array variable
        $recipients = array();
        $recipients_cc  = array();
        $recipients_bcc = array();

        // Storing data request to variable
        $content = $request->content;
        $sender = $request->sender;
        $recipients = $request->recipient;
        $recipients_cc = $request->recipient_cc;
        $recipients_bcc = $request->recipient_bcc;

        //Create Log for sending message
        foreach ($recipients as $recipient) {
            dispatch(new SendMail($recipient, $content, $sender, $recipients_cc, $recipients_bcc));
        }

        return "Message has been sent";
    }
}
