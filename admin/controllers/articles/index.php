<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Article;

$articles = Article::getArticles();

require_once(__DIR__.'/../../views/articles/index.php');