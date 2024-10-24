<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarnetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $carnet;
    private $pdfPath;

    public function __construct($carnet, $pdfPath)
    {
        $this->carnet = $carnet;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Tu Carnet SENA')
                    ->view('emails.carnet') // Esta será una vista simple
                    ->attach($this->pdfPath, [
                        'as' => 'carnet.pdf',
                        'mime' => 'application/pdf'
                    ]);
    }
}