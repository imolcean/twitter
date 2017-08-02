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
    public $id;
    public $title;
    public $author;
    public $body;

    public function __construct(int $id, string $title, string $author, string $body)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->body = $body;
    }
}
