<?php

namespace Ariwf3\Blog_oop\Application\Classes\Entity;

class PostsEntity {
    
    public $id;
    public $title;
    public $post;
    public $creation_date;

    public function __construct() {
        $this->id = (int) $this->id;
    }


}

