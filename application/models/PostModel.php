<?php

namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;


class PostModel extends Database {

    CONST ENTITY_CLASSNAME = "PostsEntity";

    public function getPosts()
    {
        /* $sql = "SELECT post.id, user.id, post.user_id, post.title, post.post, post.creation_date, user.pseudo
        FROM posts post, users user 
        WHERE user.id = post.user_id"; */
        $sql ="SELECT post.id, post.user_id, post.title, post.post, post.creation_date, user.pseudo FROM posts post INNER JOIN users user ON user.id = post.user_id ORDER BY post.id DESC LIMIT 0,5";
        
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME);
    }

    public function getOnePost($id) {
        $id = (int) $id;
        $sql = "SELECT post.id, post.user_id, post.title, post.post, post.creation_date, user.pseudo FROM posts post, users user WHERE post.id = :id AND user.id = post.user_id" ;
        $array = [
            "id" => $id
        ];
        return $this->prepareExecute($sql, $array)->fetchAll(\PDO::FETCH_CLASS,'Ariwf3\Blog_oop\Application\Classes\Entity\PostsEntity');
    }
   /*  public function getOne($id) {
        
        $sql = "SELECT * FROM posts WHERE id = :id";
        $array = [
            "id" => $id
        ];
        return $this->queryOneFetchAssoc($sql,$array);
    } */

}