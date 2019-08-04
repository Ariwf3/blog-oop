<?php

namespace Ariwf3\Blog_oop\Application\Classes\Entity;

class Comments {

    public $id;
    public $post_id;
    public $author;
    public $comment;
    public $creation_date;

    
    /**
     * getExcerpt return extract of a comment
     *
     * @return string
     */
    public function getExcerpt() :string {
        return substr($this->comment,0,100);
    }
}