<?php

use Admin\Functions;

 $title = "Supprimer un article - " . ucfirst($host); ?>

<?php ob_start(); ?>
<h1>Tableau de bord</h1>
<ul>
    <li><a href="/administration/articles">Articles</a></li>
    <li><a href="/administration/commentaires">Commentaires</a></li>
</ul>
<h2><a href="/">Retourner sur le site web</a></h2>
<hr>
<div class="mb-2">
    <a href="/administration/articles">Retourner sur la liste des articles</a>
</div>

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
    <div class="col-8">
        <h3><strong><?= $article['title']; ?></strong></h3>
        <img class="shadow img-fluid w-100 rounded-4 mb-2" src="/public/img/articles/<?= $article['illustration']; ?>" alt="">
        
        <p class="mb-2"><?= Functions::PrintContentArticle($article['subtitle']); ?></p>

        <hr>

        <p class="mb-2"><?= Functions::PrintContentArticle($article['content']); ?></p>
    </div>

    <div class="col-4 text-center">
        <?php if ($article['validate'] !== 0 || $article['visible'] !== 0) : ?>
            <p class="text-danger">Veuillez d'abord dépublier et invalider l'article avant de le supprimer.</p>
        <?php else : ?>
            <button type="submit" class="btn btn-danger" name="deleteArticleSubmit">Supprimer l'article</button>
        <?php endif ?>
    </div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>