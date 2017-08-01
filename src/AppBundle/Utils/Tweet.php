<?php

namespace AppBundle\Utils;

/**
 * Class Tweet
 * @package AppBundle\Controller
 *
 * This is a temporary class. It will be refactored to a doctrine instance.
 */
class Tweet
{
    public $title;
    public $author;
    public $body;

    public function __construct(string $title, string $author, string $body)
    {
        $this->title = $title;
        $this->author = $author;
        $this->body = $body;
    }
}
