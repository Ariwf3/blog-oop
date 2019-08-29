<?php

namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;


class PostModel extends Database {

    CONST ENTITY_CLASSNAME = "PostsEntity";


    public function insertPost(int $userId, array $post) :void {
        $sql = "INSERT INTO posts (user_id, title, post, creation_date) VALUES(:id, :title, :post, NOW())";

        $arrayParams = [
            "id" => $userId,
            "title" => $post['title'],
            "post" => $post['post']
        ];

        $this->pdo->beginTransaction();

        try {

            $this->prepareExecute($sql, $arrayParams);
            $this->pdo->commit();

        } catch (\PDOException $e) {

            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible d'ajouter le billet, voir le message suivant :</h4> " . $e->getMessage());

        }
    }

    public function updatePost(int $postId, $post) {
        $sql = "UPDATE posts SET  title = :title, post = :post WHERE id = :id ";

        $arrayParams = [
            "id" => $postId,
            "title" => $post['title'],
            "post" => $post['post']
        ];

        $this->pdo->beginTransaction();

        try {

            $this->prepareExecute($sql, $arrayParams);
            $this->pdo->commit();

        } catch (\PDOException $e) {

            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible de modifier le billet, voir le message suivant :</h4> " . $e->getMessage());

        }

    }

    public function deletePost(int $postId) {
        $sql = "DELETE FROM posts WHERE id = :id";

        $arrayParams = ["id" => $postId];

        $this->pdo->beginTransaction();

        try {
            $this->prepareExecute($sql, $arrayParams);
            $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible de supprimer le billet, voir le message suivant :</h4> " . $e->getMessage());
        }
    }

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
      * getPostsByUser Returns all posts according to the user id as an array of instances of the "PostEntity" entity
      *
      * @param  int $userId
      *
      * @return array
      */
     public function getPostsByUser(int $userId) :array {
        // $id = (int) $id;
        $sql = "SELECT post.id, post.user_id, post.title, post.post, post.creation_date FROM posts post, users user WHERE user.id = :id AND user.id = post.user_id" ;
        $arrayParams = [
            "id" => $userId
        ];
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME, $arrayParams);
    }

    /**
     * getOnePost Returns a post according to its id as an array of instances of the "PostEntity" entity and the user name of the "users" table
     *
     * @param int $id
     *
     * @return array
     */
    public function getOnePost(int $postId) :array {
        // $id = (int) $id;
        $sql = "SELECT post.id, post.user_id, post.title, post.post, post.creation_date, user.pseudo FROM posts post, users user WHERE post.id = :id AND user.id = post.user_id" ;
        $arrayParams = [
            "id" => $postId
        ];
        return $this->prepareExecute($sql, $arrayParams)->fetchAll(\PDO::FETCH_CLASS,'Ariwf3\Blog_oop\Application\Classes\Entity\PostsEntity');
    }

   

}