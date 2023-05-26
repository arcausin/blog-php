<?php

function dbConnect() {
    $host = '';
    $dbname = '';
    $charset = 'utf8mb4';
    $username = '';
    $password = '';

    try {
        $database = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
        // définit le mode d'erreur de PDO sur exception
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        // affiche un message d'erreur s'il y a eu un problème de connexion
        echo 'Error: ' . $e->getMessage();
    }

    return $database;
}