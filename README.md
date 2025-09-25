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
Dans le fichier database/database.php ($config) changer les informations de connexions à la base de données avec celles adapter.

---

## Lancement
Lancer le projet avec la commande:
```bash
    php -S localhost:8000 -t .
```

Une fois le projet lancer, entrer dans le navigateur l'adresse suivante: localhost:8000

---

## Utilisation

### 1. Authentification
Un utilisateur doit s’authentifier pour pouvoir créer ou interagir avec un Tamagotchi.

- Inscription : via register.php
- Connexion : via login.php

Les données sont stockées dans la table users.

### 2. Gestion des tamagotchis
- Un utilisateur peut créer un tamagotchi en appuyant sur "créer un tamago", cela va créer automatiquement un tamago et rediriger l'utilisateur vers la liste de c'est tamagotchi.
- Après 9 actions, un Tamagotchi monte de 1 niveau et le compteur repart à zéro.
- Si un besoin tombe à 0 (faim, soif, sommeil, ennui), le Tamagotchi passe en état mort.

---

## Notes
- Le code utilise PDO avec des requêtes préparées pour plus de sécurité.
- Le système est pensé pour être facilement extensible (ajout d’autres actions possibles).