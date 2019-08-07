<?php

namespace Ariwf3\Blog_oop\Application\Classes\Entity;

class CommentsEntity {

    public $id;
    public $post_id;
    public $author;
    public $comment;
    public $creation_date;

    
     public function __construct() {
        $this->id = (int) $this->id;
        $this->post_id = (int) $this->post_id;
        $this->author = ucfirst($this->author);
        //dateTime object conversion
        $this->creation_date = new \DateTime($this->creation_date);
        
    }

    
    /**
     * getExcerpt Returns a comment extract with three points when the comment exceeds 50 characters
     *
     * @return string
     */
    public function getExcerpt() :string {

        if (strlen(substr($this->comment,0,50)) >= 50) {
             return substr($this->comment,0,50) . "...";
        } else {
            return substr($this->comment,0,50);
        }
        
    }
}