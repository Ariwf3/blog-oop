<?php

namespace Ariwf3\Blog_oop\Application\Controllers\Front;

use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Models\CommentModel;

class CommentController {

    /**
     * renderCommentView returns the view "commentView" : A post and its comments using the post id
     *
     * @param  mixed $post_id
     *
     * @return void
     */
    public function renderCommentView(int $post_id) {

        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getOnePost($post_id);
        
        $comments = $commentModel->getComments($post_id);


        require 'public/views/front/commentView.phtml';
    }

    
}