<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to, $to2, $subject, $txt, $headers;

    public function __construct($to, $to2, $subject, $txt, $headers)
    {
        $this->to = $to;
        $this->to2 = $to2;
        $this->subject = $subject;
        $this->txt = $txt;
        $this->headers = $headers;
    }

    public function handle()
    {
        mail($this->to, $this->subject, $this->txt, $this->headers);
        mail($this->to2, $this->subject, $this->txt, $this->headers);
    }
}
