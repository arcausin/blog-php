<?php

use App\Functions;

 $title = $article['title'] . " - " . ucfirst($host); ?>

<?php $description = "Retrouvez tous les articles du blog - ".ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<div class="row">
    <div class="col-12 col-lg-8">
        <h1 class="mb-3"><?= $article['title']; ?></h1>

        <div class="mb-3">
            <p class="mb-0">Par <?= $author['pseudonym']; ?></p>
            <p class="mb-0">Publié le <?= Functions::creationDateLittleEndian($article['creation_date']); ?></p>
            <?php if ($article['update_date'] && Functions::creationDateLittleEndian($article['update_date']) != Functions::creationDateLittleEndian($article['creation_date'])) : ?>
            <p class="mb-0">Mis à jour le <?= Functions::creationDateLittleEndian($article['update_date']); ?></p>
            <?php endif ?>
        </div>

        <img class="shadow img-fluid w-100 rounded-4 mb-3" src="/public/img/articles/<?= $article['illustration']; ?>">

        <div class="fs-5 mb-3"><?= Functions::PrintInput($article['subtitle']); ?></div>

        <hr>

        <div class="fs-5 mb-3"><?= Functions::PrintContentArticle($article['content']); ?></div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>