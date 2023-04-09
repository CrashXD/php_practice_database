<?php
    require "connection.php";

    if (!isset($_GET['id'])) {
        die("Не передан ID статьи!");
    }

    $query = $database->prepare("SELECT id FROM `articles` WHERE id = ?");
    $query->execute([$_GET['id']]);

    if (!$query->fetch()) {
        die("Статья не найден!");
    }

    // $database->query("DELETE FROM `users` WHERE id = 3");

    $query = $database->prepare("DELETE FROM `articles` WHERE id = ?");
    $query->execute([$_GET['id']]);

    // echo "<a href='index.php'>Вернуться на главную</a>";

    header("Location: /index.php"); // перенаправление на страницу
