<?php
namespace Ariwf3\Blog_oop\Application\Controllers;

use Ariwf3\Blog_oop\Application\Models\UserModel;
use Ariwf3\Blog_oop\Application\Controllers\UserController;

class SignInController {

    private $errors = array();

    public function renderSignInView() {
        require 'public/views/front/signInView.phtml';
    }

    /**
     * setErrors Checks the integrity of user data and builds arrays with errors found (checks email and password)
     *
     * @param  array $post
     *
     * @return void
     */
    public function setErrors(array $post) {

        if (isset($post["emailSignIn"])) {
            $email = htmlspecialchars( trim( $post["emailSignIn"] ) );

            if ( empty($email) ) {
                $this->errors["email"][] = "Le mail est obligatoire";
                
            } 
            if ( !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,12}\.[a-z]{2,4}$#", $email) ) {
                $this->errors["email"][] = "L'adresse mail n'est pas au bon format, elle doit être en minuscules de type \"pseudo@nomdedomaine.extension\". (exemple: jean01@wanadoo.fr)";
            }
            $userModel = new UserModel();
            $user = $userModel->getUserByMail($email);
            
            if ( empty($user) ) {
                $this->errors["email"][] = "Adresse email inexistante ou introuvable";
            }
        }

        if (isset($post["password"])) {
            $password =  $post["password"] ;

            if ( strlen($password) < 4 ) {
                $this->errors["password"][] = "Le mot de passe est obligatoire et doit comporter au  moins 4 caractères";
            }
            if ( strlen($password) > 30 ) {
                $this->errors["password"][] = "Le mot de passe ne doit pas excéder 30 caractères";
            }
        }
    }

    /**
     * getErrors returns the errors arrays (email and password)
     *
     * @return array
     */
    public function getErrors() :array {
        return $this->errors;
    }

     public function logIn(array $post) {

        $email = $post['emailSignIn'];
        $password = $post['password'];

        if ( !empty($email) && !empty($password) && count($this->getErrors()) === 0 ) {

            $userController = new UserController();
            $userController->setCookieOneYear('email', htmlspecialchars($email));
            

            $userModel = new UserModel();
            $user = $userModel->getUserByMail($email);
            
            
            $hashedPassword = $user[0]->password;
            
            if ( password_verify($password, $hashedPassword) === true ) {

            $_SESSION['user']['id'] = $user[0]->id;
            $_SESSION['user']['email'] = $user[0]->email;
            $_SESSION['user']['firstName'] = $user[0]->firstname;
            $_SESSION['user']['lastName'] = $user[0]->lastname;
            $_SESSION['user']['pseudo'] = $user[0]->pseudo;
            $_SESSION['user']['role'] = $user[0]->role;
            $_SESSION['user']['datesub'] = $user[0]->subscription_date;
                
            header('Location: index.php');
            exit();

            } else {
                
                $userController = new UserController();
                $userController->setCookieOneYear('email', htmlspecialchars($email));

                $this->errors['password'][] = "Mauvais mot de passe";
                $errorsList = $this->getErrors();
                $serializeErrorsList = serialize($errorsList);
                    
                header("Location:index.php?action=signIn&error=1&errorslist=$serializeErrorsList");
            } 

        } else { //errors found we send the errors

            $userController = new UserController();
            $userController->setCookieOneYear('email', htmlspecialchars($email));

            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            // var_dump($errorsList);
            
            header("Location:index.php?action=signIn&error=1&errorslist=$serializeErrorsList");
            
        } // end count errors

        
    } 

}