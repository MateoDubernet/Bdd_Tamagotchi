<?php
require_once __DIR__ . '/../vendor/autoload.php';

if (!isset($_GET['username'])) {
    die("Utilisateur non spécifié.");
}

$username = $_GET['username'];
$pageTitle = "";

include __DIR__ . '/../views/layouts/header.php';
?>

<div id="bg-image">
    <div id="tamagochi-land"><p>Tamagotchi Land</p></div>
    <div><p id="username">Welcome, <?= htmlspecialchars($username) ?>!</p></div>

    <div>
        <a href="../controllers/create_tamagotchi.php?username=<?= urlencode($username) ?>">
            <img src="../assets/creer_tamagochi.png" id="bouton-creer" alt="Créer un Tamagotchi">
        </a>
    </div>

    <div>
        <a href="../views/tamagotchiList.php?username=<?= urlencode($username) ?>">
            <img src="../assets/voir_tamagochi.png" id="bouton-voir" alt="Voir mes Tamagotchis">
        </a>
    </div>
</div>

<?php include __DIR__ . '/../views/layouts/footer.php'; ?>
