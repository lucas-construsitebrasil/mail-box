<?php

namespace App\Models\V1\Messages\ReceiveMessages;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class ReceiveMessage extends Model
{

    public function get()
    {
        return QueryBuilder::for(ReceiveMessage::class)
        ->allowedFilters([
            'email_id_message', 'subject_message',
            'received_message', 'from_mail_message'
        ])
        ->orderBy('received_message', 'desc')
        ->paginate();
    }

}
