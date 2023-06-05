<?php
if (!empty($_SESSION['user'])) {
    header('Location: /');
    exit();
}

require_once(__DIR__.'/../../vendor/autoload.php');
use App\Models\User;
use App\Functions;

if (isset($_POST['createUserSubmit'])) {
    $pseudonym = Functions::validationInput($_POST['pseudo']);
    $email = Functions::validationInput($_POST['email']);
    $password = Functions::validationInput($_POST['password']);
    $password_confirm = Functions::validationInput($_POST['password_confirm']);

    if (empty($pseudonym)) {
        $message = "Veuillez ajouter un pseudo";
        $userCreated = false;
    } elseif (User::userPseudoExists($pseudonym) != 0) {
        $message = "Ce Pseudo est déjà utilisée";
        $userCreated = false;
    } elseif (empty($email)) {
        $message = "Veuillez ajouter une adresse mail";
        $userCreated = false;
    } elseif (User::userEmailExists($email) != 0) {
        $message = "Cette adresse mail est déjà utilisée";
        $userCreated = false;
    } elseif (empty($password)) {
        $message = "Veuillez ajouter un mot de passe";
        $userCreated = false;
    } elseif (empty($password_confirm)) {
        $message = "Veuillez confirmer votre mot de passe";
        $userCreated = false;
    } elseif ($password != $password_confirm) {
        $message = "Les mots de passe ne correspondent pas";
        $userCreated = false;
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $token = Functions::makeIdPublic();

        $user = new User(
            $pseudonym,
            $email,
            $passwordHash,
            $token
        );
        
        if ($user->addUser()) {
            $userCreated = true;
        } else {
            $message = "Inconnue";
            $userCreated = false;
        }

        $subjectTo = "Valider votre inscription sur " . ucfirst($host);

        ob_start(); ?>
        <html>
            <head>
            <title>Valider votre inscription sur <?= ucfirst($host); ?></title>
            </head>
            <body>
                <h1>Valider votre inscription sur <?= ucfirst($host); ?></h1>
                <p>Bonjour, <br/><br/>
                Nous avons bien reçu votre demande de création de compte. <br/>
                Veuillez cliquer sur <a href="<?= $urlNative; ?>/confirmation-inscription/<?= $token; ?>">ce lien</a> pour valider l'inscription.</p>
                <p><i>Si vous n'êtes pas à l'origine de cette activité, veuillez <a href="<?= $urlNative; ?>/contact">nous contacter</a>.</i></p>
                <p>Cordialement</p>
                <p><a href="<?= $urlNative; ?>"><?= ucfirst($host); ?></a></p>
            </body>
        </html>
        <?php $messageTo = ob_get_clean();

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/html; charset=utf-8';
        $headers[] = 'From: ' . ucfirst($host) . ' <contact@' . $host . '>';

        if (mail($email, $subjectTo, $messageTo, implode("\r\n", $headers))) {
            $mailSended = true;
        } else {
            $message = "Envoi du mail echoué";
            $mailSended = false;
        }
    }
}

require_once(__DIR__.'/../views/register.php');