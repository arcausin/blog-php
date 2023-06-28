<?php
require_once(__DIR__.'/../../config/apiKeys.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tiny.cloud/1/<?= $keyTinyMCE; ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
                <a class="navbar-brand d-flex align-items-center" href="/administration">
                    <img src="/public/img/logo.svg" alt="Logo" width="46" height="36.65" class="d-inline-block align-text-top me-2">
                    <span>Tableau de bord</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link ps-0" href="/administration/articles"><u>Articles</u></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/administration/commentaires"><u>Commentaires</u></a>
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
                <p class="fs-4"><a class="text-decoration-none text-dark" href="/">Aller sur le site web</a></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>