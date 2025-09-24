<?php
namespace Services;

use Models\Tamago;
use Models\User;
use Database\Database;
use Faker\Factory;

class TamagoService {

    public static function createForUser(string $username): Tamago {
        $user = User::getByName($username);
        if (!$user) {
            throw new \Exception("Utilisateur introuvable");
        }

        $faker = Factory::create();
        $tamago = new Tamago();
        $tamago->name = $faker->firstName;
        $tamago->niveaux = 1;
        $tamago->faim = 70;
        $tamago->soif = 70;
        $tamago->sommeil = 70;
        $tamago->ennui = 70;
        $tamago->etat = "vivant";
        $tamago->user_id = $user->id;
        $tamago->actions = 0;
        $tamago->insert();

        return $tamago;
    }

    public static function getByUserId(int $userId): array {
        $rows = Database::fetchAll(
            "SELECT * FROM tamago WHERE user_id = :user_id",
            ['user_id' => $userId]
        );
        return array_map(fn($row) => self::hydrate($row), $rows);
    }

    private static function hydrate(array $data): Tamago {
        $tamago = new Tamago();
        foreach ($data as $key => $value) {
            $tamago->$key = $value; // utilisation du __set
        }
        return $tamago;
    }

    // Actions
    public static function eat(int $tamagoId, string $username): void {
        self::applyAction($tamagoId, $username, fn($t) => [
            'faim' => min(100, $t->faim + 30),
            'soif' => max(0, $t->soif - 10),
            'sommeil' => max(0, $t->sommeil - 5),
            'ennui' => max(0, $t->ennui - 5),
        ]);
    }

    public static function drink(int $tamagoId, string $username): void {
        self::applyAction($tamagoId, $username, fn($t) => [
            'soif' => min(100, $t->soif + 30),
            'faim' => max(0, $t->faim - 10),
            'sommeil' => max(0, $t->sommeil - 5),
            'ennui' => max(0, $t->ennui - 5),
        ]);
    }

    public static function play(int $tamagoId, string $username): void {
        self::applyAction($tamagoId, $username, fn($t) => [
            'ennui' => min(100, $t->ennui + 15),
            'faim' => max(0, $t->faim - 5),
            'soif' => max(0, $t->soif - 5),
            'sommeil' => max(0, $t->sommeil - 5),
        ]);
    }

    public static function sleep(int $tamagoId, string $username): void {
        self::applyAction($tamagoId, $username, fn($t) => [
            'sommeil' => min(100, $t->sommeil + 30),
            'faim' => max(0, $t->faim - 10),
            'soif' => max(0, $t->soif - 15),
            'ennui' => max(0, $t->ennui - 15),
        ]);
    }

    // Helper générique
    private static function applyAction(int $tamagoId, string $username, callable $callback): void {
        $user = User::getByName($username);
        if (!$user) return;

        $tamago = Tamago::getById($tamagoId);
        if (!$tamago || $tamago->user_id !== $user->id) return;

        $updates = $callback($tamago);
        $tamago->updateAttributes($updates);
    }
}
