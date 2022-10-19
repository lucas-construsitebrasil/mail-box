<?php

namespace App\Models\V1\Messages\SendMessages;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class SendMessage extends Model
{

    public function get()
    {
        return QueryBuilder::for(SendMessage::class)
        ->allowedFilters([
            'subject_message', 'to_message', 'content_message'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate();
    }

}
