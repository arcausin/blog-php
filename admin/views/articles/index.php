<?php $title = "Articles - " . ucfirst($host); ?>

<?php ob_start(); ?>
<h1>Tableau de bord</h1>
<ul>
    <li><a href="/administration/articles">Articles</a></li>
    <li><a href="/administration/commentaires">Commentaires</a></li>
</ul>
<h2><a href="/">Retourner sur le site web</a></h2>
<hr>
<div class="mb-2">
    <a href="/administration/articles/ajouter">Ajouter un article</a>
</div>

<h3>Liste des articles</h3>

<div class="row g-4 mb-3">
    <?php foreach ($articles as $article) { ?>
        <div class="col-6">
            <a class="text-decoration-none text-white" href="/administration/articles/<?= $article['slug']; ?>">
                <div class="position-relative">
                    <img class="shadow img-fluid rounded-4" src="/public/img/articles/<?= $article['illustration']; ?>" alt="" style="filter: brightness(0.85);">
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