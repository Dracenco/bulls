<?php

$this->createDatabase($this->dbName);
$tableNameLogs = 'logs';
$createTableLogsSql = "CREATE TABLE $tableNameLogs (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        time DATETIME NOT NULL,
                        button_id INT NOT NULL,
                        user_ip VARCHAR(46)
                        )";
$this->createTable($tableNameLogs, $createTableLogsSql);

$tableNameUsers = 'users';
$createTableUsersSql = "CREATE TABLE $tableNameUsers (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        email VARCHAR (255) NOT NULL UNIQUE,
                        password VARCHAR (255) NOT NULL
                        )";

$this->createTable($tableNameUsers, $createTableUsersSql);

