<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Maillog;
use App\Mail\Email;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recipients_cc  = array();
    public $recipients_bcc = array();
    public $recipient;
    public $content;
    public $sender;

    public function __construct($recipient, $content, $sender, $recipients_cc, $recipients_bcc)
    {
        $this->recipient = $recipient;
        $this->recipients_cc = $recipients_cc;
        $this->recipients_bcc = $recipients_bcc;
        $this->content = $content;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Sending an Email
        Mail::to($this->recipient)
            ->cc($this->recipients_cc)
            ->bcc($this->recipients_bcc)
            ->send(new Email($this->content, $this->sender));

        // Record Mail Log
        $messagelog = new Maillog();
        $messagelog->recipient = $this->recipient;
        $messagelog->recipients_cc = json_encode($this->recipients_cc);
        $messagelog->recipients_bcc = json_encode($this->recipients_bcc);
        $messagelog->content = $this->content;
        $messagelog->sender = $this->sender;
        $messagelog->save();
    }
}
