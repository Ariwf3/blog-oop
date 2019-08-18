<?php

namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;


class PostModel extends Database {

    CONST ENTITY_CLASSNAME = "PostsEntity";

    /**
     * getPosts Returns all the last 5 posts as an array of instances of the "PostEntity" entity and the user name of the "users" table
     *
     * @return array
     */
    public function getPosts() :array
    {
        /* jointure sans inner join $sql = "SELECT post.id, user.id, post.user_id, post.title, post.post, post.creation_date, user.pseudo
        FROM posts post, users user 
        WHERE user.id = post.user_id"; */
        $sql ="SELECT post.id, post.user_id, post.title, post.post, post.creation_date, user.pseudo FROM posts post INNER JOIN users user ON user.id = post.user_id ORDER BY post.id DESC LIMIT 0,5";
        
        // var_dump($this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME));
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME);
    }

    /**
     * getOnePost Returns a post according to its id as an array of instances of the "PostEntity" entity and the user name of the "users" table
     *
     * @param int $id
     *
     * @return array
     */
    public function getOnePost(int $id) :array {
        $id = (int) $id;
        $sql = "SELECT post.id, post.user_id, post.title, post.post, post.creation_date, user.pseudo FROM posts post, users user WHERE post.id = :id AND user.id = post.user_id" ;
        $array = [
            "id" => $id
        ];
        return $this->prepareExecute($sql, $array)->fetchAll(\PDO::FETCH_CLASS,'Ariwf3\Blog_oop\Application\Classes\Entity\PostsEntity');
    }

}