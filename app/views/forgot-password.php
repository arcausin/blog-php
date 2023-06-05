<?php $title = "Mot de passe oublié - " . ucfirst($host); ?>

<?php $description = "récupérer son compte - " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1>Mot de passe oublié</h1>

<?php if (isset($mailSended)) : ?>
    <?php if ($mailSended) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès</strong> : Un mail vous a été envoyé pour réinitialiser votre mot de passe.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    
    <?php if ($mailSended == false && !empty($message)) : ?>
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
        <input type="email" class="form-control" id="email" name="email" maxlength="64" placeholder="Adresse Mail" value="<?php if (!empty($_POST['email'])) : ?><?= $_POST['email']; ?><?php endif ?>" required>
    </div>

    <div class="col- text-center">
        <button type="submit" class="btn btn-primary" name="resetPasswordUserSubmit">Réinitialiser votre mot de passe</button>
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