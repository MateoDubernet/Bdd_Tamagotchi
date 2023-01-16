<?php 
    require '../bdd/database.php';
    require_once '../vendor/autoload.php';
    require './pdo.php';

    if(isset($_GET['username'])){
        $username = $_GET['username'];
        $tamagoColumns = [
            "column1" => "name,",
            "column2" => "niveaux,",
            "column3" => "faim,",
            "column4" => "soif,",
            "column5" => "sommeil,",
            "column6" => "ennui,",
            "column7" => "etat,",
            "column8" => "user_id",
        ];
    }
    
    function isTamagotchiExist(string $newTamagotchi){
        $tamagotchiExist = false;
        $userTamagotchis = Tamago::all();

        foreach($userTamagotchis as $tamagotchis){
            foreach($tamagotchis as $tamagotchi){
                if ($newTamagotchi === $tamagotchi) {
                    $tamagotchiExist = true;
                }
            }
        }
        return $tamagotchiExist;
    };

    function createTamago(){
        $faker = Faker\Factory::create('fr_FR');

        if (isset($_GET['username'])) {
            $username = $_GET['username'];
            $newTamagotchiName = $faker->firstName;
    
            if (isTamagotchiExist($newTamagotchiName)) {
                createTamago();
            } else {
                $tamago = TamagoInsert($newTamagotchiName);
                unset($_GET);
                header('Location: ' .  './tamagotchiList.php?username='.$username);
            }
        }
    }

    createTamago();