<?php

namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;

class CommentModel extends Database {

    
    CONST ENTITY_CLASSNAME = "CommentsEntity";

    /**
     * getComments Retrieves comments from a post in a "Comments" entity using the post id, returns an array of objects
     *
     * @param mixed $post_id
     *
     * @return array
     */
    public function getComments(int $post_id) :array {

        $id = (int) $post_id;
        $array = [
            "id" => $id
        ];

        $sql = "SELECT id, post_id, author, comment, creation_date FROM comments WHERE post_id = :id";
        
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME, $array);
    }

    /**
     * getLastComments Retrieves the four last comments from a post in a "Comments" entity using the post id, returns an array of objects
     *
     * @param int $post_id
     *
     * @return array
     */
    public function getLastComments(int $post_id) :array {
        $id = (int) $post_id;
        $array = [
            "id" => $id
        ];

        $sql = "SELECT id, post_id, author, comment, creation_date FROM comments WHERE post_id = :id ORDER BY id DESC LIMIT 4";
        
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME, $array);
    }
}