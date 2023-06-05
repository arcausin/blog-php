<?php
if (!empty($_SESSION['user'])) {
    header('Location: /');
    exit();
}

require_once(__DIR__.'/../../vendor/autoload.php');
use App\Models\User;
use App\Functions;

if (isset($_POST['resetPasswordUserSubmit'])) {
    $email = Functions::validationInput($_POST['email']);

    if (empty($email)) {
        $message = "Veuillez ajouter une adresse mail";
        $mailSended = false;
    } elseif (User::userEmailExists($email) == 0) {
        $message = "Cette adresse mail ne correspond à aucun compte";
        $mailSended = false;
    } elseif (User::userEmailExists($email) != 1) {
        // l'adresse mail correspond a plusieurs comptes
        $message = "Code erreur #0034";
        $mailSended = false;
    } else {
        $user = User::getUserByEmail($email);

        if (empty($user['reset_password_token'])) {
            $resetPasswordToken = Functions::makeIdPublic();

            if (!User::addResetPasswordToken($email, $resetPasswordToken)) {
                $message = "La génération du token a échoué";
                $mailSended = false;
            }

            $user = User::getUserByEmail($email);
        }

        if (!empty($user['reset_password_token'])) {
            $subjectTo = "Réinitialiser votre mot de passe sur " . ucfirst($host);

            ob_start(); ?>
            <html>
                <head>
                <title>Réinitialiser votre mot de passe sur <?= ucfirst($host); ?></title>
                </head>
                <body>
                    <h1>Réinitialiser votre mot de passe sur <?= ucfirst($host); ?></h1>
                    <p>Bonjour, <br/><br/>
                    Nous avons bien reçu votre demande de Réinitialisation de mot de passe. <br/>
                    Veuillez cliquer sur <a href="<?= $urlNative; ?>/nouveau-mot-de-passe/<?= $resetPasswordToken; ?>">ce lien</a> pour changer votre mot de passe.</p>
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
        } else {
            $message = "La génération du token a échoué";
            $mailSended = false;
        }
    }
}

require_once(__DIR__.'/../views/forgot-password.php');