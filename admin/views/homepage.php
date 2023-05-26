<?php $title = "Tableau de bord - " . ucfirst($host); ?>

<?php ob_start(); ?>
<h1>Tableau de bord</h1>
<h2><a href="/">Homepage</a></h2>
<ul>
    <li><a href="/administration/articles">Articles</a></li>
    <li><a href="/administration/commentaires">Commentaires</a></li>
</ul>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>