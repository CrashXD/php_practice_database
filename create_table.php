<?php
require "connection.php";

$sql = "CREATE TABLE IF NOT EXISTS `articles` (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(100) DEFAULT 'Без заголовка',
        text TEXT NOT NULL
    )";
$database->query($sql);

// $sql = "CREATE TABLE IF NOT EXISTS `test4` (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     title VARCHAR(100) DEFAULT 'abcd',
//     description TEXT NOT NULL
// )";
// $database->query($sql);

$sql = "INSERT INTO `articles` (title, text) values ('Заголовок', 'Текст'), ('Заголовок 2', 'Текст 2')";
$database->query($sql);
