<?php
namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;    

class ChatModel extends Database {

    CONST ENTITY_CLASSNAME = "ChatEntity";

    public function insertMessage($post) {
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

    public function getMessages() {
        $sql = 'SELECT * FROM chat ORDER BY id DESC LIMIT 0,10';

        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME);
    }

    public function getLastMessage(int $lastId) {
        $sql = 'SELECT id, author, message, creation_date FROM chat WHERE id > :id ORDER BY id DESC ';

        $arrayParams = ['id' => $lastId];

        /* return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME,$arrayParams); */

        return $this->queryAllFetchAssoc($sql,$arrayParams);

    }

}