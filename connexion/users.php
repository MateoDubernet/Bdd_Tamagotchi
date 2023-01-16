<?php 
require '../bdd/database.php';
require_once '../vendor/autoload.php';
require '../tamagotchi/pdo.php';

$faker = Faker\Factory::create('fr_FR');

DataBase::useDataBase('tamagotchi');
DataBase::createTable([
    "table_name" => "users",
    "column_id" => "id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,",
    "column_name" => "name VARCHAR(30) NOT NULL"
]);

DataBase::createTable([
    "table_name" => "tamago",
    "column_id" => "id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,",
    "column_name" => "name VARCHAR(30) NOT NULL,",
    "column_niveaux" => "niveaux SMALLINT NOT NULL,",
    "column_faim" => "faim SMALLINT NOT NULL,",
    "column_soif" => "soif SMALLINT NOT NULL,",
    "column_sommeil" => "sommeil SMALLINT NOT NULL,",
    "column_ennui" => "ennui SMALLINT NOT NULL,",
    "column_etat" => "etat VARCHAR(30) NOT NULL,",
    "column_user_id" => "user_id BIGINT NOT NULL, CONSTRAINT FK_user_tamgo FOREIGN KEY (user_id) REFERENCES users(id),",
    "column_actions" => "actions SMALLINT NOT NULL,", 
    "column_born_at" => "born_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,", 
    "column_died_at" => "died_at TIMESTAMP NULL"
]);

$userColumns = [
    "column1" => "name",
];

$tamagoColumns = [
    "column1" => "name,",
    "column2" => "niveaux,",
    "column3" => "faim,",
    "column4" => "soif,",
    "column5" => "sommeil,",
    "column6" => "ennui,",
    "column7" => "etat,",
    "column8" => "user_id",
    "column9" => "actions",
    "column10" => "born_at",
    "column11" => "died_at"
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
        $username = $_POST['username'];
        DataBase::insertData('users', $userColumns, ["column_name" => "'$username'"]);
        DataBase::insertData('tamago', $tamagoColumns, [
            "column_name" => "'$faker->firstName',",
            "column_niveaux" => 1 . ",",
            "column_faim" => 70 . ",",
            "column_soif" => 70 . ",",
            "column_sommeil" => 70 . ",",
            "column_ennui" => 70 . ",",
            "column_etat" => "'vivant',",
            "column_user_id" => "(SELECT id FROM users WHERE name='$username')", 
            "column_actions" => 0 . ",",

        ]);
        
        unset($_POST);
        header('Location: ' .  '/connexion/login.php');
    } else {
        header('Location: ' .  '/connexion/register.php');
    }

}

if (isset($_GET) && isset($_GET['username']) ) {
    $username = $_GET['username'];
    if (isUserExist($username)) {
        header('Location: ' .  '../tamagotchi/tamagotchi.php?username='.$username);
    } else {
        header('Location: ' .  '/connexion/login.php');
    }
}
?>