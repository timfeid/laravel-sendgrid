<?php

namespace TimFeid\LaravelSendgrid;

use Swift_Message;

class SwiftMessage extends Swift_Message
{
    protected $categories = [];
    protected $arguments = null;

    public function category($category)
    {
        $this->categories[] = $category;

        return $this;
    }

    public function uniqueArugments($arguments)
    {
        if (is_array($arguments)) {
            foreach ($arguments as &$argument) {
                $argument = (string) $argument;
            }
            $this->arugments = (object) $arguments;
        }


        $this->arguments = $arguments;

        return $this;
    }

    public function uniqueArgs($args)
    {
        return $this->uniqueArugments($args);
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getArguments()
    {
        return $this->arguments;
    }
}
