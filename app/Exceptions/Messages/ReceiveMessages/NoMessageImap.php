<?php

namespace App\Exceptions\Messages\ReceiveMessages;


class NoMessageImap extends \Exception
{

    public function __construct()
    {
        parent::__construct('Nenhuma mensagem encontrada na caixa de e-mail com o filtro selecionado!');
    }

}
