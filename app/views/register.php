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
    <?php elseif ($userCreated == true && empty($message)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Création du compte réussie !</strong><br/>
            Veuillez cliquer sur le lien envoyé par mail pour confirmer votre inscription.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
<?php endif ?>

<form class="row g-3 mb-3" action="" method="post">
    <div class="col-6">
        <input type="text" class="form-control" id="pseudo" name="pseudo" maxlength="32" placeholder="Pseudo" value="<?php if (!empty($pseudonym)) : ?><?= $pseudonym; ?><?php endif ?>" required>
    </div>
    <div class="col-6">
        <input type="email" class="form-control" id="email" name="email" maxlength="64" placeholder="Adresse Mail" value="<?php if (!empty($email)) : ?><?= $email; ?><?php endif ?>" required>
    </div>

    <div class="col-6">
        <input type="password" class="form-control" id="password" name="password" maxlength="64" placeholder="Mot de passe" required>
    </div>
    <div class="col-6">
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" maxlength="64" placeholder="Confirmation du mot de passe" required>
    </div>

    <div class="col- text-center">
        <button type="submit" class="btn btn-primary" name="createUserSubmit">Créer un compte</button>
    </div>

    <div class="col-">
        <a class="btn btn-primary" href="/connexion">Se connecter</a>
    </div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>