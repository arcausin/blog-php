<?php $title = "Formulaire de contact - " . ucfirst($host); ?>

<?php $description = "Contactez-moi via ce formulaire - " . ucfirst($host); ?>

<?php $image = $urlNative . "/public/img/logo.png"; ?>

<?php ob_start(); ?>
<p class="mb-3"><a class="text-dark" href="/">Accueil</a> > Contact</p>

<?php if (isset($mailSended)) : ?>
    <?php if ($mailSended == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Envoie du mail échoué !<br/>
            Erreur</strong> : <?= $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php else : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Envoie du mail réussie !</strong>
            Vous recevrez par mail une confirmation de réception.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
<?php endif ?>

<h1 class="text-center mb-3">CONTACT</h1>

<div class="row d-flex justify-content-center">
    <div class="col-12 col-lg-6">
        <form class="p-3 mb-3 shadow rounded-4" action="" method="post">
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="firstNameContact" class="form-label">Prénom</label>
                    <input type="text" id="firstNameContact" name="firstNameContact" class="form-control" value="<?php if (!empty($firstNameContact)) : ?><?= $firstNameContact; ?><?php endif ?>" maxlength="255" required>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="lastNameContact" class="form-label">Nom</label>
                    <input type="text" id="lastNameContact" name="lastNameContact" class="form-control" value="<?php if (!empty($lastNameContact)) : ?><?= $lastNameContact; ?><?php endif ?>" maxlength="255" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="mailAdressContact" class="form-label">Adresse mail</label>
                    <input type="email" id="mailAdressContact" name="mailAdressContact" class="form-control" maxlength="255" value="<?php if (!empty($mailAdressContact)) : ?><?= $mailAdressContact; ?><?php endif ?>" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="subjectContact" class="form-label">Sujet</label>
                    <input type="text" id="subjectContact" name="subjectContact" class="form-control" maxlength="255" value="<?php if (!empty($subjectContact)) : ?><?= $subjectContact; ?><?php endif ?>" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="messageContact" class="form-label">Message</label>
                    <textarea id="messageContact" name="messageContact" class="form-control" rows="5" required><?php if (!empty($messageContact)) : ?><?= $messageContact; ?><?php endif ?></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label for="questionContact" class="form-label">Qui a formulé les trois lois de la robotique ?</label>
                    <select id="questionContact" name="questionContact" class="form-select" required>
                        <option selected>Choisissez la bonne réponse</option>
                        <option value="1">James Cameron</option>
                        <option value="2">Isaac Asimov</option>
                        <option value="3">Hideo Kojima</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" id="contactSubmit" name="contactSubmit" class="btn btn-secondary shadow">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/layout.php'); ?>