<?php

namespace Ariwf3\Blog_oop\Application\Classes\Entity;

class ChatEntity {

    public $id;
    public $author;
    public $message;
    public $creation_date;

    public function __construct() {
        $this->id = (int) $this->id;
        $this->author = ucfirst($this->author);
        //dateTime object conversion
        $this->creation_date = new \DateTime($this->creation_date);
        
    }

}