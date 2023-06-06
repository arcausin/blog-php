<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Article;

if (Article::ArticleSlugExists($slug)) {
    $article = Article::getArticle($slug);
    $author = Article::getAuthorByArticle($slug);
    
    require_once(__DIR__.'/../../views/articles/read.php');
} else {
    header('Location: /administration/articles');
    exit();
}