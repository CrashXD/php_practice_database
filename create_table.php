<?php
    require "connection.php";

    $sql = "CREATE TABLE IF NOT EXISTS `test123` (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(100) DEFAULT 'abcd',
        description TEXT NOT NULL
    )";
    $database->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `test4` (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(100) DEFAULT 'abcd',
        description TEXT NOT NULL
    )";
    $database->query($sql);

    $sql = "INSERT INTO `test4` (title, description) values ('11', '222'), ('11', '222')";
    $database->query($sql);