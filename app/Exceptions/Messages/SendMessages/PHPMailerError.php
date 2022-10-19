<?php

namespace App\Exceptions\Messages\SendMessages;


class PHPMailerError extends \Exception
{

    public function __construct(string $message)
    {
        parent::__construct('Erro ao enviar e-mail:' . $message);
    }

}
