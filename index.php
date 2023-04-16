<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // на какой странице мы находимся
    $limit = 10; // количество записей на странице
    $offset = $limit * ($page-1); // смещение, сколько записей пропустить

    $direction = isset($_GET['direction']) ? $_GET['direction'] : 'DESC';

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    require "connection.php";
    // посчитаем количество записей в таблице
    $query = $database->query("SELECT COUNT(*) AS count FROM articles");
    $row = $query->fetch();
    $count = $row['count']; // количество записей

    $pages = ceil($count / $limit); // количество страниц

    $query = $database->prepare("SELECT id, title, text FROM articles WHERE `title` LIKE '%$search%' ORDER BY `id` {$direction} LIMIT ?, ? "); // выполняем запрос
    $query->bindValue(1, $offset, PDO::PARAM_INT); // привязываем значение к параметру
    $query->bindValue(2, $limit, PDO::PARAM_INT);
    $query->execute();
    // foreach ($query as $row) { // перебор возвращенных значений
        // print_r($row);
    // }
    // print_r($query->fetch());
    // while ($row = $query->fetch()) {
    //     print_r($row);
    // }
    $articles = $query->fetchAll();
    // print_r(count($articles));
    // print_r($query->fetchAll(PDO::FETCH_KEY_PAIR));
    // print_r($query->fetchAll(PDO::FETCH_COLUMN));
    // $articles = $query->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);
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
                <a href="insert.php" class="btn btn-success">Добавить новую статью</a>
            </div>
            <div class="col-12 mb-3">
                <h4>Всего записей: <?= $count ?></h4>
                <h4>Текущая страница: <?= $page ?></h4>
            </div>
            <div class="col-12 mb-3">
                <form action="">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="search">
                    </div>
                    <button class="btn btn-success">Найти</button>
                </form>
            </div>
            <div class="col-12 mb-3">
                <form action="">
                    <select class="form-select" name="direction">
                        <option value="DESC" <?= $direction == "DESC" ? 'selected' : ''?>>Самые свежие</option>
                        <option value="ASC" <?= $direction == "ASC" ? 'selected' : ''?>>Самые старые</option>
                    </select>
                    <!-- <input type="hidden" name="page" value="<?= $page ?>" -->
                    <button class="mt-3 btn btn-primary">Сортировать</button>
                </form>
            </div>
            <?php foreach($articles as $article) : ?>
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $article['id'] ?>) <?= $article['title'] ?></h5>
                            <!-- <p class="card-text"><?= $article['text'] ?></p> -->
                            <a href="article.php?id=<?= $article["id"] ?>" class="btn btn-primary">Посмотреть</a>
                            <a href="update.php?id=<?= $article["id"] ?>" class="btn btn-warning">Изменить</a>
                            <a href="delete.php?id=<?= $article["id"] ?>" class="btn btn-danger">Удалить</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-12 mb-5">
                <?php for($i = 1; $i<=$pages; $i++): ?>
                    <a href="index.php?page=<?= $i ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>

</html>