<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use App\Models\Article;
use App\Models\Comment;
use App\Functions;

if (Article::ArticleSlugExists($slug)) {
    $article = Article::getArticle($slug);

    if (isset($_POST['addCommentArticleSubmit']) && isset($_SESSION['user']) && $_SESSION['user']['role'] >= 1) {
        $commentArticle = Functions::validationInput($_POST['comment']);

        if (empty($commentArticle)) {
            $message = "Veuillez ajouter un commentaire à l'article";
            $CommentArticleCreated = false;
        }
        elseif (mb_strlen($commentArticle, 'UTF-8') > 500) {
            $message = "Veuillez ajouter un commentaire avec un maximum de 500 caractères (actuellement ".mb_strlen($commentArticle, 'UTF-8').")";
            $articleCreated = false;
        } else {
            $authorCommentArticle = $_SESSION['user']['id'];
            $uuid = Functions::makeIdPublic();

            $comment = new Comment(
                $authorCommentArticle,
                $article['id'],
                $uuid,
                $commentArticle
            );

            if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 2) {
                if ($comment->addCommentValidate()) {
                    $CommentArticleCreated = true;
                    header('Location: /articles/'.$slug);
                    exit();
                } else {
                    $message = "Une erreur est survenue lors de l'ajout du commentaire";
                    $CommentArticleCreated = false;
                }
            } else {
                if ($comment->addComment()) {
                    $CommentArticleCreated = true;
                    header('Location: /articles/'.$slug);
                    exit();
                } else {
                    $message = "Une erreur est survenue lors de l'ajout du commentaire";
                    $CommentArticleCreated = false;
                }
            }
        }
    }

    if (isset($_POST['validateCommentArticleSubmit']) && isset($_SESSION['user']) && $_SESSION['user']['role'] == 2) {
        $commentValidate = Comment::getComment($_POST['commentUuid']);
        // Only an admin can validate the comment
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 2) {
            $comment = new Comment(
                $commentValidate['id_author'],
                $commentValidate['id_article'],
                $commentValidate['uuid'],
                $commentValidate['comment']
            );

            $comment->id = $commentValidate['id'];

            if ($comment->validateComment()) {
                $CommentArticleValidated = true;
                header('Location: /articles/'.$slug);
                exit();
            } else {
                $message = "Une erreur est survenue lors de la validation du commentaire";
                $CommentArticleValidated = false;
            }
        }
    }

    if (isset($_POST['deleteCommentArticleSubmit']) && isset($_SESSION['user']) && $_SESSION['user']['role'] >= 1) {
        $commentDelete = Comment::getComment($_POST['commentUuid']);
        // Only the author of the comment or an admin can delete the comment
        if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 2 || $_SESSION['user']['id'] == $commentDelete['id_author'])) {
            $comment = new Comment(
                $commentDelete['id_author'],
                $commentDelete['id_article'],
                $commentDelete['uuid'],
                $commentDelete['comment']
            );

            $comment->id = $commentDelete['id'];

            if ($comment->deleteComment()) {
                $CommentArticleDeleted = true;
                header('Location: /articles/'.$slug);
                exit();
            } else {
                $message = "Une erreur est survenue lors de la suppression du commentaire";
                $CommentArticleDeleted = false;
            }
        }
    }
    
    $author = Article::getAuthorByArticle($slug);
    $comments = Comment::getCommentsByArticle($slug);
    $lastArticles = Article::getLastArticles($slug, 2);

    // Only an admin can see all the comments not validate
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 2) {
        $commentsNotValidate = Comment::getCommentsNotValidateByArticle($slug);
    }

    // Only the author of the comments can see their comments not validate
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] >= 1) {
        $commentsUserNotValidate = Comment::getCommentsNotValidateByArticleByAuthor($slug, $_SESSION['user']['id']);
    }
    
    require_once(__DIR__.'/../../views/articles/read.php');
} else {
    header('Location: /articles');
    exit();
}

require_once(__DIR__.'/../../views/articles/index.php');