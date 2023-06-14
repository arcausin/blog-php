<?php $title = "Accueil - " . ucfirst($host); ?>

<?php $description = "Retrouvez tous les contenus de " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1>Homepage</h1>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>