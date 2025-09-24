<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Services\UserService;
use Services\TamagoService;
use Faker\Factory as Faker;

Faker::create('fr_FR');

// Vérifie si le formulaire est soumis en POST (inscription)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = trim($_POST['username']);

    if (!UserService::exists($username)) {
        // Créer utilisateur et Tamago associé
        UserService::create($username);
        TamagoService::createForUser($username);

        header('Location: /connexion/login.php');
        exit;
    } else {
        header('Location: /connexion/register.php');
        exit;
    }
}

// Vérifie si le formulaire est soumis en GET (connexion)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) {
    $username = trim($_GET['username']);
    if (UserService::exists($username)) {
        header('Location: /controllers/tamagotchi.php?username=' . urlencode($username));
        exit;
    } else {
        header('Location: /connexion/login.php');
        exit;
    }
}
