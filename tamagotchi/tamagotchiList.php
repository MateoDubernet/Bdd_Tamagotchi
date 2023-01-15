<?php 
require '../bdd/database.php';
require_once '../vendor/autoload.php';
require './pdo.php';

function isUserExist(string $selectUser){
    $userExist = false;
    $users = DataBase::getAll('users');
    foreach($users as $listUser){
        foreach($listUser as $user){
            if ($selectUser === $user) {
                $userExist = true;
            }
        }
    }
    return $userExist;
};

if ($_POST) {
    if (!isUserExist($_POST['username'])) {
        unset($_POST);
        header('Location: ' .  '../connexion/login.php');
    } else {
        header('Location: ' .  '../connexion/register.php');
    }
}

if(isset($_GET['username'])){
    $username = $_GET['username'];
    $user_id = UserFindByName($username)->id;
    $tamagos = TamagoFindByUserId(intval($user_id)); 
 }
?>
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

        <title>My Tamagos</title>
    </head>
    <body>
        <?php
            if(!empty($tamagos)){
                foreach($tamagos as $myTamago):
                    echo (
                        "<h1>Mes tamagos</h1>".
                        "id:" . $myTamago->id
                        ."<br>".
                        "name:" . $myTamago->name
                        ."<br>".
                        "niveau:" . $myTamago->id
                        ."<br>".
                        "faim:" . $myTamago->faim
                        ."<br>".
                        "soif:" . $myTamago->soif
                        ."<br>".
                        "ennui:" . $myTamago->ennui
                        ."<br>". 
                        "Etat:" . $myTamago->etat
                        ."<br>"
                    );
                endforeach;
            }
        ?>
    </body>
</html>