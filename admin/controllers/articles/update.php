<?php
require_once(__DIR__.'/../../../vendor/autoload.php');

use Admin\Models\Article;
use Admin\Functions;

if (Article::ArticleSlugExists($slug)) {
    $article = Article::getArticle($slug);

    $author = Article::getAuthorByArticle($slug);
    $authors = Article::getAuthors();

    if (isset($_POST['updateArticleSubmit'])) {
        $title = Functions::validationInput($_POST['title']);
        $slug = Functions::slugify($_POST['slug']);
        $slug = Functions::validationInput($slug);
        $subtitle = Functions::validationContentsArticle($_POST['subtitle']);
        $content = Functions::validationContentsArticle($_POST['content']);
        $author = Functions::validationInput($_POST['author']);
        
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

        if (empty($title)) {
            $message = "Veuillez ajouter un titre à l'article";
            $articleUpdated = false;
        } elseif (empty($slug)) {
            $message = "Veuillez ajouter un slug à l'article";
            $articleUpdated = false;
        } elseif (Article::ArticleSlugExists($slug) != 0 && $article['slug'] != $slug) {
            $message = "Le slug existe déjà";
            $articleUpdated = false;
        } elseif (empty($subtitle)) {
            $message = "Veuillez ajouter un sous-titre à l'article";
            $articleUpdated = false;
        } elseif (empty($content)) {
            $message = "Veuillez ajouter un contenu à l'article";
            $articleUpdated = false;
        } elseif (empty($author)) {
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
                        $illustration = Functions::makeIdPublic() . $extension;
                        move_uploaded_file($_FILES['illustration']['tmp_name'], $folder . $illustration);

                        $articleUpdate = new Article(
                            $author,
                            $title,
                            $illustration,
                            $subtitle,
                            $content,
                            $slug
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
                $illustration = $article['illustration'];

                $articleUpdate = new Article(
                    $author,
                    $title,
                    $illustration,
                    $subtitle,
                    $content,
                    $slug
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

    require_once(__DIR__.'/../../views/articles/update.php');
} else {
    header('Location: /administration/articles');
    exit();
}