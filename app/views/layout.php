<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

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

    <style>
        .shadow-top {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        }

        .shadow-bottom {
            box-shadow: 0 -.5rem 1rem rgba(0,0,0,.15);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let windowHeight = window.innerHeight;

            let headerHeight = document.querySelector("#header-content").offsetHeight;

            let footerHeight = document.querySelector("#footer-content").offsetHeight;

            let bodyHeight = windowHeight - footerHeight;

            // Ajouter la hauteur de la barre de navigation au "padding-top" du conteneur de contenu
            document.querySelector("#main-content").style.paddingTop = headerHeight + "px";
            document.querySelector("#main-content").style.minHeight = bodyHeight + "px";
        });
    </script>
</head>
<body>
    <header class="shadow-top fixed-top" id="header-content">
        <nav class="container-fluid navbar navbar-expand-md navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="/public/img/logo.png" alt="Logo" width="50" height="25" class="rounded-5 d-inline-block align-text-top me-2">
                    <span>Alexis D'Ambrosio</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link ps-0" href="/"><u>À Propos</u></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/articles"><u>Articles</u></a>
                        </li>

                        <?php if (!empty($_SESSION['user'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link pe-0" href="/deconnexion">Déconnexion</a>
                            </li>
                            <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/connexion">Se connecter</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pe-0" href="/inscription">S'inscrire</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container" id="main-content">
        <?php if(!empty($_SESSION['user']['pseudonym'])) : ?>
            <p class="mt-3 mb-3">Connecté en tant que : <strong><?= $_SESSION['user']['pseudonym']; ?></strong></p>
        <?php else : ?>
            <div class="mt-3"></div>
        <?php endif ?>
        
        <?= $content; ?>

        <div class="mb-3"></div>
    </main>

    <footer class="shadow-bottom" id="footer-content">
        <div class="container">
            <div class="text-center py-3">
                <p class="mb-3">ME SUIVRE</p>
                <span><a href="https://github.com/arcausin" target="_blank"><i class="fab fa-github fs-2 ms-2 text-dark"></i></a></span>
                <span><a href="https://www.linkedin.com/in/alexisdambrosio/" target="_blank"><i class="fab fa-linkedin fs-2 ms-2 text-dark"></i></a></span>
        
                <hr>

                <p><?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 2) : ?>
                    <a class="text-dark" href="/administration">Tableau de bord</a> | <?php endif ?><a class="text-dark" href="#">Mentions légales</a> | <a class="text-dark" href="#">Politique de confidentialité</a> | <a class="text-dark" href="/contact">Contact</a></p>
                <p class="fs-4"><a class="text-decoration-none text-dark" href="/"><?= ucfirst($host); ?></a></p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>