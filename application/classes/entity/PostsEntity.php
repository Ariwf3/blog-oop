<?php

namespace Ariwf3\Blog_oop\Application\Classes\Entity;

class PostsEntity {
    
    public $id;
    public $user_id;
    public $title;
    public $post;
    public $creation_date;

    public function __construct() {
        $this->id = (int) $this->id;
        $this->user_id = (int) $this->user_id;

        //dateTime object conversion
        $this->creation_date = new \DateTime($this->creation_date);
        
    }


}

