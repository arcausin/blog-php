<?php
if (!empty($_SESSION['user'])) {
    header('Location: /');
    exit();
}

require_once(__DIR__.'/../../vendor/autoload.php');
use App\Models\User;
use App\Functions;

if (!empty($token)) {
    if (User::userTokenExists($token) != 1) {
        $message = "Inconnue";
        $userCreatedConfirm = false;
    } else {
        if (User::userConfirm($token)) {
            $userCreatedConfirm = true;
        } else {
            $message = "Inconnue";
            $userCreatedConfirm = false;
        }
    }
}

if (isset($userCreatedConfirm)) {
    if ($userCreatedConfirm) {
        header('Location: /connexion');
        exit();
    } else {
        require_once(__DIR__.'/../views/confirmation-register.php');
    }
} else {
    require_once(__DIR__.'/../views/confirmation-register.php');
}