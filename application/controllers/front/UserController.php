<?php
namespace Ariwf3\Blog_oop\Application\Controllers\Front;

use Ariwf3\Blog_oop\Application\Models\UserModel;
use Ariwf3\Blog_oop\Application\Models\PostModel;

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
                // var_dump($user->email);
                if ($user->email === $email ) {
                    $this->errors["email"][] = "L'adresse email existe déja";
                } 
            }
            
        } //email signUp

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
            
        } //email signIn


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
        if (isset($post['passwordCheck'])) {
            $passwordCheck = htmlspecialchars( trim( $post["passwordCheck"] ) );
            $password = htmlspecialchars( trim( $post["password"] ) );
            if ($passwordCheck !== $password) {
                $this->errors["passwordCheck"][] = "Les mots de passe ne correspondent pas";
            }
        }

        if (isset($post['title'])) {
            $title = htmlspecialchars( trim( $post["title"] ) );
            if ( strlen($title) < 3 ) {
                $this->errors["title"][] = "Le titre doit comporter au moins 3 caractères";
            }
        }
        if (isset($post['post'])) {
            $title = htmlspecialchars( trim( $post["post"] ) );
            if ( strlen($title) < 15 ) {
                $this->errors["tiposttle"][] = "Le billet doit comporter au moins 15 caractères";
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


    public function logUp(array $post) {
        $firstName = htmlspecialchars(trim($post['firstName']));
        $lastName = htmlspecialchars(trim($post['lastName']));
        $pseudo = htmlspecialchars(trim($post['pseudo']));
        $email = htmlspecialchars(trim($post['emailSignUp']));
        $password = htmlspecialchars(trim($post['password']));
        $passwordCheck = htmlspecialchars(trim($post['passwordCheck']));
        
        if(isset($post) && count($this->getErrors()) === 0 ) {

            $userModel = new UserModel();
            $userModel->insertUser($post);

            $email = htmlspecialchars(trim($post['emailSignUp']));
            $password = htmlspecialchars(trim($post['password']));
            

            //logIn after signUp
            // $this->login($post);
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
            }
        

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
    } // end public function logup

    public function logIn(array $post) {

        $email = htmlspecialchars(trim($post['emailSignIn']));
        $password = htmlspecialchars(trim($post['password']));

        if ( !empty($email) && !empty($password) && count($this->getErrors()) === 0 ) {

            //cookie email
            $this->setCookieOneYear('email', $email);

            //we select the eser by email
            $userModel = new UserModel();
            $user = $userModel->getUserByMail($email);
            
            $hashedPassword = $user[0]->password;
            
            //if correct password session is created
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
                // wrong password we send the error
                $this->setCookieOneYear('email', $email);

                $this->errors['password'][] = "Mauvais mot de passe";
                $errorsList = $this->getErrors();
                $serializeErrorsList = serialize($errorsList);
                    
                header("Location:index.php?action=signIn&error=1&errorslist=$serializeErrorsList");
            } 

        } else { //errors found we send the errors

            $this->setCookieOneYear('email', $email);

            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            var_dump($errorsList);
            
            header("Location:index.php?action=signIn&error=1&errorslist=$serializeErrorsList");
            
        } // end count errors

        
    } //logIn public function


    public function logOut() {
        session_destroy();

        header("location:index.php?action=home");
    }


    public function renderSignUpView() {
    require 'public/views/front/signUpView.phtml';
    }

    public function renderSignInView() {
        require 'public/views/front/signInView.phtml';
    }

    public function renderAccountView() {

        if (!isset($_SESSION['user'])) {
            header('Location: index.php');
        }
        $postModel = new PostModel();
        $posts = $postModel->getPostsByUser($_SESSION['user']['id']);
        var_dump($posts);
        require 'public/views/front/accountView.phtml';
    }

    public function renderAddPostView() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php');
        }

        require 'public/views/front/addPostView.phtml';
    }

    public function addPost(int $userId, array $post) {

        if ( count($this->getErrors() ) == 0) {
            $postModel = new PostModel();
            $postModel->insertPost($userId, $post);
            $role = $_SESSION['user']['role'];
            header("Location: index.php?action=account&id=$userId&role=$role");
        } else {
            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            var_dump($errorsList);
            // $userId = $_SESSION['user']['id'];
            header("Location:index.php?id=$userId&action=addPostView&error=1&errorslist=$serializeErrorsList");
        }
        
    }

    public function renderEditPostView(int $postId) {

        if (!isset($_SESSION['user'])) {
            header('Location: index.php');
        }

        $postModel = new PostModel();
        
        $post = $postModel->getOnepost($postId);

        require 'public/views/front/editPostView.phtml';
    }

    public function editPost(int $postId, array $post) {

        if ( count($this->getErrors() ) == 0) {
            $postModel = new PostModel();
            $postModel->updatePost($postId, $post);

            $role = $_SESSION['user']['role'];
            $userId = $_SESSION['user']['id'];

            header("Location: index.php?action=account&id=$userId&role=$role");

        } else {
            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            // $userId = $_SESSION['user']['id'];
       
            header("Location:index.php?id=$postId&action=editPostView&error=1&errorslist=$serializeErrorsList");
         }
    }

    public function removePost(int $postId) {

        $postModel = new PostModel();
        $postModel->deletePost($postId);

        $role = $_SESSION['user']['role'];
        $userId = $_SESSION['user']['id'];

        header("Location: index.php?action=account&id=$userId&role=$role");
    }
}
