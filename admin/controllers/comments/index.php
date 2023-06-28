<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Comment;

$commentsNotValidate = Comment::getCommentsNotValidate();

if (isset($_POST['validateCommentArticleSubmit'])) {
    $commentValidate = Comment::getComment($_POST['commentUuid']);
    
    $comment = new Comment(
        $commentValidate['id_author'],
        $commentValidate['id_article'],
        $commentValidate['uuid'],
        $commentValidate['comment']
    );

    $comment->id = $commentValidate['id'];

    if ($comment->validateComment()) {
        $CommentArticleValidated = true;
        header('Location: /administration/commentaires/');
        exit();
    } else {
        $message = "Une erreur est survenue lors de la validation du commentaire";
        $CommentArticleValidated = false;
    }
}

if (isset($_POST['deleteCommentArticleSubmit'])) {
    $commentDelete = Comment::getComment($_POST['commentUuid']);
    
    $comment = new Comment(
        $commentDelete['id_author'],
        $commentDelete['id_article'],
        $commentDelete['uuid'],
        $commentDelete['comment']
    );

    $comment->id = $commentDelete['id'];

    if ($comment->deleteComment()) {
        $CommentArticleDeleted = true;
        header('Location: /administration/commentaires/');
        exit();
    } else {
        $message = "Une erreur est survenue lors de la suppression du commentaire";
        $CommentArticleDeleted = false;
    }
}

require_once(__DIR__.'/../../views/comments/index.php');