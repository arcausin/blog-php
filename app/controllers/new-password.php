<?php
if (!empty($_SESSION['user'])) {
    header('Location: /');
    exit();
}

require_once(__DIR__.'/../../vendor/autoload.php');
use App\Models\User;
use App\Functions;

if (!empty($resetPasswordToken)) {
    if (User::userResetPasswordTokenExists($resetPasswordToken) != 1) {
        $message = "Inconnue";
        $passwordUpdated = false;
    } else {
        $user = User::getUserByResetPasswordToken($resetPasswordToken);

        if (isset($_POST['newPasswordUserSubmit'])) {
            $password = Functions::validationInput($_POST['password']);
            $passwordConfirm = Functions::validationInput($_POST['password_confirm']);

            if (empty($password)) {
                $message = "Veuillez ajouter un mot de passe";
                $passwordUpdated = false;
            } elseif (empty($passwordConfirm)) {
                $message = "Veuillez confirmer votre mot de passe";
                $passwordUpdated = false;
            } elseif ($password != $passwordConfirm) {
                $message = "Les mots de passe ne correspondent pas";
                $passwordUpdated = false;
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                
                if (User::updatePassword($user['id'], $passwordHash)) {
                    $passwordUpdated = true;
                } else {
                    $message = "Mise à jour du mot de passe impossible";
                    $passwordUpdated = false;
                }
            }
        }
    }
}

if (isset($passwordUpdated)) {
    if ($passwordUpdated) {
        header('Location: /connexion');
        exit();
    } else {
        require_once(__DIR__.'/../views/new-password.php');
    }
} else {
    require_once(__DIR__.'/../views/new-password.php');
}