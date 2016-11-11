<?php

namespace TimFeid\LaravelSendgrid;

use Illuminate\Mail\Message as BaseMessage;

class Message extends BaseMessage
{
    protected $sendgrid_headers = [];

    public function category($category)
    {
        $this->sendgrid_headers['category'] = $category;
    }

    public function setSendGridHeaders()
    {
        if (!empty($this->sendgrid_headers)) {
            $header = $this->asString($this->sendgrid_headers);
            $this->getHeaders()->addTextHeader('X-SMTPAPI', $header);
        }
    }

    protected function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

        return $json;
    }

    protected function asString($data)
    {
        $json = $this->asJSON($data);
        $str = wordwrap($json, 76, "\n   ");

        return $str;
    }
}
