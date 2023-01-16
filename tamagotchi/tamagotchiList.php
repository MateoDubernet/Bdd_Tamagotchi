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
        <h1 style="text-align:center">Mes Tamagos</h1>
        <div><a href=<?php $link="./tamagotchi.php?username=".$username; echo $link?> >Home</a></div>
        <div class="tamago-container">
            <?php
                if(!empty($tamagos)){
                    foreach($tamagos as $myTamago):
                        if($myTamago->etat == "vivant"){
                            echo (
                                "<div class='tamago-card'>".
                                    "<div class='tamago-card-body'>" .
                                        "<p class='tamago-card-text'> Id: " . $myTamago->id . "</p>" .
                                        "<p class='tamago-card-text'> Name: " . $myTamago->name . "</p>" .
                                        "<p class='tamago-card-text'> Niveau: " . $myTamago->niveaux . "</p>" .
                                        "<p class='tamago-card-text'> Faim: " . $myTamago->faim . "</p>" .
                                        "<p class='tamago-card-text'> Soif: " . $myTamago->soif . "</p>" .
                                        "<p class='tamago-card-text'> Ennui: " . $myTamago->ennui . "</p>" .
                                        "<p class='tamago-card-text'> Sommeil: " . $myTamago->sommeil . "</p>" .
                                        "<p class='tamago-card-text'> Etat: " . $myTamago->etat . "</p>" .
                                        "<p class='tamago-card-text'> Actions: " . $myTamago->actions . "</p>" .
                                        "<a href='./manger.php?tamago_id=".$myTamago->id."&username=".$username."'><button class='button-14' type='button'>Manger</button></a>".
                                        "<a href='./boire.php?tamago_id=".$myTamago->id."&username=".$username."'><button class='button-14' type='button'>Boire</button></a>".
                                        "<a href='./sleep.php?tamago_id=".$myTamago->id."&username=".$username."'><button class='button-14' type='button'>Dormir</button></a>".
                                        "<a href='./play.php?tamago_id=".$myTamago->id."&username=".$username."'><button class='button-14' type='button'>Jouer</button></a>".
                                    "</div>" .
                                "</div>"
                            );
                        }
                    endforeach;
                }
            ?>
        </div>
        <div><a href=<?php $link = "./tamagotchiGraveyard.php?username=".$username; echo $link;?>>Visiter le cimetière ? </a></div>
    </body>
</html>