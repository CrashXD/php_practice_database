<?php
    require "connection.php";
    // $query = $database->query("SELECT id, title, text FROM articles WHERE id = " . $_GET['id']); // выполняем запрос

    $query = $database->prepare("SELECT id, title, text FROM articles WHERE id = ?"); // подготоваливаем запрос
    // $query = $database->prepare("SELECT id, title, text FROM articles WHERE id = :abc"); // подготоваливаем запрос
    $params = [
        $_GET['id']
    ];
    // $params = [
    //     'abc' => $_GET['id'],
    //     'xyz' => 'sdafljk'
    // ];
    $query->execute($params); // вызываем запрос с параметрами
    $article = $query->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $article['title'] ?></h5>
                            <p class="card-text"><?= $article['text'] ?></p>
                            <a href="index.php" class="btn btn-primary">На главную</a>
                            <a href="update.php?id=<?= $article["id"] ?>" class="btn btn-warning">Изменить</a>
                            <a href="delete.php?id=<?= $article["id"] ?>" class="btn btn-danger">Удалить</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</body>

</html>