<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Article;
use Admin\Functions;

if (isset($_POST['addArticleSubmit'])) {
    $title = Functions::validationInput($_POST['title']);
    $slug = Functions::slugify($_POST['slug']);
    $slug = Functions::validationInput($slug);
    $subtitle = Functions::validationContentsArticle($_POST['subtitle']);
    $content = Functions::validationContentsArticle($_POST['content']);

    if (empty($title)) {
        $message = "Veuillez ajouter un titre à l'article";
        $articleCreated = false;
    } elseif (empty($slug)) {
        $message = "Veuillez ajouter un slug à l'article";
        $articleCreated = false;
    } elseif (Article::ArticleSlugExists($slug) != 0) {
        $message = "Le slug existe déjà";
        $articleCreated = false;
    } elseif (empty($subtitle)) {
        $message = "Veuillez ajouter un sous-titre à l'article";
        $articleCreated = false;
    } elseif (empty($content)) {
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
                $illustration = Functions::makeIdPublic() . $extension;
                move_uploaded_file($_FILES['illustration']['tmp_name'], $folder . $illustration);

                $authorId = $_SESSION['user']['id'];

                $article = new Article(
                    $authorId,
                    $title,
                    $illustration,
                    $subtitle,
                    $content,
                    $slug
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