# Tamagotchi
Application de gestion de Tamagotchi (animal de compagnie virtuel).

---

## Installation
Installe les dépendances:
```bash
    composer install
```

---

## Configuration
Dans le fichier bdd/database.php ($configBdd) et tamagotchi/pdo.php (getDatabase()) changer les informations de connexions à la base de données avec celles adapter à la votre.

---

## Lancement
Lancer le projet avec la commande:
```bash
    php -S localhost:8000 -t .
```

Une fois le projet lancer, entrer dans le navigateur l'adresse suivante: localhost:8000/connexion/login.php
