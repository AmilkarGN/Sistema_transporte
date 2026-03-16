<?php



namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Tu código de acceso - Sistema de Transporte')
                    ->html("<h3>Tu código de seguridad es: <strong>{$this->code}</strong></h3>
                            <p>Este código expirará en 10 minutos.</p>");
    }
}