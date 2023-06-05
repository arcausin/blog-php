<?php $title = "404 - " . ucfirst($host); ?>

<?php $description = "Il semble que vous ayez trouvé un bug dans la matrice..."; ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<div class="text-center mt-3 mb-3">
    <h1 class="fs-1 mb-3">404</h1>
    <p class="mb-3">Page non trouvée</p>
    <p class="mb-3">Il semble que vous ayez trouvé un bug dans la matrice...</p>
    <a class="text-white animate-opacity" href="/administration">Retour à la page d'accueil du tableau de bord</a>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>