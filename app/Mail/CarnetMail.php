<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarnetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $carnet;

    public function __construct($carnet)
    {
        $this->carnet = $carnet;
    }

    public function build()
    {
        return $this->view('emails.carnet')
                    ->subject('Tu Carnet Digital');
    }
}