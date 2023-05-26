<?php $title = "Inscription - " . ucfirst($host); ?>

<?php $description = "S'inscrire sur le site - " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1>Inscription</h1>

<?php if (isset($userCreated)) : ?>
    <?php if ($userCreated == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Création du compte échoué !<br/>
            Erreur</strong> : <?= $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
<?php endif ?>

<form class="row g-3 mb-3" action="" method="post">
    <div class="col-6">
        <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo">
    </div>
    <div class="col-6">
        <input type="email" class="form-control" id="email" name="email" placeholder="Adresse Mail">
    </div>

    <div class="col-6">
        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
    </div>
    <div class="col-6">
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirmation du mot de passe">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary" name="createUserSubmit">Créer un compte</button>
    </div>
</form>

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