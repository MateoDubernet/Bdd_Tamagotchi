<?php 
require '../bdd/database.php';

DataBase::useDataBase('tamagotchi');
DataBase::createTable([
    "table_name" => "users",
    "column_id" => "id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,",
    "column_name" => "name VARCHAR(30) NOT NULL",
]);

$columns = [
    "column1" => "name",
];

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
        DataBase::insertData('users', $columns, $_POST);
        header('Location: ' .  '/connexion/login.php');
    } else {
        header('Location: ' .  '/connexion/register.php');
    }

}

if ($_GET) {
    if (isUserExist($_GET['username'])) {
        unset($_GET);
        header('Location: ' .  '/tamagotchi.php');
    } else {
        header('Location: ' .  '/connexion/login.php');
    }
}

?>