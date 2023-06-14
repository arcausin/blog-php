<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use App\Models\Article;
use App\Functions;

$articles = Article::getArticles();

require_once(__DIR__.'/../../views/articles/index.php');