<?php
namespace Ariwf3\Blog_oop\Application\Controllers\Front;

use Ariwf3\Blog_oop\Application\Models\UserModel;

class UserController {

    private $errors = array();


    /**
     * setCookieOneYear Set a cookie for 1 year
     *
     * @param  string $cookieId
     * @param  mixed $userData
     *
     * @return void
     */
    public function setCookieOneYear(string $cookieId, string $userData) {
        $one_year =  365*24*3600;
        setcookie($cookieId, $userData, time() + $one_year, null, null ,false, true);
    }

    /**
     * setErrors Checks the integrity of user data and builds arrays with errors found
     *
     * @param  array $post
     *
     * @return void
     */
    public function setErrors(array $post) {

        if (isset($post["lastName"])) {
            $lastName = htmlspecialchars( trim( $post["lastName"] ) );

            /* if ( empty($lastName) ) {
                $this->errors["lastname"][] = "Le nom est obligatoire";
            }
            if ( strlen($lastName) < 2 ) {
                $this->errors["lastname"][] = "Le nom doit comporter au  moins 2 caractères";
            } */
            if ( !preg_match('`^([a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-.](?![-.])){2,50}$`',$lastName) ) {
                $this->errors["lastName"][] = "Le nom doit commencer par une lettre. Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum";
            }
            if (strlen($lastName) > 50) {
                $errs["lastName"][] = "Le nom ne doit pas exceder 50 caractères";
            }
        } // lastName

        if (isset($post["firstName"])) {
            $firstName = htmlspecialchars( trim( $post["firstName"] ) );

            /* if ( empty($firstName) ) {
                $this->errors["firstName"][] = "Le prénom est obligatoire";
            }
            if ( strlen($firstName) < 2 ) {
                $this->errors["firstName"][] = "Le prénom doit comporter au  moins 2 caractères";
            } */
            if ( !preg_match('`^([a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-.](?![-.])){2,50}$`',$firstName) ) {
                $this->errors["firstName"][] = "Le prénom doit commencer par une lettre. Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum";
            }
            if (strlen($firstName) > 50) {
                $errs["firstName"][] = "Le prénom ne doit pas exceder 50 caractères";
            }
        } //firstName

        if (isset($post["email"])) {
            $email = htmlspecialchars( trim( $post["email"] ) );

            if ( empty($email) ) {
                $this->errors["email"][] = "Le mail est obligatoire";
                
            } 
            if ( !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,12}\.[a-z]{2,4}$#", $email) ) {
                $this->errors["email"][] = "L'adresse mail n'est pas au bon format, elle doit être en minuscules de type \"pseudo@nomdedomaine.extension\". (exemple: jean01@wanadoo.fr)";
            }
            $userModel = new UserModel();
            $users = $userModel->getUsers();
            
            foreach ($users as $user) {
                // var_dump($user->email);
                if ($user->email === $email ) {
                    $this->errors["email"][] = "L'adresse email existe déja";
                } 
            }
            
           
        } //email

        if (isset($post["pseudo"])) {
            $pseudo = htmlspecialchars( trim( $post["pseudo"] ) );

            /* if ( empty($pseudo) ) {
                $this->errors["pseudo"][] = "Le pseudonyme est obligatoire";
            }
            if ( strlen($pseudo) < 2 ) {
                $this->errors["pseudo"][] = "Le pseudonyme doit comporter au  moins 2 caractères";
            } */
            if(!preg_match('`^([a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-_](?![-_])){2,30}$`',$pseudo)) // alphanumeric characters, non-consecutives dashes and underscores between 2 and 30
            { 
                $this->errors["pseudo"][] = "Le format du pseudonyme n'est pas correct (lettres et chiffres uniquement, de 2 à 30 caractères)"; 
            }
            foreach ($users as $user) {
                // var_dump($user);
                if ($user->pseudo === strtolower($pseudo) ) {
                    $this->errors["pseudo"][] = "Le pseudonyme existe déja";
                } 
            }
            if (strlen($pseudo) > 30) {
                $errs["pseudo"][] = "Le pseudonyme ne doit pas exceder 30 caractères";
            }
        } //pseudo

        if (isset($post["password"])) {
            $password = htmlspecialchars( trim( $post["password"] ) );

            /* if ( empty($password) ) {
                $this->errors["password"][] = "Le mot de passe est obligatoire";
            } */
           /*  if(!preg_match('`^[[:alnum:]]{4,30}$`',$password)) 
            { 
                $this->errors["password"][] = "Le format du mot de passe n'est pas correct (lettres et chiffres uniquement, de 4 à 30 caractères)";
            } */
            if ( strlen($password) < 4 ) {
                $this->errors["password"][] = "Le mot de passe doit comporter au  moins 4 caractères";
            }
            if ( strlen($password) > 30 ) {
                $this->errors["password"][] = "Le mot de passe ne doit pas excéder 30 caractères";
            }
        }
        if (isset($_POST['passwordCheck'])) {
            $passwordCheck = htmlspecialchars( trim( $post["passwordCheck"] ) );
            $password = htmlspecialchars( trim( $post["password"] ) );
            if ($passwordCheck !== $password) {
                $this->errors["passwordCheck"][] = "Les mots de passe ne correspondent pas";
            }
        }
    }

    /**
     * getErrors returns the errors arrays
     *
     * @return array
     */
    public function getErrors() :array {
        return $this->errors;
    }



    public function renderSignUpView() {


        require 'public/views/front/signUpView.phtml';
    }

    public function renderSignInView() {


        require 'public/views/front/signInView.phtml';
    }

    
    public function logUp(array $post) {
        $firstName = htmlspecialchars(trim($post['firstName']));
        $lastName = htmlspecialchars(trim($post['lastName']));
        $email = htmlspecialchars(trim($post['email']));
        $pseudo = htmlspecialchars(trim($post['pseudo']));
        $password = htmlspecialchars(trim($post['password']));
        $passwordCheck = htmlspecialchars(trim($post['passwordCheck']));
        
        if(isset($post) && count($this->getErrors()) === 0 ) {

            $userModel = new UserModel();
            $userModel->insertUser($post);

            $email = htmlspecialchars(trim($post['email']));
            $password = htmlspecialchars(trim($post['password']));

            $user = $userModel->getUserByMail($email);


            if ($user[0]->password === $password ) {
                
                unset($_SESSION['userSignUp']);

                $_SESSION['user']['email'] = $user[0]->email;
                $_SESSION['user']['firstName'] = $user[0]->firstname;
                $_SESSION['user']['lastName'] = $user[0]->lastname;
                $_SESSION['user']['role'] = $user[0]->role;
                
                header('Location: index.php');
                exit();
            }


            // FAIRE INSCRIPTION
        } else {
            // var_dump($this->getErrors());
            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            var_dump($errorsList);

            $_SESSION['userSignUp']['firstName'] = $firstName;
            $_SESSION['userSignUp']['lastName'] = $lastName;
            $_SESSION['userSignUp']['email'] = $email;
            $_SESSION['userSignUp']['pseudo'] = $pseudo;
            
            header("Location:index.php?action=signUp&error=1&errorslist=$serializeErrorsList");
        }
    }

    public function logIn(array $post) {

        $email = htmlspecialchars(trim($post['email']));
        $password = htmlspecialchars(trim($post['password']));

         if ( !empty($email) && !empty($password) && count($this->getErrors()) === 0 ) {

            $userModel = new UserModel();
            $user = $userModel->getUserByMail($email);

            $this->setCookieOneYear('email', $email);

            if ($user[0]->password === $password ) {

                $_SESSION['user']['email'] = $user[0]->email;
                $_SESSION['user']['firstName'] = $user[0]->firstname;
                $_SESSION['user']['lastName'] = $user[0]->lastname;
                $_SESSION['user']['role'] = $user[0]->role;
                
                header('Location: index.php');
                exit();
            } 
        } else {
            $this->setCookieOneYear('email', $email);

            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            var_dump($errorsList);
            
            header("Location:index.php?action=signIn&error=1&errorslist=$serializeErrorsList");
            // $_SESSION['comments']['message'] = $message;
        }

        
    } //logIn

    public function logOut() {
        session_destroy();

        header("location:index.php?action=home");
    }
}
