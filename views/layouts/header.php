<?php
if (!isset($pageTitle)) {
    $pageTitle = "Tamagotchi";
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($pageTitle) ?></title>

        <!-- CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="../styles/tamagochi.css" rel="stylesheet">
        <link href="../styles/authentification.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">

        <!-- JS -->
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <h1 style="text-align:center"><?= htmlspecialchars($pageTitle) ?></h1>
        </header>
        <main>
