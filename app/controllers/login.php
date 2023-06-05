<?php
if (!empty($_SESSION['user'])) {
    header('Location: /');
    exit();
}

require_once(__DIR__.'/../../vendor/autoload.php');
use App\Models\User;
use App\Functions;

if (isset($_POST['loginUserSubmit'])) {
    $email = Functions::validationInput($_POST['email']);
    $password = Functions::validationInput($_POST['password']);

    if (empty($email)) {
        $message = "Veuillez ajouter une adresse mail";
        $userConnected = false;
    } elseif (User::userEmailExists($email) == 0) {
        $message = "Cette adresse mail ne correspond à aucun compte";
        $userConnected = false;
    } elseif (User::userEmailExists($email) != 1) {
        // l'adresse mail correspond a plusieurs comptes
        $message = "Code erreur #0034";
        $userConnected = false;
    } elseif (empty($password)) {
        $message = "Veuillez ajouter un mot de passe";
        $userConnected = false;
    } else {
        $user = User::getUserByEmail($email);

        if ($user['role'] == 0) {
            $message = "Veuillez confirmer votre adresse mail pour vous connecter";
            $userConnected = false;
        } else {
            if (password_verify($password, $user['password'])) {
                // les deux mots de passe correspondent
                $_SESSION['user'] = $user;
                $userConnected = true;
            } else {
                $message = "Le mot de passe est incorrect";
                $userConnected = false;
            }
        }
    }
}

if (isset($userConnected)) {
    // si l'utilisateur est connecté
    if ($userConnected) {
        header('Location: /');
        exit();
    } else {
        // si l'utilisateur n'est pas connecté
        require_once(__DIR__.'/../views/login.php');
    }
} else {
    // si l'utilisateur n'est pas connecté
    require_once(__DIR__.'/../views/login.php');
}

