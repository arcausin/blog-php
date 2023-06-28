<?php
require_once(__DIR__.'/../../vendor/autoload.php');

use App\Models\MailForm;
use App\Functions;

if (isset($_POST['contactSubmit'])) {
    $firstNameContact = Functions::validationInput($_POST['firstNameContact']);
    $lastNameContact = Functions::validationInput($_POST['lastNameContact']);
    $mailAdressContact = Functions::validationInput($_POST['mailAdressContact']);
    $subjectContact = Functions::validationInput($_POST['subjectContact']);
    $messageContact = Functions::validationInput($_POST['messageContact']);
    $questionContact = Functions::validationInput($_POST['questionContact']);

    if (empty($firstNameContact)) {
        $message = "Veuillez entrer un prénom";
        $mailSended = false;
    } elseif (mb_strlen($firstNameContact, 'UTF-8') > 32) {
        $message = "Veuillez ajouter un prénom avec un maximum de 32 caractères (actuellement ".mb_strlen($firstNameContact, 'UTF-8').")";
        $userCreated = false;
    } elseif (empty($lastNameContact)) {
        $message = "Veuillez entrer un nom";
        $mailSended = false;
    } elseif (mb_strlen($lastNameContact, 'UTF-8') > 32) {
        $message = "Veuillez ajouter un nom avec un maximum de 32 caractères (actuellement ".mb_strlen($lastNameContact, 'UTF-8').")";
        $userCreated = false;
    } elseif (empty($mailAdressContact)) {
        $message = "Veuillez entrer une adresse mail";
        $mailSended = false;
    } elseif (mb_strlen($mailAdressContact, 'UTF-8') > 64) {
        $message = "Veuillez ajouter une adresse mail avec un maximum de 64 caractères (actuellement ".mb_strlen($mailAdressContact, 'UTF-8').")";
        $userCreated = false;
    } elseif (empty($subjectContact)) {
        $message = "Veuillez entrer un sujet";
        $mailSended = false;
    } elseif (mb_strlen($subjectContact, 'UTF-8') > 64) {
        $message = "Veuillez ajouter un sujet avec un maximum de 64 caractères (actuellement ".mb_strlen($subjectContact, 'UTF-8').")";
        $userCreated = false;
    } elseif (empty($messageContact)) {
        $message = "Veuillez entrer un message";
        $mailSended = false;
    } elseif ($_POST['questionContact'] != 2) {
        $message = "La réponse à la question de sécurité est incorrecte";
        $mailSended = false;
    } else {
        $subjectTo = "Confirmation de réception de formulaire de contact";
  
        ob_start(); ?>
        <html>
            <head>
            <title>Confirmation de réception de formulaire de contact</title>
            </head>
            <body>
                <h1>Confirmation de réception de formulaire de contact</h1>
                <p>Bonjour, <br/><br/>
                Nous avons bien reçu votre formulaire de contact et nous vous en remercions. Nous allons traiter votre demande dans les plus brefs délais. <br/>
                Voici le sujet du message que nous avons reçu de votre part : <br/> <br/>
                Sujet : <?= $subjectContact; ?></p>
                <p><i>Si vous n'êtes pas à l'origine de cette activité, veuillez <a href="<?= $urlNative; ?>/contact">nous contacter</a>.</i></p>
                <p>Cordialement</p>
                <p><a href="<?= $urlNative; ?>"><?= ucfirst($host); ?></a></p>
            </body>
        </html>
        <?php $messageTo = ob_get_clean();

        $subjectFrom = "Nouveau message de contact - " . ucfirst($host);
        
        ob_start(); ?>
        <html>
            <head>
            <title>Nouveau message de contact - <?= ucfirst($host); ?></title>
            </head>
            <body>
                <h1>Nouveau message de contact - <?= ucfirst($host); ?></h1>
                <p>Bonjour, <br/><br/>
                Voici le message que vous avez reçu de la part de <?= $firstNameContact; ?> <?= $lastNameContact; ?> : <br/> <br/>
                Adresse mail : <?= $mailAdressContact; ?> <br/>
                Sujet : <?= $subjectContact; ?> <br/>
                Message : <?= $messageContact; ?></p>
                <p>Cordialement</p>
                <p><a href="<?= $urlNative; ?>"><?= ucfirst($host); ?></a></p>
            </body>
        </html>
        <?php $messageFrom = ob_get_clean();

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/html; charset=utf-8';
        $headers[] = 'From: '.$host.' <contact@'.$host.'>';

        $uuid = Functions::makeIdPublic();

        $mailForm = new MailForm(
            $uuid,
            $firstNameContact,
            $lastNameContact,
            $mailAdressContact,
            $subjectContact,
            $messageContact
        );

        if (mail("contact@".$host, $subjectFrom, $messageFrom, implode("\r\n", $headers))) {
            if (mail($mailAdressContact, $subjectTo, $messageTo, implode("\r\n", $headers))) {
                if ($mailForm->addMailForm()) {
                    $mailSended = true;
                    $firstNameContact = null;
                    $lastNameContact = null;
                    $mailAdressContact = null;
                    $subjectContact = null;
                    $messageContact = null;
                } else {
                    $message = "Envoi du mail réussi mais erreur lors de l'enregistrement du formulaire";
                }
            } else {
                $message = "Envoi du mail echoué";
                $mailSended = false;
            }
        } else {
            $message = "Envoi du mail echoué";
            $mailSended = false;
        }
    }
}

require_once($_SERVER['DOCUMENT_ROOT'].'/app/views/contact.php');