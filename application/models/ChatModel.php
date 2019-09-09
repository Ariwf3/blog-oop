<?php
namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;    

class ChatModel extends Database {

    CONST ENTITY_CLASSNAME = "ChatEntity";

    /**
     * insertMessage insert one post with user datas of the array post 
     *
     * @param  array $post
     *
     * @return void
     */
    public function insertMessage(array $post) {
        $sql = "INSERT INTO chat (author, message, creation_date) VALUES (:author, :message, NOW())";

        $author = trim($post['author']);
        $message = trim($post['message']);

        $arrayParams = [
            "author" => urldecode($author),
            "message" => urldecode($message)
            /* "author" => $post['author'],
            "message" => $post['message'] */
        ];

        $this->pdo->beginTransaction();
        try {
            $this->prepareExecute($sql, $arrayParams);
            $this->pdo->commit();

        } catch (\PDOException $e) {
            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible d'ajouter le message, voir le message suivant :</h4> " . $e->getMessage());
        }
    }   

    /**
     * getMessages Returns the last ten messages by descending order of the id
     *
     * @return array
     */
    public function getLastTenMessages() :array {
        $sql = 'SELECT * FROM chat ORDER BY id DESC LIMIT 0,10';

        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME);
    }

    /**
     * getLastMessage 
     * 
     * Returns the last message according to the id($lastId) of the last message received
     *
     * @param  int $lastId
     *
     * @return array
     */
    public function getLastMessage(int $lastId) :array {
        $sql = 'SELECT id, author, message, creation_date FROM chat WHERE id > :id ORDER BY id DESC ';

        $arrayParams = ['id' => $lastId];

        return $this->queryAllFetchAssoc($sql,$arrayParams);

    }

}