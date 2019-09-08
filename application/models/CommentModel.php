<?php

namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;

class CommentModel extends Database {

    
    CONST ENTITY_CLASSNAME = "CommentsEntity";

    /**
     * insertComment insert one comment with user datas of the array post according to an post id as parameter
     *
     * @param  int $post_id
     * @param  array $post
     *
     * @return void
     */
    public function insertComment(int $post_id, array $post) :void {

        $id = (int) $post_id;
    
        $arrayParams = [
            "id" => $id,
            "author" => $post['author'],
            "comment" => $post['message']
        ];

        $sql = "INSERT INTO comments (post_id, author, comment, creation_date) 
        VALUES (:id, :author, :comment, NOW())";

        $this->pdo->beginTransaction();

        try {
            $this->prepareExecute($sql, $arrayParams);
            $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible d'ajouter le commentaire, voir le message suivant :</h4> " . $e->getMessage());
        }
    }

    /**
     * getCommentsByPost Returns all comments of a post according to its id as an array of instances of the "CommentsEntity" entity
     *
     * @param int $post_id
     *
     * @return array
     */
    public function getCommentsByPost(int $post_id) :array {

        $id = (int) $post_id;
        $array = [
            "id" => $id
        ];

        $sql = "SELECT id, post_id, author, comment, creation_date FROM comments WHERE post_id = :id";
        
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME, $array);
    }

    /**
     * getLastCommentsBypost Returns 4 last comments of a post according to its id as an array of instances of the "CommentsEntity" entity
     *
     * @param int $post_id
     *
     * @return array
    */
    public function getLastCommentsBypost(int $post_id) :array {
        $id = (int) $post_id;
        $array = [
            "id" => $id
        ];

        $sql = "SELECT id, post_id, author, comment, creation_date FROM comments WHERE post_id = :id ORDER BY id DESC LIMIT 4";
        
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME, $array);
    }

}