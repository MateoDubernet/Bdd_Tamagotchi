<?php
return [
    'columns' => [
        'id' => 'BIGINT PRIMARY KEY AUTO_INCREMENT',
        'name' => 'VARCHAR(30) NOT NULL',
        'niveaux' => 'SMALLINT NOT NULL',
        'faim' => 'SMALLINT NOT NULL',
        'soif' => 'SMALLINT NOT NULL',
        'sommeil' => 'SMALLINT NOT NULL',
        'ennui' => 'SMALLINT NOT NULL',
        'etat' => 'VARCHAR(30) NOT NULL',
        'user_id' => 'BIGINT NOT NULL',
        'actions' => 'SMALLINT NOT NULL',
        'born_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'died_at' => 'TIMESTAMP NULL'
    ],
    'constraints' => [
        'FOREIGN KEY (user_id) REFERENCES users(id)'
    ]
];
