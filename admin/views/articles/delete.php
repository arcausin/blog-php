<?php

use Admin\Functions;

 $title = "Supprimer un article - " . ucfirst($host); ?>

<?php ob_start(); ?>
<p class="mb-3"><a class="text-dark" href="/administration">Tableau de bord</a> > <a class="text-dark" href="/administration/articles">Articles</a> > <a class="text-dark" href="/administration/articles/<?= $article['slug']; ?>"><?= $article['title']; ?></a> > Supprimer</p>

<?php if (isset($articleDeleted)) : ?>
    <?php if ($articleDeleted == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Suppression de l'article échoué !<br/>
            Erreur</strong> : <?= $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
<?php endif ?>

<h3 class="text-danger mb-3">Suppression de l'article</h3>

<form class="row mb-3" action="" method="post" enctype="multipart/form-data">
    <div class="col-12 col-lg-8">
        <h3><strong><?= $article['title']; ?></strong></h3>
        <img class="shadow img-fluid w-100 rounded-4 mb-2" src="/public/img/articles/<?= $article['illustration']; ?>" alt="">
        
        <p class="mb-2"><?= Functions::PrintContentArticle($article['subtitle']); ?></p>

        <hr>

        <p class="mb-2"><?= Functions::PrintContentArticle($article['content']); ?></p>
    </div>

    <div class="col-12 col-lg-4 text-center">
        <?php if ($article['validate'] !== 0 || $article['visible'] !== 0) : ?>
            <p class="text-danger">Veuillez d'abord dépublier et invalider l'article avant de le supprimer.</p>
        <?php else : ?>
            <button type="submit" class="btn btn-danger" name="deleteArticleSubmit">Supprimer l'article</button>
        <?php endif ?>
    </div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>