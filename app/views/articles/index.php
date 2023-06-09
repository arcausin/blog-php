<?php

use App\Functions;

 $title = "Articles - " . ucfirst($host); ?>

<?php $description = "Retrouvez tous les articles du blog - ".ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h3>Liste des articles</h3>

<div class="row g-4 mb-3">
    <?php foreach ($articles as $article) { ?>
        <div class="col-12 col-md-6">
            <div class="position-relative mb-2">
                <img class="shadow img-fluid w-100 rounded" src="/public/img/articles/<?= $article['illustration']; ?>" alt="" style="filter: brightness(0.85);">
                <div class="p-3 position-absolute bottom-0">
                    <h3 class="mb-0 fs-4 text-white"><?= $article['title']; ?></h3>
                </div>
            </div>
            <p><?= Functions::printInput(Functions::PrintContentArticle($article['subtitle'])); ?> <a class="text-decoration-none" href="/articles/<?= $article['slug']; ?>">Lire la suite</a></p>
        </div>
    <?php } ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>