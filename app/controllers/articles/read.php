<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use App\Models\Article;
use App\Functions;

if (Article::ArticleSlugExists($slug)) {
    $article = Article::getArticle($slug);
    $author = Article::getAuthorByArticle($slug);
    
    require_once(__DIR__.'/../../views/articles/read.php');
} else {
    header('Location: /articles');
    exit();
}

require_once(__DIR__.'/../../views/articles/index.php');