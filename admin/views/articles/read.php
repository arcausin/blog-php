<?php

use Admin\Functions;

 $title = $article['title'].'-'.ucfirst($host); ?>

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

<div class="row">
    <div class="col-8">
        <h3 class="mb-3"><strong><?= $article['title']; ?></strong></h3>

        <img class="shadow img-fluid w-100 rounded-4 mb-3" src="/public/img/articles/<?= $article['illustration']; ?>" alt="" style="filter: brightness(0.85);">

        <p class="mb-3"><?= Functions::PrintContentArticle($article['subtitle']); ?></p>

        <hr>

        <p class="mb-3"><?= Functions::PrintContentArticle($article['content']); ?></p>
    </div>

    <div class="col-4">
        <div class="mb-3">
            <a class="d-inline-block btn btn-warning text-white" href="/administration/articles/modifier/<?= $article['slug']; ?>">
                <i class="fas fa-edit"><span class="ms-1">Modifier</span></i>
            </a>

            <a class="d-inline-block btn btn-danger text-white" href="/administration/articles/supprimer/<?= $article['slug']; ?>">
                <i class="fas fa-trash"><span class="ms-1">Supprimer</span></i>
            </a>
        </div>

        <div class="mb-3">
            <p class="mb-0">Valider :
            <?php if ($article['validate'] !== 0) : ?>
                <span style="color:green">oui</span>
            <?php else : ?>
                <span style="color:red">non</span>
            <?php endif ?>
            </p>

            <p class="mb-0">En ligne :
            <?php if ($article['visible'] !== 0) : ?>
                <span style="color:green">oui</span>
            <?php else : ?>
                <span style="color:red">non</span>
            <?php endif ?>
            </p>
        </div>

        <div class="mb-3">
            <p class="mb-0">Auteur : <?= $author['pseudonym']; ?></p>
            <p class="mb-0">Publié le : <?= Functions::creationDateLittleEndian($article['creation_date']); ?></p>
            <?php if ($article['update_date'] !== null) { ?>
                <p class="mb-0">Mis à jour le : <?= Functions::creationDateLittleEndian($article['update_date']); ?></p>
            <?php } ?>
        </div>
    </div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>