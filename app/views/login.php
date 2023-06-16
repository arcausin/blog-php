<?php $title = "Connexion - " . ucfirst($host); ?>

<?php $description = "Se connecter sur le site - " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<h1>Connexion</h1>

<?php if (isset($userConnected)) : ?>
    <?php if ($userConnected == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Connexion échoué !<br/>
            Erreur</strong> : <?= $message; ?>
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
    <div class="col-6">
        <input type="password" class="form-control" id="password" name="password" maxlength="64" placeholder="Mot de passe" required>
    </div>

    <div class="col- text-center">
        <button type="submit" class="btn btn-primary" name="loginUserSubmit">Se connecter</button>
    </div>

    <div class="col-">
        <a class="btn btn-primary" href="/mot-de-passe-oublie">Mot de passe oublié ?</a>
        <a class="btn btn-primary" href="/inscription">Créer un compte</a>
    </div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>