<?php
    $host = "127.0.0.1"; // хост
    $dbname = "test"; // название бд
    $port = "3306"; // порт
    $user = "root"; // логин
    $password = ""; // пароль
    $dsn = "mysql:host={$host};dbname={$dbname};port={$port};";

    $options = [ // параметры
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // возврат ассоциативного массива
    ];

    $database = new PDO($dsn, $user, $password, $options); // подключение к бд