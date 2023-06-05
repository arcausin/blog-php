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
        <?= $content; ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>