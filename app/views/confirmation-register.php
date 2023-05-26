<?php $title = "Confirmation d'inscription - " . ucfirst($host); ?>

<?php $description = "Confirmer l'inscription sur le site - " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1>Confirmation d'inscription</h1>

<?php if (isset($userCreatedConfirm)) : ?>
    <?php if ($userCreatedConfirm == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Confirmation de création du compte échoué !<br/>
            Erreur</strong> : <?= $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
<?php endif ?>

<hr>

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
        <li><a href="/inscription">Inscription</a></li>
        <li><a href="/connexion">Connexion</a></li>
        <li><a href="/deconnexion">Déconnexion</a></li>
        <li><a href="/mot-de-passe-oublie">Mot de passe oublie</a></li>
        <li><a href="/nouveau-mot-de-passe">Nouveau mot de passe</a></li>
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