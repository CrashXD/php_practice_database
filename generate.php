<?php
// подключение к базе данных
require "connection.php";

// sql запрос
// $sql = "INSERT INTO `articles` (`title`, `text`) VALUES ('abcd', 'abcdefg')";

/*
$sql = "INSERT INTO `users` (`login`, `password`, `email`, `age`)
        VALUES ('abcd', 'abcd', 'abcd', ?)";
*/

// вызов sql запроса несколько раз
/*
for($i = 0; $i<100; $i++) {
    // $database->query($sql);
    $query = $database->prepare($sql);
    $query->execute([$i]); 
}
*/

// или сперва подготавливаем длинный запрос
// и вызываем его всего один раз

$sql = "INSERT INTO `articles` (`title`, `text`) VALUES ";
$values = '';
for ($i = 0; $i < 100; $i++) {
    $values .= $values ? ', ' : '';
    $title = ucfirst(strtolower(str_shuffle('Random string')));
    $text = ucfirst(strtolower(str_shuffle('Random string')));
    $values .= "('{$title}', '{$text}')";
}
$database->query($sql . $values);
