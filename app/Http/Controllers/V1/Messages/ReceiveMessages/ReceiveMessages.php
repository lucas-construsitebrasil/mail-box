<?php

namespace App\Http\Controllers\V1\Messages\ReceiveMessages;

use App\Http\Controllers\Controller;

class ReceiveMessages extends Controller
{
    public function get()
    {
       return $this->business->get();
    }
}
