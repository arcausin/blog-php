<?php

use App\Models\Article;
use App\Models\Comment;
use App\Functions;

$title = $article['title'] . " - " . ucfirst($host); ?>

<?php $description = "Retrouvez tous les articles du blog - ".ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<div class="row">
    <div class="col-12 col-lg-8">
        <p class="mb-3"><a class="text-dark" href="/">Accueil</a> > <a class="text-dark" href="/articles">Articles</a> > <?= $article['title']; ?></p>

        <h1 class="mb-3"><?= $article['title']; ?></h1>

        <div class="mb-3">
            <p class="mb-0">Par <?= $author['pseudonym']; ?></p>
            <p class="mb-0">Publié le <?= Functions::creationDateLittleEndian($article['creation_date']); ?></p>
            <?php if ($article['update_date'] && Functions::creationDateLittleEndian($article['update_date']) != Functions::creationDateLittleEndian($article['creation_date'])) : ?>
            <p class="mb-0">Mis à jour le <?= Functions::creationDateLittleEndian($article['update_date']); ?></p>
            <?php endif ?>
        </div>

        <img class="shadow img-fluid w-100 rounded-4 mb-3" src="/public/img/articles/<?= $article['illustration']; ?>">

        <div class="fs-6 mb-3"><?= Functions::PrintInput($article['subtitle']); ?></div>

        <hr>

        <div class="fs-6 mb-3"><?= Functions::PrintContentArticle($article['content']); ?></div>

        <hr>

        <?php if(!empty($_SESSION['user']['pseudonym'])) : ?>
            <p class="mb-3">Connecté en tant que : <strong><?= $_SESSION['user']['pseudonym']; ?></strong></p>
        <?php endif ?>

        <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] >= 1) : ?>
            <form class="mb-3" action="" method="POST">
                <div class="mb-3">
                    <textarea class="form-control" name="comment"></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success" name="addCommentArticleSubmit">Ajouter un commentaire</button>
                </div>
            </form>
        <?php else : ?>
            <p class="mb-3"><i>Vous devez être connecté pour ajouter un commentaire.</i> <a href="/connexion">Se connecter</a></p>
        <?php endif ?>

        

        <?php if (!empty($commentsUserNotValidate) && (isset($_SESSION['user']) && $_SESSION['user']['role'] >= 1)) { ?>
            <h2 class="fs-5 mb-3">Vos commentaires en attente de validation</h2>

            <?php foreach ($commentsUserNotValidate as $commentUserNotValidate) {
                $author = Comment::getAuthorByComment($commentUserNotValidate['uuid']);
            ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="mb-0"><b><?= $author['pseudonym']; ?></b> - <?= Functions::creationDateLittleEndian($commentUserNotValidate['creation_date']); ?></p>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-0"><?= Functions::PrintInput($commentUserNotValidate['comment']); ?></p>
                        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $author['id'])) : ?>
                        <form class="text-end" action="" method="POST">
                            <input type="hidden" name="commentUuid" value="<?= $commentUserNotValidate['uuid']; ?>">
                            
                            <button type="submit" class="btn btn-danger" name="deleteCommentArticleSubmit">Supprimer votre commentaire</button>
                        </form>
                    <?php endif ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <?php if (!empty($commentsNotValidate) && (isset($_SESSION['user']) && $_SESSION['user']['role'] == 2)) { ?>
            <h2 class="fs-5 mb-3">Liste des commentaires en attente de validation</h2>

            <?php foreach ($commentsNotValidate as $commentNotValidate) {
                $author = Comment::getAuthorByComment($commentNotValidate['uuid']);
            ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="mb-0"><b><?= $author['pseudonym']; ?></b> - <?= Functions::creationDateLittleEndian($commentNotValidate['creation_date']); ?></p>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-0"><?= Functions::PrintInput($commentNotValidate['comment']); ?></p>
                        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 2)) : ?>
                        <form class="text-end" action="" method="POST">
                            <input type="hidden" name="commentUuid" value="<?= $commentNotValidate['uuid']; ?>">
                            
                            <button type="submit" class="btn btn-success" name="validateCommentArticleSubmit">Valider</button>
                            <button type="submit" class="btn btn-danger" name="deleteCommentArticleSubmit">Supprimer</button>
                        </form>
                    <?php endif ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <h2 class="fs-3 mb-3">Liste des commentaires</h2>
        <?php if (empty($comments)) { ?>
            <p class="mb-3"><i>Aucun commentaire pour le moment.</i></p>
        <?php } ?>

        <?php foreach ($comments as $comment) {
            $author = Comment::getAuthorByComment($comment['uuid']);
        ?>
            <div class="card mb-3">
                <div class="card-header">
                    <p class="mb-0"><b><?= $author['pseudonym']; ?></b> - <?= Functions::creationDateLittleEndian($comment['creation_date']); ?></p>
                </div>
                <div class="card-body">
                    <p class="card-text mb-0"><?= Functions::PrintInput($comment['comment']); ?></p>
                    <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 2 || $_SESSION['user']['id'] == $author['id'])) : ?>
                    <form class="text-end" action="" method="POST">
                        <input type="hidden" name="commentUuid" value="<?= $comment['uuid']; ?>">

                        <button type="submit" class="btn btn-danger" name="deleteCommentArticleSubmit">Supprimer</button>
                    </form>
                <?php endif ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="col-12 col-lg-4">
        <div class="row">
            <div class="col-12 offset-md-2 col-md-8 offset-lg-0 col-lg-12">
                <div class="rounded-4 shadow p-3 mb-3">
                    <div class="row d-flex align-items-center">
                        <div class="col-4">
                            <img src="/public/img/logo.svg" alt="Logo" class="img-fluid">
                        </div>

                        <div class="col-8">
                            <strong class="mb-2">Alexis D'Ambrosio</strong>
                            <p class="mb-2"><i>Développeur Web PHP</i></p>
                            <div class="mb-0">
                                <span><a href="https://github.com/arcausin" target="_blank"><i class="fab fa-github fs-2 ms-2 text-dark"></i></a></span>
                                <span><a href="https://www.linkedin.com/in/alexisdambrosio/" target="_blank"><i class="fab fa-linkedin fs-2 ms-2 text-dark"></i></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <h3 class="mb-3">À lire aussi</h3>

        <div class="row">
            <?php foreach ($lastArticles as $lastArticle) {
                $author = Article::getAuthorByArticle($lastArticle['slug']);
                ?>
                <div class="col-12 col-md-6 col-lg-12 mb-3">
                    <a class="text-decoration-none" href="/articles/<?= $lastArticle['slug']; ?>">
                        <div class="position-relative">
                            <img class="shadow img-fluid w-100 rounded-4" src="/public/img/articles/<?= $lastArticle['illustration']; ?>" alt="" style="filter: brightness(0.85);">
                            <div class="p-3 position-absolute bottom-0">
                                <h2 class="mb-2 fs-4 text-white"><?= $lastArticle['title']; ?></h2>

                                <?php if ($lastArticle['update_date']) : ?>
                                <p class="mb-0 text-white">Le <?= Functions::creationDateLittleEndian($lastArticle['update_date']); ?> Par <?= $author['pseudonym']; ?></p>
                                <?php else : ?>
                                <p class="mb-0 text-white">Le <?= Functions::creationDateLittleEndian($lastArticle['creation_date']); ?> Par <?= $author['pseudonym']; ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>