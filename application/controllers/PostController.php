<?php
namespace Ariwf3\Blog_oop\Application\Controllers;
use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Controllers\UserController;

class PostController {

    private $errors = array();

    /**
     * setErrors 
     * 
     * Checks the integrity of user data and builds arrays with errors found (checks title and post)
     *
     * @param  array $post
     *
     * @return void
     */
    public function setErrors(array $post) {

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

    /**
     * renderAddPostView 
     * 
     * returns the view "addPostView" : Page with the form to add a post if connected
     *
     * @return void
     */
    public function renderAddPostView() {
            $userController = new UserController();
            $userController->redirectIfNotConnected();

            require 'public/views/back/addPostView.phtml';
    }

    /**
     * addPost 
     * 
     * adds a post with the user id and user datas($post), redirects if it finds errors with array sessions of errors
     *
     * @param  int $userId
     * @param  array $post
     *
     * @return void
     */
    public function addPost(int $userId, array $post) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        if ( count($this->getErrors() ) == 0) {

            unset($_SESSION['userAddPost']);

            $postModel = new PostModel();
            $postModel->insertPost($userId, $post);
            $role = $_SESSION['user']['role'];
            header("Location: index.php?action=account&id=$userId");
        } else {
            $userController->redirectIfNotConnected();
            $_SESSION['userAddPost']['title'] = htmlspecialchars($post['title']);
            $_SESSION['userAddPost']['post'] = htmlspecialchars($post['post']);

            $_SESSION['userAddPost']['errors'] = $this->getErrors();
            
            header("Location:index.php?id=$userId&action=addPostView");
        }
        
    }

    /**
     * renderEditPostView 
     * 
     * returns the view "editPostView" : Page with the form to edit a post according to its post id if connected
     *
     * @param int $postId
     *
     * @return void
     */
    public function renderEditPostView(int $postId) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php');
        } else {
            $postModel = new PostModel();
            $post = $postModel->getOnepost($postId);
            require 'public/views/back/editPostView.phtml';
        }
    }

    /**
     * editPost 
     * 
     * edits a post with the post id and user datas($post) and redirects to accountPage, redirects if it finds errors
     *
     * @param  int $postId
     * @param  array $post
     *
     * @return void
     */
    public function editPost(int $postId, array $post) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        if ( count($this->getErrors() ) == 0) {
            $postModel = new PostModel();
            $postModel->updatePost($postId, $post);

            $role = $_SESSION['user']['role'];
            $userId = $_SESSION['user']['id'];

            header("Location: index.php?action=account&id=$userId");

        } else {
            
            $_SESSION['userEditPost']['errors'] = $this->getErrors();

            header("Location:index.php?id=$postId&action=editPostView");
        }
    }

    /**
     * removePost 
     * 
     * deletes a post with the post id and redirects to the accountPage
     *
     * @param  mixed $postId
     *
     * @return void
     */
    public function removePost(int $postId) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        $postModel = new PostModel();
        $postModel->deletePost($postId);

        $role = $_SESSION['user']['role'];
        $userId = $_SESSION['user']['id'];

        header("Location: index.php?action=account&id=$userId");
    }

}