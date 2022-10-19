<?php

namespace App\Business\V1\Messages\ReceiveMessages;

use App\Business\Business;
use App\Models\V1\Messages\ReceiveMessages\ReceiveMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReceiveMessages
{
    use Business;

    public function get(): LengthAwarePaginator
    {
        $this->dowloadNewEmails();
        return $this->repository->get();
    }

    private function dowloadNewEmails(): bool
    {
        $mail = new ImapMail();
        $mailbox = $mail->getMailBox();
        foreach ($mail->getEmailsIds() as $id) {
            $email = $mailbox->getMail($id);
            $messageId = $this->getByEmailId($email->messageId);
            if(empty($messageId)){
                $this->saveEmail($email);
                continue;
            }
            return true;
        }
        return true;
    }

    private function getByEmailId(string $emailId): ReceiveMessage|null
    {
        return ReceiveMessage::where('email_id_message', $emailId)->first();
    }

    private function saveEmail(\PhpImap\IncomingMail $mail): bool
    {
        $receiveMessage = new ReceiveMessage();
        $receiveMessage->email_id_message = $mail->messageId;
        $receiveMessage->subject_message = $mail->subject;
        $receiveMessage->from_mail_message = $mail->fromAddress;
        $receiveMessage->from_fullname_message = $mail->fromName;
        $receiveMessage->html_message = $mail->textHtml;
        $receiveMessage->received_message = $mail->date;
        return $receiveMessage->save();
    }
}