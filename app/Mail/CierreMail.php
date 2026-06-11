<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CierreMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function build()
    {
        return $this->from('rafael.escobar@progresarcorporation.com.py', 'Progresar Corporation')
                    ->subject('Nuevo Cierre Registrado')
                    ->view('email.cierre') // Vista del correo
                    ->with('datos', $this->datos);
    }
}

