<?php

namespace TimFeid\LaravelSendgrid;

use Illuminate\Mail\Message;
use Illuminate\Mail\Mailer as BaseMailer;

class Mailer extends BaseMailer
{
    /**
     * Create a new message instance.
     *
     * @return \Timfeid\LaravelSendgrid\Message
     */
    protected function createMessage()
    {
        $message = new Message(new SwiftMessage());
        // If a global from address has been specified we will set it on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (!empty($this->from['address'])) {
            $message->from($this->from['address'], $this->from['name']);
        }

        return $message;
    }
}
