<?php

namespace App\Business\V1\Messages\ReceiveMessages;

use App\Exceptions\Messages\ReceiveMessages\NoMessageImap;
use Illuminate\Http\Response;

class ImapMail
{

    private \PhpImap\Mailbox $mailBox;

    private array $idsEmails;

    private function connectWithMailByImap(): \PhpImap\Mailbox
    {
        return  new \PhpImap\Mailbox(
            '{' . env('EMAIL_HOST') . ':993/imap/ssl}INBOX',
            env('EMAIL_USER'), // Username for the before configured mailbox
            env('EMAIL_PASSWORD'), // Password for the before configured username
            '', // Directory, where attachments will be saved (optional)
            'UTF-8', // Server encoding (optional)
            true, // Trim leading/ending whitespaces of IMAP path (optional)
            false // Attachment filename mode (optional; false = random filename; true = original filename)
        );
    }

    private function setMailBox($filter): void
    {
        try {
            $mailBox = $this->connectWithMailByImap();
            $mailBox->setAttachmentsIgnore(true);
            $mailsIds = $mailBox->searchMailbox('ALL');
        } catch (\PhpImap\Exceptions\ConnectionException $ex) {
            abort(Response::HTTP_SERVICE_UNAVAILABLE, 'Mailbox is not available');
        }
        if (empty($mailsIds)) {
            throw new NoMessageImap();
        }
        krsort($mailsIds);
        $this->mailBox = $mailBox;
        $this->idsEmails = $mailsIds;
    }

    public function getMailBox(string $filter = 'ALL'): \PhpImap\Mailbox
    {
        if (empty($this->mailBox)) {
            $this->setMailBox($filter);
        }
        return $this->mailBox;
    }

    public function getEmailsIds(): array
    {
        return $this->idsEmails;
    }

}
