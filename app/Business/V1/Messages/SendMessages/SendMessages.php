<?php

namespace App\Business\V1\Messages\SendMessages;

use App\Business\Business;
use App\Http\Requests\V1\Messages\SendMessages\PostSendMessage;
use App\Lib\PHPMailer\SendMessage;
use App\Models\V1\Messages\SendMessages\SendMessage as Repository;
use Illuminate\Pagination\LengthAwarePaginator;

class SendMessages
{
    use Business;

    public function get(): LengthAwarePaginator
    {
        return $this->repository->get();
    }

    public function post(PostSendMessage $request): bool
    {
        $request->only('to', 'subject', 'message');
        if($this->sendMessage($request->to, $request->subject, $request->message)){
            $repository = new Repository();
            $repository->to_message = $request->to;
            $repository->subject_message = $request->subject;
            $repository->content_message = $request->message;
            return $repository->save();
        }
        return false;
    }

    private function sendMessage(string $to, string $subject,  string $message){
        return (new SendMessage)->send($to, $subject, $message);
    }
}
