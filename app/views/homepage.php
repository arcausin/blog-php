<?php $title = "Accueil - " . ucfirst($host); ?>

<?php $description = "Retrouvez tous les contenus de " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1 class="text-center mt-5 mb-5">Alexis D'Ambrosio</h1>
<h2 class="text-center mt-5 mb-5"><strong>Développeur web PHP</strong></h2>
<h2 class="fs-4 text-center mt-5 mb-5"><i>Explorez mon univers digital où compétences techniques, créativité et passion se rencontrent pour donner vie à des projets web exceptionnels.</i></h2>
<p class="fs-4 text-center mt-5 mb-3"><a class="text-dark" href="/">Télécharger mon CV</a></p>
<p class="fs-1 text-center"><i class="fas fa-book"></i></p>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>