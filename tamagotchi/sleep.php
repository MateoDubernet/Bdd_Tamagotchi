<?php

    require './pdo.php';

    if(isset($_GET['tamago_id']) && isset($_GET['username'])){
        $tamago_id = $_GET['tamago_id'];
        $username = $_GET['username'];
        $user = UserFindByName($username);
        $user_id = $user->id;
        $tamagos = TamagoFindByUserId(intval($user_id));
        if(!empty($tamagos)){
            foreach($tamagos as $myTamago):
                if($myTamago->id == $tamago_id)
                {
                    TamagoSleep($tamago_id, $username);
                } 
            endforeach;
        }
        $link = './tamagotchiList.php?username='.$username;
        header('Location: ' .  $link);
    }
?>