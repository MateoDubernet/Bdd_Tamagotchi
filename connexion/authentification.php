<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Services\UserService;
use Services\TamagoService;
use Faker\Factory as Faker;

Faker::create('fr_FR');

// Inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = trim($_POST['username']);

    if (!UserService::exists($username)) {
        UserService::create($username);
        TamagoService::createForUser($username);
        header('Location: /connexion/login.php');
        exit;
    } else {
        header('Location: /connexion/register.php');
        exit;
    }
}

// Connexion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) {
    $username = trim($_GET['username']);
    if (UserService::exists($username)) {
        header('Location: /views/tamagotchi.php?username=' . urlencode($username));
        exit;
    } else {
        header('Location: /connexion/login.php');
        exit;
    }
}
