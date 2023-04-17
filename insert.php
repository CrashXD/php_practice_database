<?php
require "connection.php";

if (
    isset($_POST['title']) && $_POST['title'] &&
    isset($_POST['text']) && $_POST['text']
) {
    $sql = "INSERT INTO `articles` (`title`, `text`) VALUES (?, ?)";
    $query = $database->prepare($sql);
    $params = [
        $_POST['title'],
        $_POST['text'],
    ];
    $query->execute($params);

    $id = $database->lastInsertId();

    header("Location: article.php?id={$id}");
    die();
}

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
                <h2>Добавить новую статью</h2>
            </div>
            <div class="col-12 mb-3">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Заголовок</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Текст</label>
                        <textarea class="form-control" id="text" name="text"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Добавить статью</button>
                    <a href="/index.php" class="btn btn-secondary">Вернуться назад</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>