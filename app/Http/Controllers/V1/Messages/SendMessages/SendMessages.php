<?php

namespace App\Http\Controllers\V1\Messages\SendMessages;

use App\Exceptions\Messages\SendMessages\PHPMailerError;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Messages\SendMessages\PostSendMessage;
use Illuminate\Http\Response;

class SendMessages extends Controller
{
    public function get()
    {
        return $this->business->get();
    }

    public function post(PostSendMessage $request): Response
    {
        try {
            if ($this->business->post($request)) {
                return response('', Response::HTTP_OK);
            }
            return response(['error' => 'Error Saving Mail But Mail is Send'], Response::HTTP_BAD_REQUEST);
        } catch (PHPMailerError $e) {
            return response(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
