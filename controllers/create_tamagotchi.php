<?php
require_once '../vendor/autoload.php';

use Services\TamagoService;

if (!isset($_GET['username'])) {
    die("Nom d'utilisateur manquant.");
}

$username = $_GET['username'];

try {
    $tamago = TamagoService::createForUser($username);
    header('Location: ../views/tamagotchiList.php?username=' . urlencode($username));
    exit;
} catch (\Exception $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}
