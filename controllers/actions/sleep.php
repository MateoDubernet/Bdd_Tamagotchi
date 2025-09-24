<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Services\TamagoService;

if (isset($_GET['tamago_id'], $_GET['username'])) {
    TamagoService::sleep((int) $_GET['tamago_id'], $_GET['username']);
    header('Location: ../../views/tamagotchiList.php?username=' . urlencode($_GET['username']));
    exit;
}
