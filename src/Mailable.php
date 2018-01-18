<?php

namespace TimFeid\LaravelSendgrid;

use Illuminate\Mail\Mailable as BaseMailable;

class Mailable extends BaseMailable
{
    protected $categories = [];
    protected $arguments = null;

    public function category($category)
    {
        $this->withSwiftMessage(function ($mail) use ($category) {
            $mail->category($category);
        });

        return $this;
    }

    public function uniqueArugments($arguments)
    {
        $this->arguments = $arguments;

        $this->withSwiftMessage([$this, 'addArguments']);

        return $this;
    }

    public function addArguments($message)
    {
        $message->uniqueArugments($this->arguments);
    }

    public function uniqueArgs($arguments)
    {
        return $this->uniqueArugments($arguments);
    }
}
