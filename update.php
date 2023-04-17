<?php
require "connection.php";

if (!isset($_GET['id'])) {
    header("Location: /index.php");
    die();
}

$query = $database->prepare("SELECT id, title, `text` FROM `articles` WHERE id = ?");
$query->execute([$_GET['id']]);
$article = $query->fetch();

if (!$article) {
    header("Location: /index.php");
    die();
}

if (
    isset($_POST['title']) && $_POST['title'] &&
    isset($_POST['text']) && $_POST['text']
) {
    $sql = "UPDATE `articles` SET title = ?, `text` = ? WHERE id = ?";
    $query = $database->prepare($sql);
    $params = [
        $_POST['title'],
        $_POST['text'],
        $_GET['id'],
    ];
    $query->execute($params);

    header("Location: article.php?id={$_GET['id']}");
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
                <h2>Изменить статью</h2>
            </div>
            <div class="col-12 mb-3">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Заголовок</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $article['title'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Текст</label>
                        <textarea class="form-control" id="text" name="text" rows="8"><?= $article['text'] ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Изменить статью</button>
                    <a href="/index.php" class="btn btn-secondary">Вернуться назад</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>