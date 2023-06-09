<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Article;
use Admin\Functions;

if (Article::ArticleSlugExists($slug)) {
    $article = Article::getArticle($slug);

    $author = Article::getAuthorByArticle($slug);
    $authors = Article::getAuthors();

    if (isset($_POST['updateArticleSubmit'])) {
        $titleArticle = Functions::validationInput($_POST['title']);
        $slugArticle = Functions::slugify($_POST['slug']);
        $slugArticle = Functions::validationInput($slugArticle);
        $subtitleArticle = Functions::validationInput($_POST['subtitle']);
        $contentArticle = Functions::validationContentArticle($_POST['content']);
        $authorArticle = Functions::validationInput($_POST['author']);
        
        if (isset($_POST['validate']) && $_POST['validate'] == 'on') {
            $validate = 1;
        } else {
            $validate = 0;
        }

        if (isset($_POST['visible']) && $_POST['visible'] == 'on') {
            $visible = 1;
        } else {
            $visible = 0;
        }

        if (empty($titleArticle)) {
            $message = "Veuillez ajouter un titre à l'article";
            $articleUpdated = false;
        } elseif (empty($slugArticle)) {
            $message = "Veuillez ajouter un slug à l'article";
            $articleUpdated = false;
        } elseif (Article::ArticleSlugExists($slugArticle) != 0 && $article['slug'] != $slugArticle) {
            $message = "Le slug existe déjà";
            $articleUpdated = false;
        } elseif (empty($subtitleArticle)) {
            $message = "Veuillez ajouter un sous-titre à l'article";
            $articleUpdated = false;
        } elseif (mb_strlen($subtitleArticle, 'UTF-8') > 255) {
            $message = "Veuillez ajouter un sous-titre à l'article avec un maximum de 255 caractères (actuellement ".mb_strlen($subtitleArticle, 'UTF-8').")";
            $articleUpdated = false;
        } elseif (empty($contentArticle)) {
            $message = "Veuillez ajouter un contenu à l'article";
            $articleUpdated = false;
        } elseif (empty($authorArticle)) {
            $message = "Veuillez ajouter un auteur à l'article";
            $articleUpdated = false;
        } else {
            if ($_FILES['illustration']['error'] != 4) {
                if (!Functions::checkErrorUploadFile($_FILES['illustration'])) {
                    if (!Functions::checkImageTypeUploadFile($_FILES['illustration'])) {
                        $message = "extension de fichier non autorisé";
                        $articleUpdated = false;
                    } else {
                        $folder = __DIR__.'/../../../public/img/articles/';
            
                        $extension = Functions::checkImageTypeUploadFile($_FILES['illustration']);
                        $illustrationArticle = Functions::makeIdPublic() . $extension;
                        move_uploaded_file($_FILES['illustration']['tmp_name'], $folder . $illustrationArticle);

                        $articleUpdate = new Article(
                            $authorArticle,
                            $titleArticle,
                            $illustrationArticle,
                            $subtitleArticle,
                            $contentArticle,
                            $slugArticle
                        );

                        $articleUpdate->id = $article['id'];
                        $articleUpdate->validate = $validate;
                        $articleUpdate->visible = $visible;

                        if ($articleUpdate->updateArticle()) {
                            unlink(__DIR__.'/../../../public/img/articles/'.$article['illustration']);
                            $articleUpdated = true;
                            header('Location: /administration/articles');
                            exit();
                        } else {
                            $message = "Inconnue";
                            $articleUpdated = false;
                        }
                    }
                } else {
                    $message = Functions::checkErrorUploadFile($_FILES['illustration']);
                    $articleUpdated = false;
                }
            } else {
                $illustrationArticle = $article['illustration'];

                $articleUpdate = new Article(
                    $authorArticle,
                    $titleArticle,
                    $illustrationArticle,
                    $subtitleArticle,
                    $contentArticle,
                    $slugArticle
                );

                $articleUpdate->id = $article['id'];
                $articleUpdate->validate = $validate;
                $articleUpdate->visible = $visible;

                if ($articleUpdate->updateArticle()) {
                    $articleUpdated = true;
                    header('Location: /administration/articles');
                    exit();
                } else {
                    $message = "Inconnue";
                    $articleUpdated = false;
                }
            }
        }
    }

    $article = Article::getArticle($slug);

    $author = Article::getAuthorByArticle($slug);

    require_once(__DIR__.'/../../views/articles/update.php');
} else {
    header('Location: /administration/articles');
    exit();
}