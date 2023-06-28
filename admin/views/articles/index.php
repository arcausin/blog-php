<?php $title = "Articles - " . ucfirst($host); ?>

<?php ob_start(); ?>
<p class="mb-3"><a class="text-dark" href="/administration">Tableau de bord</a> > Articles</p>

<div class="mb-3">
    <a href="/administration/articles/ajouter">Ajouter un article</a>
</div>

<h3 class="mb-3">Liste des articles</h3>

<div class="row g-4 mb-3">
    <?php foreach ($articles as $article) { ?>
        <div class="col-12 col-md-6">
            <a class="text-decoration-none text-white" href="/administration/articles/<?= $article['slug']; ?>">
                <div class="position-relative">
                    <img class="shadow img-fluid w-100 rounded-4" src="/public/img/articles/<?= $article['illustration']; ?>" alt="" style="filter: brightness(0.85);">
                    <div class="p-3 position-absolute bottom-0">
                        <h3 class="mb-0 fs-4"><?= $article['title']; ?></h3>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>