<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Article;
use Admin\Functions;

if (isset($_POST['addArticleSubmit'])) {
    $titleArticle = Functions::validationInput($_POST['title']);
    $slugArticle = Functions::slugify($_POST['slug']);
    $slugArticle = Functions::validationInput($slugArticle);
    $subtitleArticle = Functions::validationInput($_POST['subtitle']);
    $contentArticle = Functions::validationContentArticle($_POST['content']);

    if (empty($titleArticle)) {
        $message = "Veuillez ajouter un titre à l'article";
        $articleCreated = false;
    } elseif (empty($slugArticle)) {
        $message = "Veuillez ajouter un slug à l'article";
        $articleCreated = false;
    } elseif (Article::ArticleSlugExists($slugArticle) != 0) {
        $message = "Le slug existe déjà";
        $articleCreated = false;
    } elseif (empty($subtitleArticle)) {
        $message = "Veuillez ajouter un sous-titre à l'article";
        $articleCreated = false;
    } elseif (mb_strlen($subtitleArticle, 'UTF-8') > 255) {
        $message = "Veuillez ajouter un sous-titre à l'article avec un maximum de 255 caractères (actuellement ".mb_strlen($subtitleArticle, 'UTF-8').")";
        $articleCreated = false;
    } elseif (empty($contentArticle)) {
        $message = "Veuillez ajouter un contenu à l'article";
        $articleCreated = false;
    } elseif (empty($_FILES['illustration']['name'])) {
        $message = "Veuillez ajouter une illustration à l'article";
        $articleCreated = false;
    } else {
        if (!Functions::checkErrorUploadFile($_FILES['illustration'])) {
            if (!Functions::checkImageTypeUploadFile($_FILES['illustration'])) {
                $message = "extension de fichier non autorisé";
                $articleCreated = false;
            } else {
                $folder = __DIR__.'/../../../public/img/articles/';

                $extension = Functions::checkImageTypeUploadFile($_FILES['illustration']);
                $illustrationArticle = Functions::makeIdPublic() . $extension;
                move_uploaded_file($_FILES['illustration']['tmp_name'], $folder . $illustrationArticle);

                $authorArticle = $_SESSION['user']['id'];

                $article = new Article(
                    $authorArticle,
                    $titleArticle,
                    $illustrationArticle,
                    $subtitleArticle,
                    $contentArticle,
                    $slugArticle
                );
                
                if ($article->addArticle()) {
                    $articleCreated = true;
                    header('Location: /administration/articles');
                    exit();
                } else {
                    $message = "Inconnue";
                    $articleCreated = false;
                }
            }
        } else {
            $message = Functions::checkErrorUploadFile($_FILES['illustration']);
            $articleCreated = false;
        }
    }
}

require_once(__DIR__.'/../../views/articles/create.php');