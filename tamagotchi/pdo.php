<?php

abstract class Model
{
    public static string $table = "";
    public static string $id = "";
    public static string $name = "";
    public static array $columns = [];
    public static ?PDO $pdo = null;

    public static function getDatabase()
    {
        if(!self::$pdo) {
            $config = [
                "host" => "localhost",
                "port" => 3306,
                "username" => "cheikhoul",
                "password" => "09121968.",
                "engine" => "mysql",
                "database" => "tamagotchi"
            ];

            self::$pdo = new PDO(sprintf(
                "%s:host=%s:%s;dbname=%s",
                $config["engine"],
                $config["host"],
                $config["port"],
                $config["database"]
            ), $config["username"], $config["password"], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]);
        }
        return self::$pdo;
    }

    public static function all() : array
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function find(int $id) : ?static
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = $id", static::$table, static::$id));
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

    public static function findByName(string $name) : ?static
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = :name", static::$table, static::$name));
        $stmt->bindValue("name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }
    

    // Pour retirer les erreurs de VSCode
    public function __set($k, $v) { $this->$k = $v; }

    public function save() : void
    {
        $pdo = self::getDatabase();
        $sql = "INSERT INTO " . static::$table;
        $sql .= "(" . implode(', ', array_fill(0, count(static::$columns), "%s")) . ")";
        $sql = sprintf($sql, ...static::$columns);
        
        $sql .= " VALUES ";
        $sql .= "(" . implode(', ', array_fill(0, count(static::$columns), "?")) . ")";

        $stmt = $pdo->prepare($sql);
        foreach(static::$columns as $idx => $column) {
            $stmt->bindValue($idx + 1, $this->{$column} ?? NULL);
        }
        $stmt->execute();
    }

    public function update(array $props) : void
    {
        $pdo = self::getDatabase();
        $sql = "UPDATE %s SET ";
        if(empty($props)) {
            return; 
        }
        foreach(array_keys($props) as $columnName) {
            if(array_search($columnName, static::$columns) === false) {
                throw new BadMethodCallException("Column " . $columnName . " does not exist in " . static::class);
            }
            $sql .= $columnName . " = ?, ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE %s = ?";

        $sql = sprintf($sql, static::$table, static::$id);
        $stmt = $pdo->prepare($sql);

        foreach(array_values($props) as $idx => $val) {
            $stmt->bindValue($idx + 1, $val);
        }
        $idx += 2;
        $stmt->bindValue($idx, $this->{static::$id}, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete() : void
    {
        if(!$this->{static::$id}) {
            throw new BadMethodCallException("Cannot remove entity when id is empty");
        }
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("DELETE FROM %s WHERE %s = :id", static::$table, static::$id));
        $stmt->bindValue("id", $this->{static::$id}, PDO::PARAM_INT);
        $stmt->execute();
    }
}

class Tamago extends Model {
    public static string $table = "tamago";
    public static string $id = "id";
    public static string $name = "name";
    public static array $columns = [
        "id", "name", "niveaux", "faim", "soif", "sommeil", "ennui", "etat", "user_id", "actions", "born_at", "died_at"
    ];
    public static function findByUserId(int $user_id) : array
    {
        $pdo = Model::getDatabase();
        $stmt = $pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = :user_id", static::$table, static::$columns[8]));
        $stmt->bindValue("user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetchAll();
    }
}


class User extends Model {
    public static string $table = "users";
    public static string $id = "id";
    public static string $name = "name";
    public static array $columns = [
        "id", "name"
    ];
}

function TamagoList()
{
    $tamagos = Tamago::all();
    return ($tamagos);
}

function TamagoFind($tamago_id)
{
    $tamago = Tamago::find($tamago_id);
    return ($tamago);
}

function TamagoUpdate($username, $tamago_id, $niveaux, $faim, $soif, $sommeil, $ennui, $etat) 
{
    $user = UserFindByName($username);
    $user_id = $user->id;
    $tamagos = TamagoFindByUserId(intval($user_id));
    if(!empty($tamagos)){
        foreach($tamagos as $myTamago):
            if($myTamago->id == $tamago_id)
            {
                if($myTamago->actions == 9)
                {
                    $actions = 0;
                    $niveau = $myTamago->niveaux + 1;
                }
                else {
                    $actions = $myTamago->actions + 1;
                    $niveau = $myTamago->niveaux;
                }
                if($faim <= 0)
                {
                    $faim = 0;
                }
                if($soif <= 0)
                {
                    $soif = 0;
                }
                if($ennui <= 0)
                {
                    $ennui = 0;
                }
                if($sommeil <= 0)
                {
                    $sommeil = 0;
                }
                if($faim == 0 || $soif == 0 || $ennui == 0 || $sommeil == 0)
                {
                    $etat = "mort";
                    $now = new DateTime();
                    $died_at = $now->format('Y-m-d H:i:s');
                    try {
                        $myTamago->update([
                            "died_at" => $died_at
                        ]);
                    } catch (PDOException $th) {
                        echo($th -> getMessage());
                        
                    }
                    
                }
                $myTamago->update([
                    "niveaux" => $niveau,
                    "faim" => $faim,
                    "soif" => $soif,
                    "sommeil" => $sommeil,
                    "ennui" => $ennui,
                    "etat" => $etat, 
                    "actions" => $actions
                    ]);
            }
        endforeach;
    }


    //$tamago = Tamago::find($tamago_id);
}

function TamagoInsert($name) 
{
    $tamago = new Tamago();
    $tamago->name = $name;
    $tamago->niveaux = 1;
    $tamago->faim = 70;
    $tamago->soif = 70;
    $tamago->sommeil = 70;
    $tamago->ennui = 70;
    $tamago->etat = "vivant";
    $tamago->user_id = User::findByName($_GET['username'])->id;
    $tamago->actions = 0;
    $tamago->save();
}

function TamagoDelete($tamago_id)
{
    $tamago = Tamago::find($tamago_id);
    $tamago->delete();
}

function UserFind($user_id)
{
    $user = User::find($user_id);
    return($user);
}
function UserFindByName($user_name)
{
    $user = User::findByName($user_name);
    return($user);
}
function TamagoFindByUserId($user_id)
{
    $tamago = Tamago::findByUserId($user_id);
    return($tamago);
}
function TamagoEat($tamago_id, $username)
{
    $user = UserFindByName($username);
    $user_id = $user->id;
    $tamagos = TamagoFindByUserId(intval($user_id));
    if(!empty($tamagos)){
        foreach($tamagos as $myTamago):
            if($myTamago->id == $tamago_id)
            {
                $soif = $myTamago->soif - 10;
                $sommeil = $myTamago->sommeil - 5;
                $ennui = $myTamago->ennui - 5;
                if($myTamago->faim<=80)
                {
                    $faim = $myTamago->faim + 30;
                    if($faim>= 100)
                    {
                        $faim = 100;
                    }
                    TamagoUpdate($username, $myTamago->id, $myTamago->niveau, $faim, $soif, $sommeil, $ennui, $myTamago->etat);
                }
            } 
        endforeach;
    }
}

function TamagoDrink($tamago_id, $username)
{   
    $user = UserFindByName($username);
    $user_id = $user->id;
    $tamagos = TamagoFindByUserId(intval($user_id));
    if(!empty($tamagos)){
        foreach($tamagos as $myTamago):
            if($myTamago->id == $tamago_id)
            {
                $faim = $myTamago->faim - 10;
                $sommeil = $myTamago->sommeil - 5;
                $ennui = $myTamago->ennui - 5;
                if($myTamago->soif<=80)
                {
                    $soif = $myTamago->soif + 30;
                    if($soif>= 100)
                    {
                        $soif = 100;
                    }
                    TamagoUpdate($username, $myTamago->id, $myTamago->niveaux, $faim, $soif, $sommeil, $ennui, $myTamago->etat);
                }
            } 
        endforeach;
    }
    //$tamago = Tamago::find($tamago_id);
}

function TamagoSleep($tamago_id, $username)
{
    //$tamago = Tamago::find($tamago_id);
    $user = UserFindByName($username);
    $user_id = $user->id;
    $tamagos = TamagoFindByUserId(intval($user_id));
    if(!empty($tamagos)){
        foreach($tamagos as $myTamago):
            if($myTamago->id == $tamago_id)
            {
                $faim = $myTamago->faim - 10;
                $soif = $myTamago->soif - 15;
                $ennui = $myTamago->ennui - 15;
                if($myTamago->sommeil<=80)
                {
                    $sommeil = $myTamago->sommeil + 30;
                    if($sommeil>= 100)
                    {
                        $sommeil = 100;
                    }
                    TamagoUpdate($username, $myTamago->id, $myTamago->niveaux, $faim, $soif, $sommeil, $ennui, $myTamago->etat);
                }
            }
        endforeach;
    }
}

function TamagoPlay($tamago_id, $username)
{
    //$tamago = Tamago::find($tamago_id);
    $user = UserFindByName($username);
    $user_id = $user->id;
    $tamagos = TamagoFindByUserId(intval($user_id));
    if(!empty($tamagos)){
        foreach($tamagos as $myTamago):
            if($myTamago->id == $tamago_id)
            {
                $faim = $myTamago->faim - 5;
                $soif = $myTamago->soif - 5;
                $sommeil = $myTamago->sommeil -5;
                if($myTamago->ennui<=80)    
                {
                    $ennui = $myTamago->ennui + 15;
                    TamagoUpdate($username, $myTamago->id, $myTamago->niveaux, $faim, $soif, $sommeil, $ennui, $myTamago->etat);
                }
            }
        endforeach;
    }
}