<?php
// подключение к базе данных
require "connection.php";

// sql запрос
// $sql = "INSERT INTO `articles` (`title`, `text`) VALUES ('abcd', 'abcdefg')";
$sql = "INSERT INTO `users` (`login`, `password`, `email`, `age`)
        VALUES ('abcd', 'abcd', 'abcd', ?)";

// вызов sql запроса
for($i = 0; $i<100; $i++) {
    // $database->query($sql);
    $query = $database->prepare($sql);
    $query->execute([$i]); 
}