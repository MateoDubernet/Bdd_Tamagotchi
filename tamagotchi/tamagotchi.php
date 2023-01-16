<!DOCTYPE html>
        <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="/tamagotchi/tamagochi.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Press Start 2P' rel='stylesheet'>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

        <title>Tamagotchi</title>
    </head>
    <body>
        <div id="bg-image">
            <div id="tamagochi-land"><p>Tamagotchi Land</p></div>
            <div><p id="username">Welcome, <?php if(isset($_GET['username'])) $username = $_GET['username']; echo $username ?>!</p></div>
            <div>
                <a href="<?php $link = './create_tamagotchi.php?username='.$username; echo $link; ?>">
                <img src="../assets/creer_tamagochi.png" id="bouton-creer"></img>
                </a>
            </div>
            <div>
                <a href="<?php $link = './tamagotchiList.php?username='.$username; echo $link; ?>">
                    <img src="../assets/voir_tamagochi.png" id="bouton-voir"></img>
                </a>
            </div>
        </div>
    </body>
</html>