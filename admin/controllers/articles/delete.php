<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Article;

if (Article::ArticleSlugExists($slug)) {
    $article = Article::getArticle($slug);

    $articleDelete = new Article(
        $article['id_author'],
        $article['title'],
        $article['illustration'],
        $article['subtitle'],
        $article['content'],
        $article['slug']
    );

    $articleDelete->id = $article['id'];

    if (isset($_POST['deleteArticleSubmit'])) {
        if ($article['validate'] !== 0 || $article['visible'] !== 0) {
            $message = "Vous ne pouvez pas supprimer un article validé et ou visible";
            $articleDeleted = false;
        } else {
            if ($articleDelete->deleteArticle()) {
                unlink(__DIR__.'/../../../public/img/articles/'.$article['illustration']);
                $articleDeleted = true;
                header('Location: /administration/articles');
                exit();
            } else {
                $message = "Inconnue";
                $articleDeleted = false;
            }
        }
        
    }

    require_once(__DIR__.'/../../views/articles/delete.php');
} else {
    header('Location: /administration/articles');
    exit();
}