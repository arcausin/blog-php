<?php $title = "Tableau de bord - " . ucfirst($host); ?>

<?php ob_start(); ?>
<h1 class="mt-5 mb-3 text-center">Tableau de bord</h1>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>