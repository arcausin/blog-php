<?php $title = "Accueil - " . ucfirst($host); ?>

<?php $description = "Retrouvez tous les contenus de " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1>Homepage</h1>
<?php if (!empty($_SESSION['user']['pseudonym'])) : ?><?= $_SESSION['user']['pseudonym']; ?><?php endif ?>
<nav>
    <ul>
        <li><a href="/">Accueil</a></li>
        <li><a href="/a-propos">À Propos</a></li>
        <li><a href="/articles">Articles</a></li>
        <li><a href="/articles/read">Articles/Read</a></li>
    </ul>
</nav>

<nav>
    <ul>
        <?php if (empty($_SESSION['user'])) : ?>
            <li><a href="/connexion">Se connecter</a></li>
            <li><a href="/inscription">S'inscrire</a></li>
        <?php endif ?>
        <?php if (!empty($_SESSION['user'])) : ?><li><a href="/deconnexion">Déconnexion</a></li><?php endif ?>
    </ul>
</nav>

<nav>
    <ul>
        <li><a href="/mon-compte">Mon compte</a></li>
        <li><a href="/utilisateurs/read">Utilisateur/Read</a></li>
    </ul>
</nav>

<nav>
    <ul>
        <li><a href="/mentions-legales">Mentions légales</a></li>
        <li><a href="/politique-de-confidentialite">Politique de confidentialité</a></li>
        <li><a href="/contact">Contact</a></li>
    </ul>
</nav>

<h2><a href="/administration">Tableau de bord</a></h2>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>