<?php

namespace TimFeid\LaravelSendgrid;

use Swift_Message;
use Illuminate\Mail\Mailer as BaseMailer;
use Illuminate\Contracts\Mail\Mailable as MailableContract;

class Mailer extends BaseMailer
{
    /**
     * Create a new message instance.
     *
     * @return \Timfeid\LaravelSendgrid\Message
     */
    protected function createMessage()
    {
        $message = new Message(new Swift_Message());

        // If a global from address has been specified we will set it on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (!empty($this->from['address'])) {
            $message->from($this->from['address'], $this->from['name']);
        }

        return $message;
    }

    public function send($view, array $data = [], $callback = null)
    {
        if ($view instanceof MailableContract) {
            return $view->send($this);
        }

        // First we need to parse the view, which could either be a string or an array
        // containing both an HTML and plain text versions of the view which should
        // be used when sending an e-mail. We will extract both of them out here.
        list($view, $plain, $raw) = $this->parseView($view);

        $data['message'] = $message = $this->createMessage();

        // Once we have retrieved the view content for the e-mail we will set the body
        // of this message using the HTML type, which will provide a simple wrapper
        // to creating view based emails that are able to receive arrays of data.
        $this->addContent($message, $view, $plain, $raw, $data);

        call_user_func($callback, $message);

        // If a global "to" address has been set, we will set that address on the mail
        // message. This is primarily useful during local development in which each
        // message should be delivered into a single mail address for inspection.
        if (isset($this->to['address'])) {
            $this->setGlobalTo($message);
        }

        $message->setSendGridHeaders();
        $this->sendSwiftMessage($message->getSwiftMessage());
    }
}
