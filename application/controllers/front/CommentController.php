<?php

namespace Ariwf3\Blog_oop\Application\Controllers\Front;
use Ariwf3\Blog_oop\Application\Controllers\Front\UserController;

use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Models\CommentModel;

class CommentController {


    private $errors = array();


    /**
     * setErrors Checks the integrity of user data and builds arrays with errors found (author, message)
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
        
        // regex alphanumeric and accented characters, spaces between 2 and 30
        if(!preg_match('`^[[:alnum:]áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ!?\s]{2,30}$`',$author)) 
        { 
           $this->errors["author"][] = "Le format du nom n'est pas correct (lettres et chiffres uniquement, 2 caractères minimum, 30 caractères maximum)"; 
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
     * addComment Insert the comment before redirecting if no user errors found, redirect with the error arrays in serialized form if at least one user error is found
     *
     * @param  int $post_id
     * @param  array $post
     *
     * @return void
     */
    public function addComment(int $post_id, array $post) {

        $id = $post_id;
        $author = trim($post['author']);
        $message = trim($post['message']);
        
        if ( !empty($author) && !empty($message) && count($this->getErrors()) === 0 ) {
            
            $commentModel = new CommentModel();
            $commentModel->insertComment($id, $post);

            $userController = new UserController();
            $userController->setCookieOneYear('author', htmlspecialchars($author));
            unset($_SESSION['comments']);

            header("Location:index.php?action=comments&id=$id");
            exit();
        } else {
            
            $userController = new UserController();
            $userController->setCookieOneYear('author', htmlspecialchars($author));
            
            $_SESSION['comments']['message'] = htmlspecialchars($message);
            $_SESSION['comments']['errors'] = $this->getErrors();
            
            header("Location:index.php?action=comments&id=$id");
            exit();
        }
        

    }

    
}