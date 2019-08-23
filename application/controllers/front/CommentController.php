<?php

namespace Ariwf3\Blog_oop\Application\Controllers\Front;

use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Models\CommentModel;

class CommentController {


    private $errors = array();


    /**
     * setErrors Checks the integrity of user data and builds arrays with errors found
     *
     * @param  array $post
     *
     * @return void
     */
    public function setErrors(array $post) {

        $author = htmlspecialchars( trim( $post["author"] ) );
        $message = htmlspecialchars( trim( $post["message"] ) );

        if (empty($author)) {
            $this->errors["author"][] = "Le nom est obligatoire";
        }
        
        if (strlen($author) < 2) {
            $this->errors["author"][] = "Le nom doit comporter au  moins 2 caractères";
        }
        
        if(!preg_match('`^[[:alnum:]]{2,30}$`',$author)) // alphanumeric characters between 2 and 30
        { 
           $this->errors["author"][] = "Le format du nom n'est pas correct (lettres et chiffres uniquement, 30 caractères maximum)"; 
        } 
        
        
        if (empty($message))  {
            $this->errors["message"][] = "Le message est obligatoire";
        }
        
        if (strlen($message) < 5) {
            $this->errors["message"][] = "Le message doit comporter au  moins 5 caractères";
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

    /**
     * renderCommentView returns the view "commentView" : A post and its comments using the post id
     *
     * @param  int $post_id
     *
     * @return void
     */
    public function renderCommentView(int $post_id) {

        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getOnepost($post_id);
        
        $comments = $commentModel->getComments($post_id);

        require 'public/views/front/commentView.phtml';
    }

    

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
     * addComment Insert the comment before redirecting if no user errors found, redirect with the error arrays in serialized form if at least one user error is found
     *
     * @param  int $post_id
     * @param  array $post
     *
     * @return void
     */
    public function addComment(int $post_id, array $post) {

        $id = $post_id;
        $author = htmlspecialchars(trim($post['author']));
        $message = htmlspecialchars(trim($post['message']));
        
        if ( !empty($author) && !empty($message) && count($this->getErrors()) === 0 ) {
            
            $commentModel = new CommentModel();
            $commentModel->insertComment($id, $post);
            $this->setCookieOneYear('author', $author);

            header("Location:index.php?action=comments&id=$id");
            exit();
        } else {
            
            $this->setCookieOneYear('author', $author);

            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            
            $_SESSION['comments']['message'] = $message;
            
            header("Location:index.php?action=comments&id=$id&error=1&errorslist=$serializeErrorsList");
            exit();
        }
        

    }

    
}