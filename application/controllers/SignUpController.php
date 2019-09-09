<?php
namespace Ariwf3\Blog_oop\Application\Controllers;

use Ariwf3\Blog_oop\Application\Models\UserModel;
use Ariwf3\Blog_oop\Application\Controllers\UserController;

class SignUpController {

    private $errors = array();

    /**
     * renderSignUpView 
     * 
     * Returns the view "signUpView" : Page with the sign up section
     *
     * @return void
     */
    public function renderSignUpView() {
        require 'public/views/front/signUpView.phtml';
    }
    
    /**
     * setErrors 
     * 
     * Checks the integrity of user data and builds arrays with errors found (checks lastname,firstname,email,pseudo,password,password check)
     *
     * @param  array $post
     *
     * @return void
     */
    public function setErrors(array $post) {

        if (isset($post["lastName"])) {
            $lastName = htmlspecialchars( trim( $post["lastName"] ) );

            if ( empty($lastName) ) {
                $this->errors["lastname"][] = "Le nom est obligatoire";
            }

            // alphanumeric and accentuated characters, non-consecutives dashes and dots between 2 and 50 characters
            if ( !preg_match('`^([a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-.](?![-.])){2,50}$`',$lastName) ) {
                $this->errors["lastName"][] = "Le nom doit commencer par une lettre. Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum";
            }
            if (strlen($lastName) > 50) {
                $errs["lastName"][] = "Le nom ne doit pas exceder 50 caractères";
            }
        } // lastName

        if (isset($post["firstName"])) {
            $firstName = htmlspecialchars( trim( $post["firstName"] ) );

            if ( empty($firstName) ) {
                $this->errors["firstName"][] = "Le prénom est obligatoire";
            }
            
            // alphanumeric and accentuated characters, non-consecutives dashes and dots between 2 and 50 characters
            if ( !preg_match('`^([a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-.](?![-.])){2,50}$`',$firstName) ) {
                $this->errors["firstName"][] = "Le prénom doit commencer par une lettre. Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum";
            }

        } //firstName

        if (isset($post["emailSignUp"])) {
            $email = htmlspecialchars( trim( $post["emailSignUp"] ) );

            if ( empty($email) ) {
                $this->errors["email"][] = "Le mail est obligatoire";
                
            } 
            if ( !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,12}\.[a-z]{2,4}$#", $email) ) {
                $this->errors["email"][] = "L'adresse mail n'est pas au bon format, elle doit être en minuscules de type \"pseudo@nomdedomaine.extension\". (exemple: jean01@wanadoo.fr)";
            }
            $userModel = new UserModel();
            $users = $userModel->getUsers();
            
            foreach ($users as $user) {
                
                if ($user->email === $email ) {
                    $this->errors["email"][] = "L'adresse email existe déja";
                } 
            }
            
        } //email signUp

        
        if (isset($post["pseudo"])) {
            $pseudo = htmlspecialchars( trim( $post["pseudo"] ) );

            if ( empty($pseudo) ) {
                $this->errors["pseudo"][] = "Le pseudonyme est obligatoire";
            }
            
            // alphanumeric and accentuated characters, non-consecutives dashes and underscores between 2 and 30 characters
            if(!preg_match('`^([a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-_](?![-_])){2,30}$`',$pseudo)) 
            { 
                $this->errors["pseudo"][] = "Le format du pseudonyme n'est pas correct (lettres et chiffres uniquement, de 2 à 30 caractères)"; 
            }
            foreach ($users as $user) {
                
                if ($user->pseudo === strtolower($pseudo) ) {
                    $this->errors["pseudo"][] = "Le pseudonyme existe déja";
                } 
            }
        } //pseudo

        if (isset($post["password"])) {
            $password =  $post["password"] ;

            if ( strlen($password) < 4 ) {
                $this->errors["password"][] = "Le mot de passe est obligatoire et doit comporter au  moins 4 caractères";
            }
            if ( strlen($password) > 30 ) {
                $this->errors["password"][] = "Le mot de passe ne doit pas excéder 30 caractères";
            }
        }

        if (isset($post['passwordCheck'])) {
            $passwordCheck = $post["passwordCheck"];
            $password = $post["password"];

            if ($passwordCheck !== $password) {
                $this->errors["passwordCheck"][] = "Les mots de passe ne correspondent pas";
            }
        }
    }

    /**
     * getErrors 
     * 
     * returns the errors arrays (lastname,firstname,email,pseudo,password and password check)
     *
     * @return array
     */
    public function getErrors() :array {
        return $this->errors;
    }

    /**
     * logUp 
     * 
     * Logs up if no errors found, and logs in with the password_verify function then redirects to the index. 
     *
     * @param  array $post
     *
     * @return void
     */
    public function logUp(array $post) {
        $firstName = trim($post['firstName']);
        $lastName = trim($post['lastName']);
        $pseudo = trim($post['pseudo']);
        $email = trim($post['emailSignUp']);
        $password = $post['password'];
        $passwordCheck = $post['passwordCheck'];
        
        if(isset($post) && count($this->getErrors()) === 0 ) {

            $userModel = new UserModel();
            $userModel->insertUser($post);

            $email = htmlspecialchars(trim($post['emailSignUp']));
            $password = $post['password'];
            

            //direct logIn after signUp
            $user = $userModel->getUserByMail($email);
            $hashedPassword = $user[0]->password;

            if ( password_verify($password, $hashedPassword) === true ) 
            {
                unset($_SESSION['userSignUp']);

                $_SESSION['user']['id'] = $user[0]->id;
                $_SESSION['user']['email'] = $user[0]->email;
                $_SESSION['user']['firstName'] = $user[0]->firstname;
                $_SESSION['user']['lastName'] = $user[0]->lastname;
                $_SESSION['user']['pseudo'] = $user[0]->pseudo;
                $_SESSION['user']['role'] = $user[0]->role;
                $_SESSION['user']['datesub'] = $user[0]->subscription_date;
                
                header('Location: index.php');
                exit();
            } // password verification
        
        } else {
            
            $_SESSION['userSignUp']['firstName'] = htmlspecialchars($firstName);
            $_SESSION['userSignUp']['lastName'] = htmlspecialchars($lastName);
            $_SESSION['userSignUp']['email'] = htmlspecialchars($email);
            $_SESSION['userSignUp']['pseudo'] = htmlspecialchars($pseudo);

            $_SESSION['userSignUp']['errors'] = $this->getErrors();
            
            header("Location:index.php?action=signUp");
        } // count errors
    }
}