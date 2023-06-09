<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Search Engine -->
    <meta name="description" content="<?= $description; ?>">
    <meta name="image" content="<?= $image; ?>">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="<?= $title; ?>">
    <meta itemprop="description" content="<?= $description; ?>">
    <meta itemprop="image" content="<?= $image; ?>">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= $title; ?>">
    <meta name="twitter:description" content="<?= $description; ?>">
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta name="og:title" content="<?= $title; ?>">
    <meta name="og:description" content="<?= $description; ?>">
    <?php if (isset($article)) { ?> <meta name="og:image" content="<?= $article['illustration']; ?>"> <?php ; } ?>
    <meta name="og:url" content="<?= $urlNative; ?>">
    <meta name="og:site_name" content="Neteyam">
    <meta name="og:locale" content="fr_FR">
    <meta name="og:type" content="<?php if (isset($article)) { echo "article"; } else { echo "website"; } ?>">

    <?php if (isset($article)) { ?>
        <!-- Open Graph - Article -->
        <meta name="article:section" content="<?= $categoryArticle['name']; ?>">
        <meta name="article:published_time" content="<?= $article['creation_date']; ?>">
        <meta name="article:author" content="<?= $author['pseudonym']; ?>">

        <?php if (isset($article['update_date']) && $article['update_date'] != null) { ?>
            <meta name="article:modified_time" content="<?= $article['update_date']; ?>">
        <?php ; } ?>
    <?php ; } ?>
    
    <title><?= $title; ?></title>
</head>
<body>
    <main class="container">
        <p class="mt-3 mb-3"><?php if (!empty($_SESSION['user']['pseudonym'])) : ?><?= "connecté en tant que : ".$_SESSION['user']['pseudonym']; ?><?php endif ?></p>

        <nav class="navbar navbar-expand-md navbar-light bg-light mb-3">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/a-propos">À Propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/articles">Articles</a>
                        </li>

                        <?php if (empty($_SESSION['user'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/connexion">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inscription">S'inscrire</a>
                        </li>
                        <?php endif ?>

                        <?php if (!empty($_SESSION['user'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/mon-compte">Mon compte</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/deconnexion">Déconnexion</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?= $content; ?>
        <nav>
            <ul>
                <li><a href="/mentions-legales">Mentions légales</a></li>
                <li><a href="/politique-de-confidentialite">Politique de confidentialité</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </nav>

        <h2><a href="/administration">Tableau de bord</a></h2>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>