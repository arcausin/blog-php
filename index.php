<?php
session_start();

$url[0] = '';

if (isset($_GET['url'])) {
    $url = explode('/', $_GET['url']);
}

$host = $_SERVER['HTTP_HOST'];

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $location = 'https://' . $host . $_SERVER['REQUEST_URI'];
    header('Location: ' . $location);
    exit;
}

if (substr($host, 0, 4) === 'www.') {
    $no_www_host = substr($host, 4);
    $location = 'https://' . $no_www_host . $_SERVER['REQUEST_URI'];
    header('Location: ' . $location);
    exit;
}

$urlNative = "https://" . $host;

if ($url[0] == 'administration') {
    if (!empty($_SESSION['user']) && $url[0] == 'administration' && empty($url[1])) {
        require_once(__DIR__.'/admin/controllers/homepage.php');
    }

    elseif (!empty($_SESSION['user']) && $url[0] == 'administration' && $url[1] == 'articles' && empty($url[2])) {
        require_once(__DIR__.'/admin/controllers/articles/index.php');
    }
    elseif (!empty($_SESSION['user']) && $url[0] == 'administration' && $url[1] == 'articles' && $url[2] == 'ajouter' && empty($url[3])) {
        require_once(__DIR__.'/admin/controllers/articles/create.php');
    }
    elseif (!empty($_SESSION['user']) && $url[0] == 'administration' && $url[1] == 'articles' && !empty($url[2]) && empty($url[3])) {
        $slug = $url[2];
        require_once(__DIR__.'/admin/controllers/articles/read.php');
    }
    elseif (!empty($_SESSION['user']) && $url[0] == 'administration' && $url[1] == 'articles' && $url[2] == 'modifier' && !empty($url[3]) && empty($url[4])) {
        $slug = $url[3];
        require_once(__DIR__.'/admin/controllers/articles/update.php');
    }
    elseif (!empty($_SESSION['user']) && $url[0] == 'administration' && $url[1] == 'articles' && $url[2] == 'supprimer' && !empty($url[3]) && empty($url[4])) {
        $slug = $url[3];
        require_once(__DIR__.'/admin/controllers/articles/delete.php');
    }
    
    else {
        require_once(__DIR__.'/app/controllers/404.php');
    }
}

elseif (!empty($url[0])) {
    if ($url[0] == 'articles' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/articles/index.php');
    }
    elseif ($url[0] == 'articles' && !empty($url[1]) && empty($url[2])) {
        $slug = $url[1];
        require_once(__DIR__.'/app/controllers/articles/read.php');
    }

    elseif ($url[0] == 'contact' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/contact.php');
    }
    elseif ($url[0] == 'mentions-legales' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/legal-notice.php');
    }
    elseif ($url[0] == 'politique-de-confidentialite' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/privacy-policy.php');
    }

    elseif ($url[0] == 'inscription' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/register.php');
    }
    elseif ($url[0] == 'confirmation-inscription' && !empty($url[1]) && empty($url[2])) {
        $token = $url[1];
        require_once(__DIR__.'/app/controllers/confirmation-register.php');
    }
    elseif ($url[0] == 'connexion' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/login.php');
    }
    elseif ($url[0] == 'deconnexion' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/logout.php');
    }
    elseif ($url[0] == 'mot-de-passe-oublie' && empty($url[1])) {
        require_once(__DIR__.'/app/controllers/forgot-password.php');
    }
    elseif ($url[0] == 'nouveau-mot-de-passe' && !empty($url[1]) && empty($url[2])) {
        $resetPasswordToken = $url[1];
        require_once(__DIR__.'/app/controllers/new-password.php');
    }

    else {
        require_once(__DIR__.'/app/controllers/404.php');
    }
}

elseif ($url[0] == '' && empty($url[1])) {
    require_once(__DIR__.'/app/controllers/homepage.php');
}

else {
    require_once(__DIR__.'/app/controllers/404.php');
}