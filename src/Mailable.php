<?php

namespace TimFeid\LaravelSendgrid;

use Illuminate\Mail\Mailable as BaseMailable;

class Mailable extends BaseMailable
{
    protected $mailerCallbacks = [];

    protected function runCallbacks($message)
    {
        foreach ($this->mailerCallbacks as $callback) {
            $callback($message);
        }

        return parent::runCallbacks($message);
    }

    public function category($category)
    {
        $this->mailerCallbacks[] = function ($mail) use ($category) {
            $mail->category($category);
        };

        return $this;
    }

    public function uniqueArugments($arguments)
    {
        $this->mailerCallbacks[] = function ($mail) use ($arguments) {
            $mail->uniqueArugments($arguments);
        };

        return $this;
    }

    public function uniqueArgs($arguments)
    {
        $this->mailerCallbacks[] = function ($mail) use ($arguments) {
            $mail->uniqueArugments($arguments);
        };

        return $this;
    }

    public function addSendgridHeader($header)
    {
        $this->mailerCallbacks[] = function ($mail) use ($header) {
            $mail->addSendgridHeader($header);
        };

        return $this;
    }
}
