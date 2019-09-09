<?php

namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;

class UserModel extends Database {

    CONST ENTITY_CLASSNAME = "UsersEntity";

    /**
     * insertUser Insert an user with user datas $post and hashes the password
     *
     * @param  array $post
     *
     * @return void
     */
    public function insertUser(array $post) {

        $hashedPassword = password_hash($post['password'],PASSWORD_DEFAULT,['cost' => 12]);

        $sql = "INSERT INTO users (firstname, lastname, email, role, pseudo, password, subscription_date) 
        VALUES (:firstname, :lastname, :email, 'user', :pseudo, :password, NOW())";

        $array = [
            "firstname" => $post['firstName'],
            "lastname" => $post['lastName'],
            "email" => $post['emailSignUp'],
            "pseudo" => $post['pseudo'],
            "password" => $hashedPassword
        ];

        $this->pdo->beginTransaction();

        try {
            $this->prepareExecute($sql, $array);
            $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible d'ajouter le commentaire, voir le message suivant :</h4> " . $e->getMessage());
        }
    }

    /**
     * deleteUser Deletes an user according to its id
     *
     * @param  int $id
     *
     * @return void
     */
    public function deleteUser(int $id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $arrayParam = ["id" => $id];

        $this->pdo->beginTransaction();

        try {
            $this->prepareExecute($sql, $arrayParam);
            $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible de supprimer l'utilisateur, voir le message suivant :</h4> " . $e->getMessage());
        }
    }

    /**
     * updateUser 
     * 
     * updates one user with user datas of the array post according to its id as parameter
     *
     * @param  int $id
     * @param  array $post
     *
     * @return void
     */
    public function updateUser(int $id, array $post) {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $arrayParams = ["role" => $post['role'], "id" => $id];

        $this->pdo->beginTransaction();

        try {
            $this->prepareExecute($sql, $arrayParams);
            $this->pdo->commit();
            
        } catch (\PDOException $e) {
            $this->pdo->rollback();
            throw new \PDOException("<h4 class='error_message'>Impossible de modifier le rang de l'utilisateur, voir le message suivant :</h4> " . $e->getMessage());
        }
    }

    /**
     * getUsers Returns all users as an array of instances of the "User" entity
     *
     * @return array
     */
    public function getUsers() :array {

        $sql = "SELECT id, firstname, lastname, email, role, pseudo, password, subscription_date FROM users ";

        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME);
    }

    public function getOneUser(int $id) :array {

        $sql = "SELECT id, firstname, lastname, email, role,pseudo, password, subscription_date FROM users WHERE id = :id ";

        $arrayParams = [
            "id" => $id
        ];
        
        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME, $arrayParams);
        
    }
    
    /**
     * getUserByMail Returns one user according to the email user
     *
     * @param string $email
     *
     * @return array
     */
    public function getUserByMail(string $email) :array {

        $sql = "SELECT id, firstname, lastname, email, role,pseudo, password, subscription_date FROM users WHERE email = :email ";

        $arrayParams = [
            "email" => $email
        ];

        return $this->queryAllFetchClass($sql, SELF::ENTITY_CLASSNAME, $arrayParams);

    }

}