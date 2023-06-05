<?php $title = "Nouveau mot de passe - " . ucfirst($host); ?>

<?php $description = "Nouveau mot de passe - " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1>Nouveau mot de passe</h1>

<?php if (isset($passwordUpdated)) : ?>
    <?php if ($passwordUpdated) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès</strong> : Mot de passe mis à jour.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    
    <?php if ($passwordUpdated == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur</strong> : <?= $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
<?php endif ?>

<form class="row g-3 mb-3" action="" method="post">
    <div class="col-6">
        <input type="password" class="form-control" id="password" name="password" maxlength="64" placeholder="Mot de passe" required>
    </div>
    <div class="col-6">
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" maxlength="64" placeholder="Confirmation du mot de passe" required>
    </div>

    <div class="col- text-center">
        <button type="submit" class="btn btn-primary" name="newPasswordUserSubmit">Mettre à jour votre mot de passe</button>
    </div>

    <div class="col-">
        <a class="btn btn-primary" href="/connexion">Se connecter</a>
        <a class="btn btn-primary" href="/inscription">Créer un compte</a>
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
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>