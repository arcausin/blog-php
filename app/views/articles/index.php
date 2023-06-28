<?php

use App\Models\Article;
use App\Functions;

 $title = "Articles - " . ucfirst($host); ?>

<?php $description = "Retrouvez tous les articles du blog - ".ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<p class="mb-3"><a class="text-dark" href="/">Accueil</a> > Articles</p>

<h1 class="text-center mb-3">ARTICLES</h1>

<div class="row g-4 mb-3">
    <?php foreach ($articles as $article) {
        $author = Article::getAuthorByArticle($article['slug']);
        ?>
        <div class="col-12 col-md-6">
            <a class="text-decoration-none" href="/articles/<?= $article['slug']; ?>">
                <div class="position-relative mb-2">
                    <img class="shadow img-fluid w-100 rounded-4" src="/public/img/articles/<?= $article['illustration']; ?>" alt="" style="filter: brightness(0.85);">
                    <div class="p-3 position-absolute bottom-0">
                        <h2 class="mb-2 fs-4 text-white"><?= $article['title']; ?></h2>

                        <?php if ($article['update_date']) : ?>
                        <p class="mb-0 text-white">Le <?= Functions::creationDateLittleEndian($article['update_date']); ?> Par <?= $author['pseudonym']; ?></p>
                        <?php else : ?>
                        <p class="mb-0 text-white">Le <?= Functions::creationDateLittleEndian($article['creation_date']); ?> Par <?= $author['pseudonym']; ?></p>
                        <?php endif ?>
                    </div>
                </div>
                <p class="text-dark mb-0"><?= Functions::printInput(Functions::PrintContentArticle($article['subtitle'])); ?></p>
            </a>
        </div>
    <?php } ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>